<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleVideo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'course_module_id');
    }

    public static function setPaidProcess($module_id)
    {
        $check_is_paid = CourseModuleVideo::where(['course_module_id'=>$module_id, 'is_free' => 0])->count();
        $module = CourseModule::find($module_id);
        
        // if number of videos of current module is paid
        $is_free = $check_is_paid>0 ? 0 : 1;

        $module->update(['is_free' => $is_free]);
        CourseModule::setPaidProcess($module->course_id);
    }
}
