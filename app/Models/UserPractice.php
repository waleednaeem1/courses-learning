<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPractice extends Model
{
    use HasFactory;
    protected $table = 'user_practice';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id','practice_name','phone','website','practice_type','animals_treated','postal_address','postal_address_line_one','postal_address_line_two',
    'postal_address_line_three','postal_address_line_four','postal_city','postal_country','postal_state','postal_post_code','billing_address','billing_address_line_one',
    'billing_address_line_two','billing_address_line_three','billing_address_line_four','billing_city','billing_country','billing_state','billing_post_code','created_at','updated_at'];

}
