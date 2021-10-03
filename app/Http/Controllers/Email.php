<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class Email extends Controller
{
    public function sendEmail()
    {
        $firstname = $_GET['firstname'];
        $email = $_GET['email'];
        $details = ['title' => 'Email Verification', 'body'=>'Hello '.$firstname.
            '. Please, click the below link to activate your account <br>'. URL::to('/') . '/verify?email='
            .$email.'" target="_blank">Activate Now</a>'];
        Mail::to('kubalyan-ruben@mail.ru')->send(new TestMail($details));
        return "Email Sent, Please check your mailbox and verify your account<br><a href='/'>Go to Login page</a>";
    }
}
