<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\EventAttendee;

class Events extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

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
    protected $fillable = [ 'name', 'slug', 'short_description', 'full_description', 
    'start_date', 'end_date', 'image','thumbnail', 'video', 'meta_title', 'meta_keywords', 'meta_description' ,
    'show_in_vendor', 'status', 'type', 'address', 'city', 'state', 'attendee_registration_fee' , 'exhibitor_registration_fee' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    public function slugs()
    {
        return $this->morphMany('App\Models\Slug', 'sluggable');
    }

    public function webinars()
    {
        return $this->hasMany(Webinar::class);
    }

    public function vendors()
    {
        return $this->hasMany('App\Models\EventVendors', 'event_id');
    }

    public function speakers()
    {
        return $this->hasMany(EventSpeaker::class, 'event_id');
    }

    public static function getEventBySlug($slug, $redirect_if_not_found = false)
    {
        $event = self::where('slug', $slug)->first();
        if($event) return $event;
        return null;
    }

    public static function exhibitor($exhibitor)
    {

        return;
        $html = '<article class="bg-white group relative rounded-lg overflow-hidden shadow-lg hover:shadow-2xl transform duration-200">
                    <div class="relative w-full h-80 md:h-64 lg:h-44">
                        <img
                            src="https://www.gervetusa.com/vsi/image/gvu_logo.png"
                            alt="Desk with leather desk pad, walnut desk organizer, wireless keyboard and mouse, and porcelain mug."
                            class="w-full h-full object-contain"
                        />
                    </div>
                    <div class="px-3 py-4">
                        <h3 class="text-sm text-gray-500 pb-2">
                            <a class="card-btn-color py-1 px-2 text-white rounded-lg" href="#">
                                <span class="absolute inset-0"></span>
                                GerVetUSA
                            </a>
                        </h3>
                        <p class="text-base text-gray-900">Surgical Instruments, Dental Instruments, Orthopeic Instruments</p>
                        <a href="#" class="absolute bottom-2 right-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                    </div>
                </article>';

        return $html;

    }

    public function attendee_participated()
    {
        $attendee_id  = session()->get('ses_attendee')['attendee_user']['id'];
        $event_id   = $this->id;
        
        $check = EventAttendee::where(['event_id' => $event_id, 'attendee_id' => $attendee_id])->first();
        
        if($check)
        {
            if($check->event_fee == NULL){
                return '/fee';
            }else{
                return '?h='.$check->access_hash;
            }
            
            //return $check->id.'-'.Str::slug($check->display_name).'?h='.$check->access_hash;
        }

        return false;
    }
}
