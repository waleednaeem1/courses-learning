<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarkingSubmissionResult extends Model
{
    use HasFactory;
 protected $table = 'marking_submission_result';
protected $fillable=['marking_submission_id','question_id','feedback','comments','status'];



}
