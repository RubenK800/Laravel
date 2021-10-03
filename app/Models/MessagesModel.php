<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessagesModel extends Model
{
    protected $table = 'messages';
    protected $connection = 'mysql';
    protected $allowedFields = ['id', 'sender_user_email', 'message', 'getter_user_email', 'send_time'];
}
