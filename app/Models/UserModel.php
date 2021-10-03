<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $connection = 'mysql';
    protected $allowedFields = ['firstname','lastname','email','password','updated_at'];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];

    protected function beforeInsert(array $data): array
    {
        return $this->passwordHash($data);
    }

    protected function beforeUpdate(array $data): array
    {
        return $this->passwordHash($data);
    }

    protected function passwordHash(array $data)
    {
        if (isset($data['data']['password']))
            $data['data']['password'] = password_hash($data['data']['password'],PASSWORD_DEFAULT);
        return $data;
    }
}
