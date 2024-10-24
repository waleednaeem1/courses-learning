<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionCompletion extends Model
{
    use HasFactory;
   protected $table = 'section_completion';
    protected $fillable=['user_id','module_id','section_id','completion_status'];


}
