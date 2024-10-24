<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'question_id');
    }

    public function module()
    {
        return $this->belongsTo(CourseModule::class, 'module_id');
    }
}
