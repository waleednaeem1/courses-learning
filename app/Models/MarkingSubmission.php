<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkingSubmission extends Model
{
    use HasFactory;
 protected $table = 'marking_submission';
 protected $appends = ['is_exercise_mark'];

protected $fillable=['course_id','section_id','module_id','exercise_id','marking_user_id','course_user_id','comments'];

public function exercise_marking_result(){
      return $this->hasMany(MarkingSubmissionResult::class, 'marking_submission_id');
 }

public function getIsExerciseMarkAttribute()
{
      return MarkingSubmissionResult::where(['status'=>'non_satisfactory','marking_submission_id'=>$this->id])->count();
}

}
