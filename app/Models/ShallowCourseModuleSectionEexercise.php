<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShallowCourseModuleSectionEexercise extends Model
{
    use HasFactory;
    protected $fillable=['purchased_user_id','parent_course_module_section_exercise_id','course_module_id','course_module_section_id','sequence_no','title','slug','detail','type','video_type','video_id', 'file'];

    protected $table='shallow_course_module_section_exercises';
    public function module()
    {
        return $this->belongsTo(ShallowCourseModule::class, 'course_module_id');
    }
    public function questions(){
        return $this->hasMany(ShallowQuizQuestion::class, 'exercise_id');
    }

    public function exercise_result(){
        return $this->hasOne(CourseQuizResult::class, 'exercise_id');
    }

     public function exercise_marking(){
      return $this->hasOne(MarkingSubmission::class, 'exercise_id');
     }

}