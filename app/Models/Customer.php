<?php

namespace App\Models;

use App\Mail\Backend\Customer\SendWelcome;
use App\Mail\Backend\Customer\SendWelcomeVetandtech;
use App\Mail\Frontend\Newsletter\SendSubscriptionWithCoupon;
use App\Models\Auth\User;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use App\Notifications\Frontend\Auth\UserNeedsConfirmationVetAndtech;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\HasApiTokens;
class Customer extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    //protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    // use HasApiTokens;
    protected $hidden = [ 'created_at', 'updated_at' ];

    public $types = [
        'admin' => 'Admin',
        'customer' => 'Customer',
        'user' => 'User',
        'staff' => 'Staff',
        'vendor' => 'Vendor',
        'attendee' => 'Attendee',
    ];

    public function socialId()
    {
        return $this->hasMany(SocialId::class, 'user_id');
    }

    public function friends()
    {
        return $this->hasMany(Friend::class, 'user_id');
    }

    public function feeds()
    {
        return $this->hasMany(Feed::class, 'user_id')->where('type', 'feed')->select('id','user_id','slug','type','post')->where('is_deleted','!=' , '1')->limit(18);
    }

    public static function getCustomers(array $filter = [])
    {
        $query = self::where('type', '=', 'customer');

        if(!isset($filter['limit']))
        {
            $filter['limit'] = 10;
        }

        $query->orderBy('id', 'desc');

        $result = $query->paginate($filter['limit']);

        return $result;
    }

    public static function pluckCustomers()
    {
        $query = self::where('type','customer');

        $query->select('id', 'name', 'email');

        $query->orderBy('id', 'desc');

        $result = $query->get()->toArray();

        $return = [];

        foreach($result as $row)
        {
            $return[$row['id']] = $row['name'] . ' (' . $row['email'] . ')';
        }

        return $return;
    }

    public function group()
    {
        return $this->belongsTo('App\Models\Groups');
    }

    public function followers()
    {
        return $this->hasMany('App\Models\UserFollow', 'user_id');
    }

    public function customer_level()
    {
        return $this->belongsTo('App\Models\Level' , 'level');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function vendor()
    {
        return $this->hasOne('App\Models\Vendor', 'user');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function cartItems()
    {
        return $this->hasMany('App\Models\CartItem');
    }

    public function following()
    {
        return $this->hasMany(Follow::class, 'user_id')->count();
    }

    public function documents()
    {
        return $this->hasMany(UserDocument::class, 'user_id')->count();
    }

    public function welcome_email($customer)
    {
        $data                   = new \stdClass();
        $data->first_name       = $customer->first_name;
        $data->last_name        = $customer->last_name;
        $data->login_link       = url('/').'/login';
        $data->catalog_link     = url('/');

        Mail::to($customer->email)->send(new SendWelcome($data));
    }

    public function welcome_email_vetandtech($customer){
        $data                   = new \stdClass();
        $data->first_name       = $customer->first_name;
        $data->last_name        = $customer->last_name;

        Mail::to($customer->email)->send(new SendWelcomeVetandtech($data));
    }

    public function confirmation_email($customer)
    {
        $user = User::find($customer->id);
        $user->notify(new UserNeedsConfirmation($user->confirmation_code));
    }

    public function confirmation_email_vetandtech($customer)
    {
        $user = User::find($customer->id);
        $user->notify(new UserNeedsConfirmationVetAndTech($user->confirmation_code));
    }

    public static function logged_in()
    {
        if(Auth::check())
        {
            if(Auth::user()->type != 'customer')
                return false;
            else
            {
                $user = Auth::user();
                return Customer::find($user->id);
            }
        }
        else
            return false;
    }

    public static function admin_check()
    {
        if(Auth::check())
        {
            if(Auth::user()->type != 'admin')
                return false;
            else
            {
                $user = Auth::user();
                return Customer::find($user->id);
            }
        }
        else
            return false;
    }

    public static function getCustomerName($id)
    {
        if($id != 0){
            $customer = self::select(['name'])->where(['id' => $id])->first();
            if($customer)
                return $customer->name;
            else
                return false;
        }else{
            return 'Guest User';
        }
    }

    public static function getCustomerEmail($id)
    {
            $customer = self::select(['email'])->where(['id' => $id])->first();
                return $customer->email;
    }

    public static function checkAccountWithEmail($email)
    {
        $customer = self::select(['id', 'name'])->where(['email' => $email, 'type' => 'customer'])->first();
        if($customer)
            return ['status' => 1, 'name' => $customer->first_name.' '.$customer->last_name];
        else
            return ['status' => 2];
    }

    public static function getCustomerOrders($data)
    {
        $orders = Order::select('id', 'name','grand_total')->where('customer_id', $data['customer_id'])->get();

        $return = [];

        if(count($orders) > 0)
        {
            if(isset($data['request']) && $data['request'] == 'ajax')
            {
                foreach($orders as $order)
                {
                    $return[] = ['id' => $order->id, 'title' => $order->id . ' - '. $order->first_name . ' ' . $order->last_name .' - ($'. number_format($order->grand_total, 2) .')'];
                }
            }
            else
            {
                foreach($orders as $order)
                {
                    $return[$order->id] = $order->id . ' - '. $order->first_name . ' ' . $order->last_name .' - ($'. number_format($order->grand_total, 2) .')';
                }
            }
        }

        return $return;
    }

    public static function sendSubscriptionWithCoupon($data, $type)
    {   
        Mail::send(new SendSubscriptionWithCoupon($data, $type));
        return true;
    }

    public static function isBuyProduct($product_id, $customer_id)
    {
        $isBuy = OrderItems::where([['product_id',$product_id],['customer_id', $customer_id]])->count();
        return $isBuy;
    }
    public static function isBuy($product_id, $customer_id)
    {
        $isBuy = OrderItems::where([['product_id',$product_id],['customer_id', $customer_id]])->first();
        $isBuy ? $return = true : $return = false;
        return $return;
    }

}