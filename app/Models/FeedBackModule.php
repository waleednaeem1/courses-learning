<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedBackModule extends Model
{
    use HasFactory;

  protected $table = 'course_feedback';
  protected $fillable = ['course_id','section_id','module_id','exercise_id','user_id','feedback_result','created_at','updated_at'];

}
