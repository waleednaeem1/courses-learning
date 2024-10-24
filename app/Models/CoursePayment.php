<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePayment extends Model
{
    use HasFactory;


    /**
        * The table associated with the model.
        *
        * @var string
        */
       protected $table = 'course_payments';

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
}
