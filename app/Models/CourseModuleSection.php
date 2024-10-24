<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleSection extends Model
{
    use HasFactory;
    protected $fillable=['course_module_id','sequence_no','title','slug','detail','status','video_type','video_id'];

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }

   public function videos()
    {
        return $this->hasMany(CourseModuleVideo::class, 'course_module_section_id');
    }

     public function exercise()
    {
        return $this->hasMany(CourseModuleSectionEexercise::class, 'course_module_section_id');
    }



}
