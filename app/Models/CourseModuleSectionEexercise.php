<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleSectionEexercise extends Model
{
    use HasFactory;
    protected $fillable=['course_module_id','course_module_section_id','sequence_no','title','slug','detail','video_type','video_id'];

    protected $table='course_module_section_exercises';

   public function module()
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }

        public function questions(){
        return $this->hasMany(QuizQuestion::class, 'exercise_id');
        }

}