<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'course_categories';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    //protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'created_at', 'updated_at' ];
    public function getCourses()
    {
        return $this->hasMany(Course::class, 'course_category_id');
    }

    public function getSelectedCoursesColumns()
    {
        return $this->hasMany(Course::class,'course_category_id')->select('id','course_category_id','title','slug');
    }

    public static function getAllCourses($category_id)
    {
        $courses = Course::where('course_category_id', $category_id)->get();
        return $courses;
    }

    public static function enrolments($category_id)
    {
        $courses = Course::where('course_category_id', $category_id)->get();
        $enrollments = 0;
        foreach($courses as $course)
        {
            $enrollments = $enrollments + $course->enrollments->count();
        }
        return $enrollments;
    }
}