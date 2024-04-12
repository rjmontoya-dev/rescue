<?php
namespace App\Services;

use App\Mail\Notifications\NewAccountMail;
use App\Mail\Notifications\Status_Notif;
use Illuminate\Support\Facades\Mail;

class SendMailService{
    public static function statusNotif($user,$message){
        Mail::to($user['email'])->queue(new Status_Notif($user,$message));
    }
}
