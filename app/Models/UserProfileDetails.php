<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfileDetails extends Model
{
    use HasFactory;
    protected $table = 'user_profile_details';
    protected $primaryKey = 'id';

    public function getuser(){
        return $this->belongsTo(User::class)->where([ 'soft_delete', '!=', 1])->select();
    }
    protected $guarded = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
