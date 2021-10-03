<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersPhotosModel extends Model
{
    protected $table = 'user_gallery_pics';
    protected $connection = 'mysql';
    protected $allowedFields = ['email','updated_at', 'album_name','picture_directory','picture_name'];
}
