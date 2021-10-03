<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserModel;
use App\Models\HomeModel;
use App\Models\UsersAlbumsModel;
use App\Models\UsersPhotosModel;
use Cassandra\Date;
use FilesystemIterator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionException;
use function GuzzleHttp\Promise\all;
use function PHPUnit\Framework\stringContains;
use Illuminate\Support\Facades\DB;

class Users extends Controller
{
    private $HomeModel;
    private $load;

//https://stackoverflow.com/questions/42823107/laravel-request-is-undefined
    public function index(Request $request)
    {
        //return view('welcome_message');
        //echo "<h1>Users</h1>";
        $data = [];
        //helper(["form"]);

        if ($request->isMethod('post')) {
            //do the validation here
            //with help of https://medium.com/@kamerk22/the-smart-way-to-handle-request-validation-in-laravel-5e8886279271
            $validator = Validator::make($request->all(), [
                'email' => 'required|min:9|max:50|email',
                'password' => 'required|min:8|max:255'
            ]);

            if ($validator->fails()) {
                echo "Failed! Sorry :(";
                //for debug
                dd($validator->errors());
                //Session::flash('error', $validator->messages()->first());
                //return Redirect::back()->withErrors($validator);
            }
           //with help of https://medium.com/@kamerk22/the-smart-way-to-handle-request-validation-in-laravel-5e8886279271
            else {
                //store the user in our database
                //print_r(config('database.connections'));
                if (UserModel::query()->where('email', $request/*->request*/->get('email'))->first()['verification'] > 0) {
                    $user = UserModel::query()->where('email', $request/*->request*/->get('email'))->first();
                    //https://stackoverflow.com/questions/28417796/set-session-variable-in-laravel
                    Session::put('id',$user['id']);
                    Session::put('email', $user['email']);
                    Session::put('firstname', $user['firstname']);
                    Session::put('lastname', $user['lastname']);
                    Session::put('isLoggedIn', true);

                //$session->setFlashdata('success','Successful Registration');

                    return redirect()->to('dashboard');
                } else echo "Sorry, but you haven't verified your email. Please check your mail box";
            }
        }
        echo view('templates/header', $data);
        echo view('login', $data);
        echo view('templates/footer', $data);
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Session::forget(['email','firstname','id','lastname','isLoggedIn']);
        return redirect()->to('/');
    }

//    private function setUserSession($user)
//    {
//        $data = [
//            'id' => $user['id'],
//            'firstname' => $user['firstname'],
//            'lastname' => $user['lastname'],
//            'email' => $user['email'],
//            'isLoggedIn' => true,
//        ];
//
//        session()->set($data);
//        //return true;
//    }

    public function register(Request $request)
    {
        $data = [];
        //helper(["form"]);
        echo "hello";
        //dd($request->isMethod('post'));
        if ($request->isMethod('post')) {
            echo "HAHAHAHA";
            //do the validation here
            $rules = [
                'firstname' => 'required|min:3|max:20',
                'lastname' => 'required|min:3|max:20',
                //https://stackoverflow.com/questions/44019128/laravels-uniqueusers-email-validation-error-shows-during-edit
                'email' => 'required|min:9|max:50|email|unique:users,email',
                'password' => 'required|min:8|max:255',
                'password_confirm' => 'confirmed'
            ];
            //if (!$this->validate($request,$rules)) {
                //echo "VALIDATE";
                //$data['validation'] = Validator::validate($data,$rules);
            //} else {
                //store the user in our database
                $model = new UserModel();
                $newData = [
                    'firstname' => $request->get('firstname'),
                    'lastname' => $request->get('lastname'),
                    'email' => $request->get('email'),
                    'password' => $request->get('password'),
                    //'password_confirm' => $request->get('password_confirm')
                ];

                //dd($newData);

                //https://coderoad.ru/22275707/%D0%A7%D1%82%D0%BE-%D0%BE%D0%B7%D0%BD%D0%B0%D1%87%D0%B0%D0%B5%D1%82-%D0%B7%D0%BD%D0%B0%D0%BA-%D0%B2%D0%BE%D0%BF%D1%80%D0%BE%D1%81%D0%B0-%D0%BF%D0%B5%D1%80%D0%B5%D0%B4-var-%D0%B2-%D1%8D%D1%82%D0%BE%D0%BC-href-page-php-var-0
                //my code

                //
//                $noRecords = -1;
//                if (session()->has('id')) {
//                    $noRecords = $this->HomeModel->verifyEmailAddress(session()->get('id'));
//                } else {
//                    echo "Sorry, your session has no id";
//                }
//                if ($noRecords > 0) {
//                    $error = /*array( 'success' =>*/
//                        "Email Verified Successfully!"/*)*/
//                    ;
//                } else {
//                    $error = /*array( 'error' => */
//                        "Sorry Unable to Verify Your Email!"/*)*/
//                    ;
//                }

                //$data['errormsg'] = $error;
                //echo $error;
                //my code

                //$model->save($newData);
                UserModel::query()->insert($newData);
                $session = session();
                $session->flash('success', 'Successful Registration');
                return redirect()->to('/send-email?firstname='.$newData['firstname'].'&email='.$newData['email']);
            }
        //}
        echo view('templates/header', $data);
        echo view('register', $data);
        echo view('templates/footer', $data);
    }

