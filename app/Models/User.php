<?php

namespace App\Models;

use App\Domains\Auth\Notifications\Frontend\ResetPasswordNotification;
use App\Models\Friend;
use App\Notifications\Frontend\Auth\UserNeedsVerification;
use App\Notifications\Frontend\Course\UserCourseComplete;
use App\Notifications\Frontend\Auth\UserLoginInformation;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements MustVerifyEmail
{
    // use HasFactory, Notifiable, HasRoles, InteractsWithMedia;
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public static $months = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'name',
        'phone',
        'status',
        'banned',
        'email',
        'password',
        'dob',
        'gender',
        'allow_on_vt_friend',
        'allow_on_dvm',
        'allow_on_vetandtech',
        'register_from_colorful',
        'role_id',
        'zip_code',
        'email_event_reminder',
        'email_general_info',
        'email_marketing_events_courses'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function userProfile() {
        return $this->hasOne(UserProfile::class, 'user_id', 'id');
    }

    public function learningRole() {
        return $this->hasOne(LearningRole::class, 'id', 'role_id');
    }
    // public function getfriends(){
    //     return $this->hasOne()(Friend::class, 'user_id', 829);
    // }
    public function getfriends(){
        return $this->hasMany(Friend::class)->select('user_id', 'friend_id');
    }

    public function getfriendrequest(){
        return $this->hasMany(FriendRequest::class)->select('id','user_id', 'friend_id')->where('status', 'pending');
    }

    public function userProfileImages()
    {
        return $this->hasMany(UserProfileImage::class, 'user_id', 'id');
    }

    public function stories()
    {
        return $this->hasMany(Feed::class, 'user_id')->where( 'is_deleted', '!=', 1)->where('type', 'story')->select('id','user_id','slug','type','post', 'visibility', 'created_at', 'updated_at')->orderByDesc('id');
    }
    public function getAllFriends($filter = [])
    {
        if(isset($filter['user_id']))
            $user_id = $filter['user_id'];
        else
            $user_id = auth()->user()->id;
        $friend_ids1 = $this->getfriends->pluck('friend_id')->toArray();
        $friend_ids2 = Friend::where('friend_id', $user_id)->pluck('user_id')->toArray();
        $friend_ids = array_merge($friend_ids1, $friend_ids2);
        if(isset($filter['cmd']) && $filter['cmd'] == 'only_ids')
            return $friend_ids;
        $query = self::whereIn('id', $friend_ids);
        if(isset($filter['sort']))
            $query->orderBy($filter['sort'], $filter['order']);
        else
            $query->orderBy('first_name')->orderBy('last_name');
        //$query->get();
        $friends = $query->orderBy('created_at', 'DESC')->get();//self::whereIn('id', $friend_ids)->orderBy('first_name')->orderBy('last_name')->get();
        return $friends;
    }

    public function getBirthdays()
    {
        $friends = $this->getAllFriends();
        $dobs = [];
        foreach($friends as $friend)
        {
            if($friend->dob)
            {
                $stt = strtotime($friend->dob);

                $month = date('m', $stt);
                $day = date('d', $stt);

                if($month < date('m')) continue; // need to change this logic
                // put past month's birthdays at the end, means, show them in next year

                $dobs[$month][$day] = $friend;
            }
        }

        ksort($dobs);

        foreach($dobs as $month => $friends)
        {
            ksort($friends);
            $dobs[$month] = $friends;
        }

        return $dobs;
    }

    public function getFeeds($filter = [])
    {
        $filter['cmd'] = 'only_ids';
        $friend_ids = $this->getAllFriends($filter);
        $friend_ids[] = auth()->user()->id;
        $feeds = Feed::whereIn('user_id', $friend_ids)->where(['type' => 'feed', 'status' => 'Y'])->orderBy('created_at', 'desc')->get();
        return $feeds;
    }

    public function verificationEmail($customer,$type='',$password='',$is_coach='')
    {
       $user = User::find($customer->id);
       if($type){
       $user->notify(new UserLoginInformation($user->confirmation_code,$user,$password,$is_coach));
       }else{
       $user->notify(new UserNeedsVerification($user->confirmation_code,$user));
      }

    }

     public function courseCompleteEmail($user,$course,$attach)
    {
     $user->notify(new UserCourseComplete($user,$course,$attach));
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function getRecentlyAddedFriends($filter = [])
    {
        if(isset($filter['user_id']))
            $user_id = $filter['user_id'];
        else
            $user_id = auth()->user()->id;
        $friend_ids1 = $this->getRecentlyAddedFriendsIds->pluck('friend_id')->toArray();
        $date = date('Y-m-d h:i:s', strtotime('-30 Days'));
        $friend_ids2 = Friend::where('friend_id', $user_id)->where('created_at', '>=', $date)->pluck('user_id')->toArray();
        $friend_ids = array_merge($friend_ids1, $friend_ids2);
        if(isset($filter['cmd']) && $filter['cmd'] == 'only_ids')
            return $friend_ids;
        $query = self::whereIn('id', $friend_ids);
        if(isset($filter['sort']))
            $query->orderBy($filter['sort'], $filter['order']);
        else
            $query->orderBy('first_name')->orderBy('last_name');
        //$query->get();
        $friends = $query->get();//self::whereIn('id', $friend_ids)->orderBy('first_name')->orderBy('last_name')->get();
        return $friends;
    }
    public function getRecentlyAddedFriendsIds(){
        $date = date('Y-m-d h:i:s', strtotime('-30 Days'));
        return $this->hasMany(Friend::class)->select('user_id', 'friend_id')->where('created_at', '>=', $date);
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function cartItems()
    {
        return $this->hasMany('App\Models\CartItem','customer_id');
    }
}
