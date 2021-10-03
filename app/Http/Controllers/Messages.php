<?php

namespace App\Http\Controllers;

use App\Models\MessagesModel;
use App\Models\UserModel;

class Messages extends Controller
{
    public function index()
    {
        $data = [];

        echo view('templates/header', $data);
        echo view('messages', $data);
        echo view('templates/footer', $data);
    }

    public function getCurrentChat(){
        $data = [];
        $model = new MessagesModel();
        $MessagesInfoDB = $model->get()->getResultArray();

        echo view('templates/header', $data);
        echo view('messages', $data);
        echo view('templates/footer', $data);
    }

    public function getUsersForChatting(){
        $data = [];

        //$model = new UserModel();
        $userFirstNames = [];
        $userLastNames = [];
        $array = UserModel::query()->get()->toArray();
        for ($i=0; $i<count($array); $i++){
            //echo $array[$i]['firstname']."|".$array[$i]['lastname'];
            array_push($userFirstNames,$array[$i]['firstname']);
            array_push($userLastNames, $array[$i]['lastname']);
        }

        $data['userFirstNames'] = $userFirstNames;
        $data['userLastNames'] = $userLastNames;

        echo view('templates/header', $data);
        echo view('users-to-chat', $data);
        echo view('templates/footer', $data);
    }

    public function openChat(){
        $data = [];

        //get email
        $clientRequest = $_GET['q'];
        $userInfoArray=explode('|', $clientRequest);
        $userFirstName = $userInfoArray[0];
        $userLastName = $userInfoArray[1];

        //$model = new UserModel();
        $userInfo = UserModel::query()->get()->toArray();
        //$model2 = new UsersAlbumsModel();
        //$userPictures = $model2->get()->getResultArray();

        $email = null;
        $userFirstName = str_replace('"',"", $userFirstName);
        $userLastName = str_replace('"',"", $userLastName);
        for ($i=0; $i<count($userInfo); $i++){
            if (strcmp($userInfo[$i]['firstname'], $userFirstName) === 0 && strcmp($userInfo[$i]['lastname'], $userLastName) === 0){
                $email = $userInfo[$i]['email'];
            }
        }

        //echo $email;

        //restore previous messages
        //$model2 = new MessagesModel();
        $arrayOfMessages = MessagesModel::query()->get()->toArray();

        $arrayOfAnswerMessages = [];
        $arrayOfRequestMessages = [];

        $arrayAlter = [];

        for ($i=0; $i<count($arrayOfMessages); $i++){
            if ($arrayOfMessages[$i]['sender_user_email'] === $email && $arrayOfMessages[$i]['getter_user_email'] === session()->get('email')){
                array_push($arrayAlter/*$arrayOfAnswerMessages*/,$userFirstName." ".$userLastName.": ".$arrayOfMessages[$i]['message']."|".$arrayOfMessages[$i]['id']);
            } else if($arrayOfMessages[$i]['sender_user_email'] === session()->get('email') && $arrayOfMessages[$i]['getter_user_email'] === $email){
                array_push($arrayAlter/*$arrayOfRequestMessages*/,"You: ".$arrayOfMessages[$i]['message']."|".$arrayOfMessages[$i]['id']);
            }
        }

//        print_r($arrayOfAnswerMessages);
//        print_r($arrayOfRequestMessages);

        $data['userFirstName'] = $userFirstName;
        $data['userLastName'] = $userLastName;
//        $data['answerMessage'] = $arrayOfAnswerMessages;
//        $data['requestMessage'] = $arrayOfRequestMessages;
        $data['arrayAlter'] = $arrayAlter;

        echo view('templates/header', $data);
        echo view('chat',$data);
        echo view('templates/footer', $data);
    }

    public function storeMessagesInDB(){
        $message = $_GET['q'];
        $receiverFirstName = $_GET['fname'];
        $receiverLastName = $_GET['lname'];
        echo $message."|".$receiverFirstName."|".$receiverLastName;
        //$model = new MessagesModel();
        //$model2 = new UserModel();
        $email = null;
        $array = UserModel::query()->get()->toArray();
        for ($i=0; $i<count($array); $i++){
            if ($array[$i]['firstname']===$receiverFirstName && $array[$i]['lastname']===$receiverLastName){
                $email = $array[$i]['email'];
            }
        }
        $saveData = ['sender_user_email'=> session()->get('email'), 'message' => $message, 'getter_user_email' => $email];
        try {
            MessagesModel::query()->insert($saveData);
        } catch (\ReflectionException $e) {
        }
    }
}
