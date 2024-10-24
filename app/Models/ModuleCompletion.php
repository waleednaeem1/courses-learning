<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleCompletion extends Model
{
    use HasFactory;
    protected $table = 'module_completion';
    protected $fillable=['user_id','course_id','module_id','completion_status','is_mark'];

    public function user(){
      return $this->belongsTo(User::class,'user_id','id');
    }

    public function sections()
    {
      return $this->hasMany(ShallowCourseModuleSection::class, 'course_module_id','module_id');
    }

    public function course(){
      return $this->belongsTo(ShallowCourse::class,'course_id','id');
    }
    public function module(){
      return $this->belongsTo(ShallowCourseModule::class,'module_id','id');
    }



}
