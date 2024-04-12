<?php

namespace App\Http\Controllers\Guest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function guestWelcome(){
        return "your are guest";
    }
}
