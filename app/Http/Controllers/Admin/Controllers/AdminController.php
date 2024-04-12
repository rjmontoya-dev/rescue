<?php

namespace App\Http\Controllers\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\Notifications\Status_Notif;
use App\Models\User;
use App\Services\SendMailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function adminWelcome(){
        return inertia('Admin/Index');
    }
    public function email_notif(Request $request){

        $users = User::where('id', '!=', 1)->get();
        foreach($users as $user){
            SendMailService::statusNotif($user,$request->message);
        }
        return response()->json("success");
    }
}
