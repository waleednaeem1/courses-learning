<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseCompletion extends Model
{
    use HasFactory;
    protected $table = 'exercise_completion';
    protected $fillable=['user_id','section_id','exercise_id','completion_status','course_id','is_last_exercise_count'];

    public function exercise()
    {
        return $this->belongsTo(ShallowCourseModuleSectionEexercise::class, 'exercise_id');
    }

}
