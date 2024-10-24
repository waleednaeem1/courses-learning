<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Team extends Model
{
    use HasFactory,SoftDeletes;
    protected $hidden = ["deleted_at"];

    protected $dates = ['deleted_at'];
    protected $table='team';
    protected  $fillable=['user_id','is_coach','added_by'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
