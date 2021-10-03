<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\UsersAlbumsModel;
use App\Models\UsersPhotosModel;

class Albumphotos extends Controller
{
    public function index()
    {
        $data = [];
        //$clientRequest = $_GET['q'];
        //$data['albumName'] = $clientRequest;

        echo view('templates/header', $data);
        echo view('albums', $data);
        echo view('templates/footer', $data);
    }

    public function albumNames()
    {
        //$clientRequest = $_GET['q'];

        //$model = new UsersAlbumsModel();
        $result = UsersAlbumsModel::query()->get()->toArray();
        //print_r($result);
        echo json_encode($result);
        //echo $result;
    }

    public function getAlbumPhotos()
    {
        $clientRequest = $_GET['q'];

        $model = new UsersPhotosModel();
        $result = UsersPhotosModel::query()->get()->toArray();

        $data['query'] = $result;
        $data['albumName'] = $clientRequest;
        $data['session_email'] = session()->get('email');

        echo view('templates/header', $data);
        echo view('photos', $data);
        echo view('templates/footer', $data);
    }

    public function getOtherUsersAlbumPhotos(){
        $clientRequest = $_GET['q'];

        $clientFirstName = str_replace('"','',$_GET['fname']);
        $clientLastName = str_replace('"','',$_GET['lname']);

        //$model = new UsersPhotosModel();
        //$model2 = new UserModel();

        $array2 = UserModel::query()->get()->toArray();
        $email = null;

        for ($i=0; $i<count($array2); $i++){
            if ($array2[$i]['firstname'] === $clientFirstName && $array2[$i]['lastname'] === $clientLastName) {
                $email = $array2[$i]['email'];
            }
        }

        $result = UsersPhotosModel::query()->get()->toArray();

        $data['query'] = $result;
        $data['albumName'] = $clientRequest;
        $data['session_email'] = session()->get('email');

        //echo $email;

        $photosByEmailAndAlbumName = [];
        $array = UsersPhotosModel::query()->get()->toArray();
        for ($i=0; $i<count($array); $i++) {
            if ($array[$i]['album_name'] === str_replace('"',"",$clientRequest) && $array[$i]['email'] === $email){
                array_push($photosByEmailAndAlbumName,$array[$i]['picture_directory']);
                //echo "YESSSSSS!!!!!";
            }
        }

        $data['photosDirectories'] = $photosByEmailAndAlbumName;

        //echo $array[0]['album_name'];
        //echo str_replace('"',"",$clientRequest);

        //print_r($photosByEmailAndAlbumName);

//        $clientFirstName = str_replace('"','',$clientFirstName);
//        $clientLastName = str_replace('"','',$clientLastName);

//        $data['clientFirstName'] = $clientFirstName;
//        $data['clientLastName'] = $clientLastName;

//        echo $clientFirstName;
//        echo "<br>";
//        echo $clientLastName;

        echo view('templates/header', $data);
        echo view('other-users-album-photos', $data);
        echo view('templates/footer', $data);
    }
}
