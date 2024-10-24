<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAlbum;
use App\Models\UserProfileDetails;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use App\Models\UserPractice;
class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }
    protected $redirectTo = '/login';
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if($request->dob == null){
            return back()->with(['msg' => 'Date of Birth is required.']);
        }
        if(env('IS_DEMO')==true) {
            return redirect()->back()->with('msg', "Permission denied you are in demo mode.");
        }
        $user = User::where('email', $request->email)->first();
        if(isset($user) && $user->soft_delete == 1){
            return back()->with(['msg' => 'The account has been deleted. To activate your account, please contact the administrator.']);
        }

        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:30|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'dob' => 'required|date_format:m/d/Y|before:-18 years',
            // 'dob_month' => 'required|numeric|between:1,12',
            // 'dob_year' => 'required|date_format:Y',
        ]);
        // $validator->after(function ($validator) use ($request) {
        //     $date = $request->dob_year.'-'.$request->dob_month.'-'.$request->dob_day;
        //     if (!checkdate($request->dob_month, $request->dob_day, $request->dob_year)) {
        //         $validator->errors()->add('dob_day', 'Invalid date of birth');
        //     }
        // });
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            //return redirect()->back()->with(Input::all());
        }

        if(isset($request->dob)){
            $date = \Carbon\Carbon::createFromFormat('m/d/Y', $request->dob)->format('Y/m/d');
        }
        $existingUsername = User::where('username', $request->username)->first();
        if ($existingUsername) {
            return back()->withInput()->with(['msg' => 'The username has already been taken.!']);
        }
        if($request->allow_on_dvm == null)
            $request->allow_on_dvm =0;
        if($request->allow_on_vetandtech == null)
            $request->allow_on_vetandtech =0;
        if($request->allow_on_vt_friend == null)
            $request->allow_on_vt_friend =0;
        // Create a new user record
        $data = [
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'dob' => $date,
            'gender' => $request->gender,
            'register_from_colorful' => 1,
            'allow_on_dvm' => $request->allow_on_dvm,
            'allow_on_vetandtech' => $request->allow_on_vetandtech,
            'allow_on_vt_friend' => $request->allow_on_vt_friend,
            'password' => Hash::make($request->password),
            'accept_terms' => $request->customCheck1
        ];

        $user = User::create($data);

        (new User())->verificationEmail($user);

            if($user){
             $practice = new UserPractice([
                'user_id' => $user->id,
             ]);
             $practice->save();
        }

        if($request->allow_on_vt_friend == 1){
            // Create a new profile record for the user
            $profile = new UserProfileDetails([
                'user_id' => $user->id,
                'marital_status' => 'Don’t want to specify',
                'your_profile' => 'public',
                'content_notification' => 'enable',
                'your_message' => 'anyone',
                'language_eng' => 1   // default language
            ]);

            $profile->save();
            $imageDirForCoverAlbum = dirname(getcwd()).'/storage/app/public/images/album-img/'.$user->id.'/'.'Cover';
            if(!is_dir($imageDirForCoverAlbum))
            {
                mkdir($imageDirForCoverAlbum, 0777, true);
            }

            $imageDirForPhotoAlbum = dirname(getcwd()).'/storage/app/public/images/album-img/'.$user->id.'/'.'Profile';
            if(!is_dir($imageDirForPhotoAlbum))
            {
                mkdir($imageDirForPhotoAlbum, 0777, true);
            }
            $coverPhotoAlbum = [
                'album_name' => "Cover",
                'user_id' => $user->id,
                'status' => 'Y',
            ];
            $createCoverAlbum = UserAlbum::create($coverPhotoAlbum);

            $profilePhotoAlbum = [
                'album_name' => "Profile",
                'user_id' => $user->id,
                'status' => 'Y',
            ];
            $createProfileAlbum = UserAlbum::create($profilePhotoAlbum);
        }

        // Auth::login($user);

        // event(new Registered($user));

        if($user->email_verified_at == '' || $user->email_verified_at == null){
            return redirect('/login')->with(['msg'=> "Registered successfully, please check your email for verification before proceeding to login...!"]);
        }
        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectTo)->with('message', 'Registered successfully, please login...!');
    }
}
