<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShallowCourseModuleSection extends Model
{
    use HasFactory;
    protected $fillable=['purchased_user_id','parent_course_module_id','parent_course_module_section_id','course_module_id','is_feedback','sequence_no','title','slug','detail','status','video_type','video_id'];
    protected $table='shallow_course_module_sections';

    public function module()
    {
        return $this->belongsTo(ShallowCourseModule::class, 'course_module_id');
    }

    public function videos()
    {
        return $this->hasMany(ShallowCourseModuleVideo::class, 'course_module_section_id');
    }

    public function exercise()
    {
        return $this->hasMany(ShallowCourseModuleSectionEexercise::class, 'course_module_section_id');
    }
    public function completed_exercises(){
        // return $this->hasMany(ExerciseCompletion::class,'course_id','id');
        return $this->hasMany(ExerciseCompletion::class,'section_id','id');
    }



}
