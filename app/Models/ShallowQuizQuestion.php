<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShallowQuizQuestion extends Model
{
    use HasFactory;
    protected $table='shallow_quiz_questions';
    protected $fillable=['parent_quiz_question_id','module_id','section_id','exercise_id','exercise_id','quiz_id','question','type','score','file','video_id','active'];

    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    public function answers()
    {
        return $this->hasMany(ShallowQuizAnswer::class, 'question_id');
    }

    public function module()
    {
        return $this->belongsTo(ShallowCourseModule::class, 'module_id');
    }
}