    public function profile(Request $request)
    {
        $data = [];
        //helper(["form"]);
        //$model = new UserModel();
        if ($request->isMethod('post')) {
            //do the validation here
            $rules = [
                'firstname' => 'required|min:3|max:20',
                'lastname' => 'required|min:3|max:20',
            ];

            if ($request->get('password') != '') {
                $rules['password'] = 'required|min:8|max:255';
                $rules['password_confirm'] = 'matches[password]';
            }

            //if (!$this->validate($request,$rules)) {
                //$data['validation'] = Validator::validate($data,$rules);
           // } else {
                //store the user in our database
                //$model = new UserModel();
                $newData = [
                    'id' => session()->get('id'),
                    'firstname' => $request->get('firstname'),
                    'lastname' => $request->get('lastname'),
                ];

                if ($request->get('password') != '') {
                    $newData['password'] = $request->get('password');
                }

                //$model->save($newData);
                UserModel::query()->where('id',session()->get('id'))->update($newData);
                session()->flash('success', 'Successfully Updated');
                Session::put('id',$newData['id']);
                Session::put('firstname', $newData['firstname']);
                Session::put('lastname', $newData['lastname']);
                return redirect()->to('/profile');
            }
        //}

        $data['user'] = UserModel::query()->where('id', session()->get('id'))->first();
        echo view('templates/header', $data);
        echo view('profile', $data);
        echo view('templates/footer', $data);
    }

//    public function logout(): \Illuminate\Http\RedirectResponse
//    {
//        session()->destroy();
//        return redirect()->to('/');
//    }

    function verify()
    {
        //$noRecords = -1;
        $data2 = $_SERVER['QUERY_STRING']; //около 3 дней потерял на поиски этой детали!!!
        $url = URL::to('/') . '/verify?' . $data2;
        $url_components = parse_url($url);
        parse_str($url_components['query'], $params);
        $email = $params['email'];
        echo "$email";

        //if (session()->has('email'))
        //$HomeModel = new HomeModel();
        //$HomeModel->verifyEmailAddress($email);
        $newData = ['verification'=>1];
        UserModel::query()->where("email",$email)->update($newData);
        if (UserModel::query()->where("email",$email)->first()['verification'] > 0) {
            $error = /*array( 'success' =>*/
                "Email Verified Successfully!"/*)*/
            ;
        } else {
            $error = /*array( 'error' => */
                "Sorry Unable to Verify Your Email!"/*)*/
            ;
        }

        //$data['errormsg'] = $error;
        echo $error;
        //$this->load->view('index.php', $data);
        //return redirect()->to('/verify');
        $data['user'] = [];
        echo view('verify', $data);
//        $data2 = $_SERVER['QUERY_STRING']; //около 3 дней потерял на поиски этой детали!!!
//        var_dump($data2);
    }

    public function uploadAvatar(Request $request)
    {
        $file = $request->file('img');
        //if ($file->isValid()) {
            //$model = new UserModel();
            $avatarName = UserModel::query()->where('email', session()->get('email'))->first()['email'];
            //if ($avatarId>0) {
            if (file_exists('./profile-pic/p.' . $avatarName . '.jpg')) {
                unlink('./profile-pic/p.' . $avatarName . '.jpg');
                //./profile-pic/p.kubalyan-ruben@mail.ru.jpg
                //echo "YES!!!!!";
            }
            $file->move('./profile-pic', 'p.' . $avatarName . '.jpg');
            //}
        //}
        return redirect()->to('/profile');
    }

    public function uploadAlbumImage(Request $request)
    {
        $url = $_GET['q'];
        $string = explode('"', $url);
        print_r($string);
        //echo str_replace("/index.php","",$url);
        $url = str_replace("/index.php", "", $url);
        $current_email = session()->get('email');

        //version 1
        //print_r($_FILES['img']['name'][0]);

        //version 2
        if($files=$request->file('img')){
            foreach($files as $file){
                $name=$file->getClientOriginalName();
                if ($file->isValid()) {
                    if (file_exists('./pic-albums/' . $string[1] . '_' . $current_email . '/' . $name)) {
                        unlink('./pic-albums/' . $string[1] . '_' . $current_email . '/' . $name);
                    }
                    $file->move('./pic-albums/' . $string[1] . '_' . $current_email, $name);
                    print_r("file added, ");
                    $data = [
                        'email' => $current_email,
                        'album_name' => $string[1],
                        'picture_directory' => "/pic-albums/$string[1]_$current_email/$name",
                        'picture_name' => $name,
                    ];
                    print_r($data);
                    UsersPhotosModel::query()->insert($data);
                }
            }
        }

        return redirect()->to($url);
    }

