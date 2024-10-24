<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShallowQuizAnswer extends Model
{
    use HasFactory;
    protected $table='shallow_quiz_answers';
    protected $fillable=['parent_quiz_answer_id','parent_question_id','question_id','answer','is_true','active'];


    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];
    public function OptionQuestion()
    {
        return $this->belongsTo(ShallowQuizQuestion::class, 'question_id');
    }
}
