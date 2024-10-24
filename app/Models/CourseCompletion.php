<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CourseCompletion extends Model
{
    use HasFactory;
    protected $table = 'course_completion';
    protected $fillable=['user_id','course_id','completion_status'];

    protected $casts = [
      'created_at' => 'date:Y-m-d',
    ];

    public function user(){
      return $this->belongsTo(User::class,'user_id','id');
    }
    public function course(){
      return $this->belongsTo(ShallowCourse::class,'course_id','id');
    }
    public function modules()
    {
      return $this->hasMany(ShallowCourseModule::class, 'course_id');
    }
    public function sections()
    {
      return $this->hasMany(ShallowCourseModuleSection::class, 'course_module_id');
    }


}