    public function deleteAlbumPhotos()
    {
        //$model = new UsersPhotosModel();
        $imageDirectory = $_GET['q'];

        $p = UsersPhotosModel::query()->get()->toArray();
        $id = -1;
        for ($i = 0; $i < count($p); $i++) {
            if ($p[$i]['picture_directory'] === $imageDirectory) {
                $id = $p[$i]['id'];
                UsersPhotosModel::query()->where('id', $id)->delete();
                unlink('.' . $imageDirectory);
            }
        }
        //print_r($p[0]['id']);
        print_r($id);
    }

    public function deleteAlbums()
    {
        //$model = new UsersAlbumsModel();
        $albumDirectory = $_GET['q'];
//        http://localhost/get-photos?q="cserewt"

        $string = explode('"', $albumDirectory);
        //print_r($string[1]);

        $p = UsersAlbumsModel::query()->get()->toArray();
        $id = -1;

        echo "address in db = " . $p[2]['album_directory'];
        echo "<br>";
        echo "address we want = " . "./pic-albums/efweretv_kubalyan-ruben@mail.ru";
        echo "<br>";
        echo "address we get by code = " . './pic-albums/' . $string[1] . "_" . session()->get('email');
        for ($i = 0; $i < count($p); $i++) {
            if ($p[$i]['album_directory'] === './pic-albums/' . $string[1] . '_' . session()->get('email')) {
                echo "I'm working, nya";
                $id = $p[$i]['id'];
                UsersAlbumsModel::query()->where('id',$id)->delete();
                //$rootDir = realpath($_SERVER["DOCUMENT_ROOT"]);
                //echo "$rootDir";

                $this->removeDir('./pic-albums/' . $string[1] . "_" . session()->get('email'));
                //rmdir('./pic-albums/'.$string[1]."_".session()->get('email'));
                break;
            }
        }
        //print_r($p[0]['id']);
        //print_r($id);
    }

    function removeDir($target)
    {
        $directory = new RecursiveDirectoryIterator($target, FilesystemIterator::SKIP_DOTS);
        $files = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($files as $file) {
            if (is_dir($file)) {
                rmdir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($target);
    }

    public function otherUsersAlbums()
    {
        //$model = new UserModel();
        $userFirstNames = [];
        $userLastNames = [];
        $array = UserModel::query()->get()->toArray();
        for ($i = 0; $i < count($array); $i++) {
            //echo $array[$i]['firstname']."|".$array[$i]['lastname'];
            array_push($userFirstNames, $array[$i]['firstname']);
            array_push($userLastNames, $array[$i]['lastname']);
        }

        $data['userFirstNames'] = $userFirstNames;
        $data['userLastNames'] = $userLastNames;

        echo view('templates/header', $data);
        echo view('other-users-albums', $data);
        echo view('templates/footer', $data);
    }

    public function getUserInfo()
    {
        $data = [];

        $clientRequest = $_GET['q'];
        //echo $clientRequest;
        $userInfoArray = explode('|', $clientRequest);
        $userFirstName = $userInfoArray[0];
        $userLastName = $userInfoArray[1];

        $userInfo = UserModel::query()->get()->toArray();
        $userPictures = UsersAlbumsModel::query()->get()->toArray();

        $email = null;
        $userFirstName = str_replace('"', "", $userFirstName);
        $userLastName = str_replace('"', "", $userLastName);
        for ($i = 0; $i < count($userInfo); $i++) {
            if (strcmp($userInfo[$i]['firstname'], $userFirstName) === 0 && strcmp($userInfo[$i]['lastname'], $userLastName) === 0) {
                $email = $userInfo[$i]['email'];
            }
        }

        $albumNames = [];
        $albumDirectories = [];
        for ($i = 0; $i < count($userPictures); $i++) {
            if ($userPictures[$i]['user_email'] === $email) {
                array_push($albumNames, $userPictures[$i]['album_name']);
                array_push($albumDirectories, $userPictures[$i]['album_directory']);
            }
        }

        $data['albumNames'] = $albumNames;
        $data['albumDirectories'] = $albumDirectories;
        $data['userFirstName'] = $userFirstName;
        $data['userLastName'] = $userLastName;

        echo view('templates/header', $data);
        echo view('user-public-profile', $data);
        echo view('templates/footer', $data);
    }

    /*function sendVerificationEmail(){
        $this->EmailModel->sendVerificatinEmail("info@tutspointer.com","13nRGi7UDv4CkE7JHP1o");
        $this->load->view('index.php', $data);
    }*/
}
