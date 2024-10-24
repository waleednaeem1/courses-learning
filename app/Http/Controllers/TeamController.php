<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;
use App\Models\UserProfileDetails;
use Illuminate\Support\Facades\Hash;
use App\Models\UserAlbum;
use App\Models\LearningRole;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
  public function index()
    {
        $users = auth()->user();
        $id  = $users->id;
        $team = Team::with('user.learningRole')->where('added_by',  $id)->get();
        $trashUsers = Team::onlyTrashed()->with('user.learningRole')->where('added_by',  $id)->get();
        $roles=LearningRole::where('status','Y')->get();
        return view('team.team', compact('team','roles','trashUsers'));
    }

    public function addColleague(Request $request){
        if(isset($request->email) && $request->email == auth()->user()->email){
            return response()->json(['msg'=> 'You cannot use your email as a team member email', 'data'=> $this->refreshColleague()],200);
        }

        $user = User::where('email', $request->email)->first();
        if(isset($user) && $user->soft_delete == 1){
            return response()->json(['msg' => 'The account has been deleted. To activate your account, please contact the administrator.']);
        }
        $validator = Validator::make($request->all(),[
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'role_id' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:30|unique:users',
        ]);

        if ($validator->fails())
        {
            $errors = $validator->errors();
            return response()->json(['errors' => $errors], 422);
        }

        //if user already exists then restore to the team
        if($user)
        {
            $team = Team::withTrashed()->where('user_id',$user->id)->where('added_by',Auth::user()->id)->first();
            if($team && $team->deleted_at)
            {
                $team->restore();
                return response()->json(['msg'=> 'User already exits so reassign to the Team', 'data' => $this->refreshColleague()],200);
            }
            else if(!$team)
            {
                Team::Create([
                    'user_id' => $user->id,
                    'added_by' => Auth::user()->id,
                    'is_coach' =>($request->is_coach=='on') ? 1:0,
                ]);
                 return response()->json(['msg'=> 'User added to the team', 'data' => $this->refreshColleague()],200);
                //return redirect()->back()->with('success', 'User added to the team.');
            }
            else{
                 return response()->json(['msg'=> 'User already in the Team']); // user in the team
                //return redirect()->back()->with('success', 'User already in the Team.'); // user in the team
            }
        }


        $existingUsername = User::where('username', $request->username)->first();
        if ($existingUsername) {
            //return back()->withInput()->withErrors(['username' => 'The username has already been taken.!']);
            return response()->json(['error' => true, 'errortype' => 'username', 'message'=> 'The username has already been taken.!', 'type' => 'personalInformation']);
        }

        $string=Str::random(10);
        $hashed_random_password = Hash::make($string);
        $data = [
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'allow_on_vt_friend' => 1,
            'role_id' => $request->role_id,
            'password' => $hashed_random_password,
            'email_verified_at'=>null
        ];

        $user = User::create($data);
        (new User())->verificationEmail($user,'login_info',$string,($request->is_coach=='on') ? 1:0);
        $profile = new UserProfileDetails([
            'user_id' => $user->id,
            'marital_status' => 'Don’t want to specify',
            'your_profile' => 'public',
            'content_notification' => 'enable',
            'your_message' => 'anyone',
            'language_eng' => 1
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
        $data = [
            'user_id' => $user->id,
            'is_coach' =>($request->is_coach=='on') ? 1:0,
            'added_by'=>auth()->user()->id
        ];
        Team::create($data);
        // return redirect()->route('team')->withSuccess(__(__('Registered successfully, please check your email and verfiy it before proceeding to login...!')));
        return response()->json(['msg'=> 'Registered successfully, please check your email and verfiy it before proceeding to login...!', 'data'=> $this->refreshColleague()],200);
    }

    public function changeCoach($id){
        $team=Team::find($id);
        $is_coach = $team->is_coach ==1 ? 0: 1;
        $team->is_coach=$is_coach;
        $team->save();
        return response()->json(['msg'=> 'Coach Access has been changed!']);
    }

    // public function removeUser($id){
    //     // dd($id);
    //     Team::find($id)->delete();
    //     return redirect()->back()->withSuccess(__(__('User has been removed from Team!')));
    // }

    public function profileDetail($id){
        $team = Team::with('user.learningRole')->withTrashed()->where('id',  $id)->first();
        return view('team.teamProfile', compact('team'));
    }
    //for restore team
    public function restoreUser(Request $request,$id)
    {

       if($request->status == "unassign")
        {
            $team = Team::find($id);
            $user = User::find($team->user_id);
            if($team){
                $team->delete();
            }
            return response()->json(['msg'=>'You have removed '.$user->first_name.' '.$user->last_name.' from your Team!','status' => 'assign','title' => 'Reassign User',],200);
        }
        else if($request->status == "assign")
        {
            Team::withTrashed()->find($id)->restore();
            $team = Team::find($id);
            $user = User::find($team->user_id);
            return response()->json(['msg'=>'You have added '.$user->first_name.' '.$user->last_name.' from your Team!','status' => 'unassign','title' => 'Unassign User',],200);
        }else{
           Team::withTrashed()->find($id)->restore();
        }

        return response()->json(['msg'=>'User has been added to the Team!','data'=> $this->refreshColleague(),],200);
    }

    public function refreshColleague()
    {
        $user = auth()->user();
        $id  = $user->id;
        return Team::with('user.learningRole')->where('added_by',  $id)->latest('updated_at')->first();
    }
}
