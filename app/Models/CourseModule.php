<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function videos()
    {
        return $this->hasMany(CourseModuleVideo::class, 'course_module_id');
    }

    public function sections()
    {
        return $this->hasMany(CourseModuleSection::class, 'course_module_id');
    }

    public static function setPaidProcess($course_id)
    {
        $check = CourseModule::where(['course_id'=>$course_id, 'is_free' => 0])->count();
        $course = Course::find($course_id);
        // If complete course is free (not paid)
        $price = $check==0 ? 0 : $course->price_placeholder;
        $price_placeholder = $check==0 ? $course->price : 0;
        $course->update(['price' => $price,'price_placeholder'=>$price_placeholder]);
    }

    public function quizzes()
    {
        return $this->hasMany(CourseModuleQuize::class, 'module_id');
    }


   public function sub_modules(){
       return $this->hasMany(self::class, 'parent_id');
   }

    public static function userSavedAsnwersCount($module_id)
    {
        if(Auth::user()){
            $user_id = Auth::user()->id;
            $answers_count = CourseModuleQuizAnswer::where([['user_id', $user_id],['module_id', $module_id]])->count();
            return $answers_count;
        } else {
            return 0;
        }
    }


}
