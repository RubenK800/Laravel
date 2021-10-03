<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeModel extends Model {
    protected $db;
    //protected $allowedFields = ['verification'];

    protected function HomeModel(){
        parent::Model();
    }

    public function verifyEmailAddress($email){
        $db = \Config\Database::connect();
        $builder = $db->table('users');
        $newData = ['verification'=>1];
        $builder->where("email",$email)->update($newData);
        //return $this->db->affected_rows();
    }
}

