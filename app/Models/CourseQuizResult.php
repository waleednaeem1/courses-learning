<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuizResult extends Model
{
    use HasFactory;
    protected $table='course_quiz_result';
   protected $fillable=['course_id','section_id','exercise_id','module_id','coach_id','user_id','result','type'];

    public function exercise()
    {
        return $this->hasMany(ShallowCourseModuleSectionEexercise::class, 'id');
    }

     public function exercise_marking(){
      return $this->hasOne(MarkingSubmission::class, 'exercise_id');
     }

    public function course(){
      return $this->belongsTo(ShallowCourse::class, 'course_id');
     }

}
