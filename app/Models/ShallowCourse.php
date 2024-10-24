<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShallowCourse extends Model
{
    use HasFactory;

    protected $table = 'shallow_course';

    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    public function modules()
    {
        return $this->hasMany(ShallowCourseModule::class, 'course_id');
    }

     public function user(){
      return $this->belongsTo(User::class,'purchased_user_id','id');
    }
     public function parentModules(){
     return $this->hasMany(ShallowCourseModule::class, 'course_id')->where('parent_id',0);
    }
    public function getSelectedColumnsFromModules()
    {
        // return $this->hasMany(ShallowCourseModule::class, 'course_id')->select('id','course_id','title','short_description','description','price','price_original','thumbnail','slug','status');
        return $this->hasMany(ShallowCourseModule::class, 'course_id')->select('id','course_id','title','slug');
    }

    public function category()
    {
        return $this->belongsTo(ShallowCourseCategory::class, 'course_category_id');
    }

    public function getCourseType()
    {
        return $this->belongsTo(CourseType::class, 'course_type_id');
    }

    public function instructor()
    {
        return $this->belongsTo(Customer::class, 'user_id');
    }
    public function getSelectedColumnsOfInstructor()
    {
        return $this->belongsTo(Customer::class, 'user_id')->select('id','first_name','last_name','email','type');
    }

    public function userEnrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'course_id');
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class, 'course_id')->where('user_id', @auth()->user()->id);
    }

    public function completed_exercises(){
    return $this->hasMany(ExerciseCompletion::class,'course_id','id');
    }

   public function completed_course()
    {
        return $this->hasOne(CourseCompletion::class,'course_id','id')->where('user_id', @auth()->user()->id);
    }

    public static function video_counts($course_id)
    {
        $course = ShallowCourse::find($course_id);
        $videos_count = 0;
        foreach($course->modules as $module)
        {
            $videos_count += $module->videos->count();
        }
        return $videos_count;
    }

    public static function discount($id)
    {
        $course = self::find($id);
        $discount = 0;
        if($course->price_original > 0)
        {
            $discount = ($course->price / $course->price_original) * 100;
            $discount = 100 - $discount;
        }
        return $discount;
    }

    public static function enrolled($course_id)
    {
        $enrolled = 0;
        if(auth()->user())
        {
            $enrollment = CourseEnrollment::where(['course_id'=>$course_id, 'user_id' => auth()->user()->id])->first();
            if(@$enrollment)
            {
                $enrolled = 1;
            }
        }
        return $enrolled;
    }
}