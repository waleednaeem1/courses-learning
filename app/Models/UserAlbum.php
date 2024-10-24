<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAlbum extends Model
{
    use HasFactory;
    
    protected $table = 'user_album';

    protected $primaryKey = 'id';

    protected $fillable = ['album_name','user_id','status','is_deleted','created_at','updated_at'];

    public function getAlbumImages(){
        return $this->hasMany(UserAlbumImage::class, 'user_album_id')->where('is_deleted', 0);
    }
}
