<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleQuize extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }

    public function options()
    {
        return $this->hasMany(CourseModuleQuizOption::class, 'quiz_id');
    }

    public function sections()
    {
        return $this->hasMany(CourseModuleSection::class, 'course_module_id','module_id');
    }


}
