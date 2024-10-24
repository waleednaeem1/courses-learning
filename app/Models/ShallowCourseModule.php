<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShallowCourseModule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(ShallowCourse::class, 'course_id');
    }

    public function videos()
    {
        return $this->hasMany(ShallowCourseModuleVideo::class, 'course_module_id');
    }

    public function sections()
    {
        return $this->hasMany(ShallowCourseModuleSection::class, 'course_module_id');
    }

    public function moduleCompletion()
    {
        return $this->hasOne(ModuleCompletion::class, 'module_id');
    }
    public static function setPaidProcess($course_id)
    {
        $check = ShallowCourseModule::where(['course_id'=>$course_id, 'is_free' => 0])->count();
        $course = ShallowCourse::find($course_id);
        // If complete course is free (not paid)
        $price = $check==0 ? 0 : $course->price_placeholder;
        $price_placeholder = $check==0 ? $course->price : 0;
        $course->update(['price' => $price,'price_placeholder'=>$price_placeholder]);
    }

    public function quizzes()
    {
        return $this->hasMany(ShallowCourseModuleQuize::class, 'module_id');
    }


   public function sub_modules(){
       return $this->hasMany(self::class, 'parent_id','parent_course_module_id');
   }

   public function childSubModules()
    {
        return $this->hasMany(self::class,'parent_id','parent_course_module_id')->with('sub_modules');
    }

    // public static function userSavedAsnwersCount($module_id)
    // {
    //     if(Auth::user()){
    //         $user_id = Auth::user()->id;
    //         $answers_count = CourseModuleQuizAnswer::where([['user_id', $user_id],['module_id', $module_id]])->count();
    //         return $answers_count;
    //     } else {
    //         return 0;
    //     }
    // }


}
