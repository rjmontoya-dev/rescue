<?php

namespace App\Http\Controllers\Guest\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FloodController extends Controller
{
    public function index(){
        return inertia('Guest/Flood/Index');
    }
    public function preparing_flood (){
        return inertia('Guest/Flood/preparingFlood');
    }
    public function flood_water_safety(){
        return inertia('Guest/Flood/floodwatersafety');
    }
    public function returning_home(){
        return inertia('Guest/Flood/returningHome');
    }
}
