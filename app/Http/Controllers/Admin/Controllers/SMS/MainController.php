<?php

namespace App\Http\Controllers\Admin\Controllers\SMS;

use App\Http\Controllers\Controller;
use App\Models\ContactInformation;
use App\Models\Message_Content;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index(){
        $contacts = ContactInformation::all();
        $messagecontent = Message_Content::all();
        return inertia('Admin/SMSSettings/Index',['contacts'=>$contacts,'messagecontent'=>$messagecontent]);
    }
    public function message_info(){
        $contacts = ContactInformation::all();
        $messagecontent = Message_Content::all();
        return response()->json(['contacts'=>$contacts,'messagecontent'=>$messagecontent]);
    }
}
