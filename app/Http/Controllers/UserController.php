<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Models\LearningRole;
use App\Models\UserProfileDetails;
use App\Helpers\AuthHelper;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserRequest;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\BlockedUser;
use App\Models\Group;
// use Auth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        $pageTitle = trans('global-message.list_form_title',['form' => trans('users.title')] );
        $auth_user = AuthHelper::authSession();
        $assets = ['data-table'];
        $headerAction = '<a href="'.route('users.create').'" class="btn btn-sm btn-primary" role="button">Add User</a>';
        return $dataTable->render('global.datatable', compact('pageTitle','auth_user','assets', 'headerAction'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::where('status',1)->get()->pluck('title', 'id');

        return view('users.form', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $request['password'] = bcrypt($request->password);
        $request['username'] = $request->username ?? stristr($request->email, "@", true) . rand(100,1000);
        $user = User::create($request->all());
        storeMediaFile($user,$request->profile_image, 'profile_image');
        $user->assignRole('user');
        // Save user Profile data...
        $user->userProfile()->create($request->userProfile);
        return redirect()->route('users.index')->withSuccess(trans('users.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::with('userProfile','roles')->findOrFail($id);
        $profileImage = getSingleMedia($data, 'profile_image');
        return view('users.profile', compact('data', 'profileImage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::with('userProfile','roles')->findOrFail($id);

        $data['user_type'] = $data->roles->pluck('id')[0] ?? null;

        $roles = Role::where('status',1)->get()->pluck('title', 'id');

        $profileImage = getSingleMedia($data, 'profile_image');

        return view('users.form', compact('data','id', 'roles', 'profileImage'));
    }

    public function verifiedUser()
    {
        return view('auth.verified');

    }

    // public function update(UserRequest $request, $id)
    public function updateProfile(Request $request)
    {
        if($request->type == 'personalInformation')
        {
            if(isset($request->profile_user_id)){
                $id  = $request->profile_user_id;
            }else{
                $users = auth()->user();
                $id  = $users->id;
            }

            $userdata = UserProfileDetails::where('user_id',  $id)->first();
            $role = Role::find($request->user_role);
            if(env('IS_DEMO')) {
                if($role->name === 'admin') {
                    return redirect('account?change_personal_information=1')->with('errors', 'Permission denied.');
                }
            }
            $userdata->city = $request->get('city');
            $userdata->marital_status = $request->get('marital_status');
            // $userdata->age = $request->get('age');
            $userdata->country = $request->get('country_id');
            $userdata->state = $request->get('state');
            $userdata->save();

            $validator = Validator::make($request->all(), [
                'dob' => 'required|date_format:m/d/Y|before:-18 years',
                // 'dob_month' => 'required|numeric|between:1,12',
                // 'dob_year' => 'required|date_format:Y',
            ]);
            if ($validator->fails()) {
               // return response()->json(['error' => true, 'errortype' => 'dob', 'message'=> 'Please enter valid date of birth.!', 'type' => 'personalInformation']);
                return redirect('account?change_personal_information=1')->with('error', 'Please enter valid date of birth.!');
            }
            if(isset($request->dob)){
                $date = \Carbon\Carbon::createFromFormat('m/d/Y', $request->dob)->format('Y/m/d');
            }


            $user_d = User::where('id', $id)->first();
            $user_d->first_name = $request->get('first_name');
            $user_d->last_name =  $request->get('last_name');
            $user_d->name = $user_d->first_name  . ' ' . $user_d->last_name;

            $user_d->username = $request->input('username');
            $existingUsername = User::where('username', $user_d->username)->where('id', '!=', $user_d->id)->first();
             if ($existingUsername) {
            //     return response()->json(['error' => true, 'errortype' => 'username', 'message'=> 'The username has already been taken.!', 'type' => 'personalInformation']);
            return redirect('account?change_personal_information=1')->with('error', 'The username has already been taken.!');
            }
            $user_d->gender = $request->get('gender');
             $user_d->dob = $date;
            $user_d->address = $request->get('address');
            $user_d->zip_code = $request->get('zip_code')  ?? null;
            $user_d->role_id = $request->get('role_id') ?? 0 ;
            $user_d->email_event_reminder = $request->get('email_event_reminder') ?? 0 ;
            $user_d->email_general_info = $request->get('email_general_info') ?? 0 ;
            $user_d->email_marketing_events_courses = $request->get('email_marketing_events_courses') ?? 0 ;
            $user_d->save();
            return redirect('account?change_personal_information=1')->with('success', 'Personal Information updated successfully');
            // return response()->json(['success' => true, 'message' => 'Personal Information updated successfully!', 'userdata' => $user_d, 'type' => 'personalInformation'], 200);
        }
        if($request->type == 'manageContact')
        {
            if(isset($request->profile_user_id)){
            $id  = $request->profile_user_id;
            }else{
            $users = auth()->user();
            $id  = $users->id;
            }

            $user_d = User::where('id', $id)->first();
            $user_d->phone = $request->get('phone');
            $user_d->website = $request->get('website');
            $user_d->save();
          return redirect('account?manage_contact=1')->with('success','Contact information updated successfully!');

            // return response()->json(['success' => true, 'message' => 'Contact information updated successfully!', 'userdata' => $user_d, 'type' => 'manageContact'], 200);
        }
        if($request->type == 'changePassword')
        {
            // $request->validate([
            //     'old_password' => 'required',
            //     'new_password' => 'required|min:8',
            // ]);

            // $user = Auth::user();

            // if (Hash::check($request->old_password, $user->password)) {
            //     $user->password = Hash::make($request->new_password);
            //     $user->save();

            //     return redirect('/')->with('success', 'Password changed successfully.');
            // } else {
            //     return back()->withErrors(['old_password' => 'The old password you entered is incorrect.'])->withInput();
            // }

            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
            ]);
            if ($validator->fails()) {
               $messages= $validator->messages()->first();
                return redirect('account?change_password=1')->with('error',$messages);
            }

            $user = Auth::user();
            $hashedPassword = $user->password;

            if (Hash::check($request->current_password, $hashedPassword)) {
                $user->fill([
                    'password' => Hash::make($request->new_password)
                ])->save();

                Auth::guard('web')->login($user);
                return redirect('account?change_password=1')->with('success', 'Password changed successfully.');
                // return response()->json(['success' => true, 'message' => 'Password changed successfully.', 'userdata' => $user, 'type' => 'changePassword'], 200);
            }
            return redirect('account?change_password=1')->with(['error' => 'The provided password does not match your current password.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $status = 'errors';
        $message= __('global-message.delete_form', ['form' => __('users.title')]);

        if(isset($user->id)) {
            $user->delete();
            $status = 'success';
            $message= __('global-message.delete_form', ['form' => __('users.title')]);
        }

        if(request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status,$message);

    }

    public function getUserData()
    {
        $id = 1;
        $data['user'] = User::where('id', $id)->first(array('id','first_name','last_name','email','phone','address','gender','dob','country_id','allow_on_dvm','allow_on_vt_friend','allow_on_vetandtech'));
        return response()->json($data, 200);
    }

    public function searchUsers(Request $request)
    {
        $filter = (array) array_merge(['keywords' => @$request->search_input], $request->except('search_input'));
        $searchData = $this->getUsers($filter);
        return response()->json(['searchData' => $searchData ], 200);
    }

    public function allowUser($email){
        $user = User::where('email',$email)->first();
        $user->allow_on_vt_friend = 1;
        $user->save();
        if($user->email_verified_at == null){
            (new User())->verificationEmail($user);
            return response()->json(['message' => 'Registered on Colorful CE successfully. Please check your email and verify before sign in.'], 200);
        }
        return response()->json(['message' => 'Registered on Colorful CE successfully. Please enter your credentials to sign in'], 200);
    }

    public function delete(Request $request){
        $user = User::find($request->userId);
        $user->soft_delete = 1;
        $user->deleted_at = now();
        $user->save();

        //logout user after account inactivate
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->withErrors(['msg' => 'Account deleted successfully. You can recover your account within 60 days.']);
    }

    public function privacy(Request $request){
        $userProfileData = UserProfileDetails::where('user_id', auth()->user()->id)->first();
        if($userProfileData){
            $userProfileData->your_profile = $request->your_profile ? $request->your_profile: 'public';
            $userProfileData->story_sharing = $request->story_sharing;
            $userProfileData->your_message = $request->your_message ? $request->your_message: 'anyone';
            $userProfileData->account_privacy = $request->account_privacy ? $request->account_privacy: 0;
            if($request->login_notification == null){
                $userProfileData->content_notification = $request->login_notification ? $request->login_notification: 'enable';
            }
            $userProfileData->save();
                return response()->json(['success' => true, 'type' => 'privacySetting', 'message' => 'Privacy Settings updated successfully!', 'userdata' => $userProfileData], 200);
        }
    }

      public function update(UserRequest $request, $id)
    {

        if($request->type == 'personalInformation'){
            if(isset($request->profile_user_id)){
            $id  = $request->profile_user_id;
            }else{
            $users = auth()->user();
            $id  = $users->id;
            }

            $userdata = UserProfileDetails::where('user_id',  $id)->first();
            $role = Role::find($request->user_role);
            if(env('IS_DEMO')) {
                if($role->name === 'admin') {
                    return redirect()->back()->with('errors', 'Permission denied.');
                }
            }
            $userdata->city = $request->get('city');
            $userdata->marital_status = $request->get('marital_status');
            // $userdata->age = $request->get('age');
            $userdata->country = $request->get('country_id');
            $userdata->state = $request->get('state');
            $userdata->save();

            $validator = Validator::make($request->all(), [
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

               return redirect()->back()->with('error', 'Please enter valid date of birth.!');
            }
            if(isset($request->dob)){
                $date = \Carbon\Carbon::createFromFormat('m/d/Y', $request->dob)->format('Y/m/d');
            }
            $user_d = User::where('id', $id)->first();
            $user_d->first_name = $request->get('first_name');
            $user_d->last_name =  $request->get('last_name');
            $user_d->name = $user_d->first_name  . ' ' . $user_d->last_name;

            // username work start for User table
            $user_d->username = $request->input('username');
            // $existingUsername = User::where('username', $user_d->username)->where('username', '!==', $user_d->username)->first();
            $existingUsername = User::where('username', $user_d->username)->where('id', '!=', $user_d->id)->first();
            if ($existingUsername) {
               return redirect()->back()->with('error', 'The username has already been taken.!');
            }
            // username work end for User table
            $user_d->gender = $request->get('gender');
            $user_d->dob = $date;
            $user_d->address = $request->get('address');
            $user_d->zip_code = $request->get('zip_code')  ?? null;
            $user_d->role_id = $request->get('role_id') ?? 0 ;
            $user_d->email_event_reminder = $request->get('email_event_reminder') ?? 0 ;
            $user_d->email_general_info = $request->get('email_general_info') ?? 0 ;
            $user_d->email_marketing_events_courses = $request->get('email_marketing_events_courses') ?? 0 ;
            $user_d->save();
           return redirect()->back()->with('success', 'Personal Information updated successfully');
        }
    }

    public function account(Request $request)
    {
        if($request->query('user_id')){
            $id  =$request->query('user_id');
            $type='team_member';
            $user = User::where('id', $id)->first();
        }else{
           $user = auth()->user();
           $id  = $user->id;
           $type='';
        }
        $roles=LearningRole::where('status','Y')->pluck('name','id');
        $users = UserProfileDetails::where('user_id',  $id)->first();
        $data['country'] = Country::all()->pluck('name','id');
        $data['states'] = State::where('id',$users->state)->pluck('name','id');
        $data['dob'] = explode('-', $user->dob);
        $data['type'] = $type;
        $data['roles'] = $roles;
        $data['user_id'] = $id;
        $data['team_id'] = $request->query('team_id');
        return view('dashboards.profile', compact('users', 'data','user'));
    }

    public function get_states(Request $request)
    {
        $states = State::select('id', 'name', 'iso2')->where('country_id', $request->input('country_id'))->orderBy('name', 'asc')->get();
        if(count($states) > 0)
        {
            return ['status' => '1', 'data' => $states];
        }
        return ['status' => '0'];
    }

    public function profileedit(Request $request)
    {

        if($request->query('user_id')){
         $id  =$request->query('user_id');
         $type='team_member';
         $user = User::where('id', $id)->first();
        }else{
        $user = auth()->user();
        $id  = $user->id;
        $type='';
        }

        $roles=LearningRole::where('status','Y')->pluck('name','id');
        $users = UserProfileDetails::where('user_id',  $id)->first();
        $data['country'] = Country::all()->pluck('name','id');
        $data['states'] = State::where('id',$users->state)->pluck('name','id');
        $data['dob'] = explode('-', $user->dob);
        $data['type'] = $type;
        $data['roles'] = $roles;
        $data['user_id'] = $id;
        $data['team_id'] = $request->query('team_id');
        return view('dashboards.profileedit', compact('users', 'data','user'));
    }

}

