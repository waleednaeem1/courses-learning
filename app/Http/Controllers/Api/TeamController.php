<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;
use App\Models\UserProfileDetails;
use Illuminate\Support\Facades\Hash;
use App\Models\UserAlbum;
use App\Models\LearningRole;
use App\Models\State;
use App\Models\Country;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function index($users_id)
    {
        $users = User::find($users_id);
        $id  = $users->id;
        $data['team'] = Team::with('user.learningRole')->where('added_by',  $id)->get();
        $data['trashUsers'] = Team::onlyTrashed()->with('user.learningRole')->where('added_by',  $id)->get();
        $data['roles'] = LearningRole::where('status','Y')->get();

        return response()->json([
            'data' => $data, 
            'success' => true
        ], 200);
    }

    public function addColleague(Request $request){
        $user = User::where('email', $request->email)->first();
        $authUser = User::find($request->user_id);
   
           if(isset($user) && $user->soft_delete == 1){
                return response()->json([
                    'msg' => 'The account has been deleted. To activate your account, please contact the administrator.'
                ],201 );
           }
   
         $validator = Validator::make($request->all(),[
               'first_name' => 'required|string|max:255',
               'last_name' => 'required|string|max:255',
               'username' => 'required|string|max:30|unique:users',
           ]);
           
           //if user already exists then restore to the team
           if($user)
           {
               $team = Team::withTrashed()->where('user_id',$user->id)->where('added_by',$authUser->id)->first();
               if($team && $team->deleted_at)
               {
                    $team->restore();
                    return response()->json([
                        'msg'=> 'User already exits so reassign to the Team', //if soft delete
                        'data' => $this->refreshColleague($authUser)
                    ],200);
   
               }
               else if(!$team)
               {
                    Team::Create([
                        'user_id' => $user->id,
                        'added_by' => $authUser->id,
                        'is_coach' =>($request->is_coach=='on') ? 1:0,
                    ]);
                    return response()->json([
                        'msg'=> 'User added to the team',
                        'data' => $this->refreshColleague($authUser)
                    ],200);
               }
               else{
                    return response()->json([
                        'success' => false, 
                        'msg'=> 'User already in the Team'
                    ], 201);
               }
               
   
               
           }
          
           if ($validator->fails()) {
               $errors = $validator->errors();
               return response()->json(['errors' => $errors], 422);
           }
   
           $existingUsername = User::where('username', $request->username)->first();
               if ($existingUsername) {
                    return response()->json([
                        'success' => false, 
                        'msg'=> 'The username has already been taken.!'
                    ], 201);
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
                   'added_by'=>$authUser->id
               ];
   
           Team::create($data);

           return response()->json([
                'msg'=> 'Registered successfully, please check your email and verfiy it before proceeding to login...!',
                'data'=> $this->refreshColleague($authUser)
            ],200);
   
    }

    public function changeCoach($id, $user_id){
        $team=Team::find($id);
        if(!$team){
            return response()->json([
                'msg'=> 'User not found!',
                'data'=> $this->refreshchangeCoach($user_id)
            ],200);
        }
       if($team->is_coach==1){
            $is_coach=0;
        }else{
            $is_coach=1;
        }
   
        $team->is_coach=$is_coach;
        $team->save();
        
        return response()->json([
            'msg'=> 'Coach Aceess has been changed!',
            'data'=> $this->refreshchangeCoach($user_id)
        ],200);
    }

    public function profileDetail($id){
        $data = Team::with('user.learningRole')->withTrashed()->where('id',  $id)->first();
        return response()->json([
            'data' => $data
        ],200);
    }

    public function restoreUser(Request $request)
    {
        if($request->status == "unassign")
        {
            Team::find($request->id)->delete();
            return response()->json([
                'msg'=>'User has been removed from Team!',
                'status' => 'assign',
                'title' => 'Reassign User',
            ],200);

        }else if($request->status == "assign")
        {
            Team::withTrashed()->find($request->id)->restore();
            return response()->json([
                'msg'=>'User has been added to the Team!',
                'status' => 'unassign',
                'title' => 'Unassign User',
            ],200);

        }

        Team::withTrashed()->find($request->id)->restore();
        return response()->json([
            'msg'=>'User has been added to the Team!',
            'data'=> $this->refreshchangeCoach($request->user_id),
        ],200);

    }

    public function teamUserEdit(Request $request){
        $id  =$request->user_id;
        $type='team_member';
        $data['user'] = User::where('id', $id)->first(); // user
   
        $roles=LearningRole::where('status','Y')->pluck('name','id');
        $data['users'] = UserProfileDetails::where('user_id',  $id)->first(); // users

        $data['country'] = Country::all()->pluck('name','id');
        $data['states'] = State::where('id',$data['users']->state)->pluck('name','id');
        $data['dob'] = explode('-', $data['user']->dob);
        $data['type'] = $type;
        $data['roles'] = $roles;
        $data['user_id'] = $id;
        $data['team_id'] = $request->team_id;

        return response()->json([
            'data'=> $data,
        ],200);
    }


    public function teamUserUpdate(Request $request)
    {
        $id  = $request->profile_user_id;

        $userdata = UserProfileDetails::where('user_id',  $id)->first();
        $role = Role::find($request->user_role);
        
        $userdata->city = $request->get('city');
        $userdata->marital_status = $request->get('marital_status');
        $userdata->country = $request->get('country_id');
        $userdata->state = $request->get('state');
        $userdata->save();

        $validator = Validator::make($request->all(), [
            'dob' => 'required|date_format:m/d/Y|before:-18 years',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => true, 
                'errortype' => 'dob', 
                'message'=> 'Please enter valid date of birth.!'
            ]); 
        }

        if(isset($request->dob)){
            $date = \Carbon\Carbon::createFromFormat('m/d/Y', $request->dob)->format('Y/m/d');
        }
        
        $data['userData'] = User::where('id', $id)->first();
        $data['userData']->first_name = $request->get('first_name');
        $data['userData']->last_name =  $request->get('last_name');
        $data['userData']->name = $data['userData']->first_name  . ' ' . $data['userData']->last_name;

        $data['userData']->username = $request->input('username');
        $existingUsername = User::where('username', $data['userData']->username)->where('id', '!=', $data['userData']->id)->first();
        
        if ($existingUsername) {
            return response()->json([
                'success' => false,
                'error' => true, 
                'errortype' => 'username', 
                'message'=> 'The username has already been taken.!'
            ]);
        }

        $data['userData']->gender = $request->get('gender');
        $data['userData']->dob = $date;
        $data['userData']->address = $request->get('address');
        $data['userData']->zip_code = $request->get('zip_code')  ?? null;
        $data['userData']->role_id = $request->get('role_id') ?? 0 ;
        $data['userData']->email_event_reminder = $request->get('email_event_reminder') ?? 0 ;
        $data['userData']->email_general_info = $request->get('email_general_info') ?? 0 ;
        $data['userData']->email_marketing_events_courses = $request->get('email_marketing_events_courses') ?? 0 ;
        $data['userData']->save();
        
        return response()->json([
            'success' => true, 
            'message' => 'Personal Information updated successfully!', 
            'data' => $data
        ], 200);
        
    }

    public function refreshColleague($authUser)
    {
        $user = $authUser;
        $id  = $user->id;
        return Team::with('user.learningRole')->where('added_by',  $id)->latest('updated_at')->first();
    }

    public function refreshchangeCoach($users_id)
    {
        $users = User::find($users_id);
        $id  = $users->id;
        $data['team'] = Team::with('user.learningRole')->where('added_by',  $id)->get();
        $data['trashUsers'] = Team::onlyTrashed()->with('user.learningRole')->where('added_by',  $id)->get();
        $data['roles'] = LearningRole::where('status','Y')->get();

        return $data;
    }
}
