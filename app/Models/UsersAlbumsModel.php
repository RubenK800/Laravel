<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsersAlbumsModel extends Model
{
    protected $table = 'albums';
    protected $connection = 'mysql';
    protected $allowedFields = ['id','album_name','user_email','album_directory'];
}
