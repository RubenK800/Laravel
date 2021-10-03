<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\UsersAlbumsModel;
use App\Models\UsersPhotosModel;
use Config\Kint;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
	public function index()
	{
	    $data = [];

        echo view('templates/header', $data);
        echo view('dashboard', $data);
        echo view('templates/footer', $data);
	}

//    public function file_upload(){
//        $file = $this->request->getFile('img');
//        if ($file->isValid()){
//            $model = new UsersPhotosModel();
//            $avatarID = $model->where('email',session()->get('email'))->get()->getRowArray(1)['id'];
//            //if ($this->request->getMethod() === 'post'){
//              //  $dataFromClientSide = $_GET['q'];
//                //echo "Hey man! I'm working!";
//                //mkdir("./profile-pic/".$dataFromClientSide);
//            //}
//            if (is_dir('./'.session()->get('email'))) {
//                if (file_exists('./'.session()->get('email').'/p.'.$avatarID.'.jpg')) {
//                    unlink('./profile-pic/p.'.$avatarID.'.jpg');
//                    //./profile-pic/p.kubalyan-ruben@mail.ru.jpg
//                    //echo "YES!!!!!";
//                }
//                $file->move('./profile-pic','p.'.$avatarID.'.jpg');
//            }
//        }
//        return redirect()->to('/profile');
//    }

    public function setNewAlbumDirectory(Request $request){
	    //Kint::$enabled_mode = false;
        if ($request->isMethod('get')){
            $dataFromClientSide = $_GET['q'];
            $directory = "./pic-albums/".$dataFromClientSide."_".session()->get('email');
            print_r($dataFromClientSide);
            if (!is_dir($directory)) {
                mkdir($directory);
                //$albumModel = new UsersAlbumsModel();
                $album_name = UsersAlbumsModel::query()->get()->toArray();

//                print_r($dataFromClientSide);

                $albumExists = false;
                for ($i=0; $i<count($album_name); $i++){
                    if ($album_name[$i]['album_name'] === $dataFromClientSide && $album_name[$i]['user_email']===session()->get('email')){
                        //print_r("No, I didn't found any! Everything alright, you can act.");
                        $albumExists = true;
                        break;
                    }
                }

                if (!$albumExists){
                    $data = [
                        'album_name' => $dataFromClientSide,
                        'user_email'  => session()->get('email'),
                        'album_directory'  => $directory,
                    ];

                    try {
                        UsersAlbumsModel::query()->insert($data);
                    } catch (\ReflectionException $e) {

                    }
                }

                //print_r($album_name);
                //important part
                echo "OK"."|".$directory;
            } else {
                echo "NO";
            }
        }
    }
}
