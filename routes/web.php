<?php

use App\Http\Controllers\Admin\Controllers\AdminController;
use App\Http\Controllers\Admin\Controllers\SMS\MainController;
use App\Http\Controllers\Admin\Controllers\SMS\SMScontroller;
use App\Http\Controllers\Admin\Controllers\SMS\ContactController;
use App\Http\Controllers\Admin\Controllers\SMS\SendSMSController;
use App\Http\Controllers\Admin\Controllers\Users\UserController;
use App\Http\Controllers\Guest\Controllers\FloodController;
use App\Http\Controllers\Guest\Controllers\GuestController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/message_info',[MainController::class,'message_info'])->name('message_info');
Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard',function(){
        return inertia('Dashboard');
    })->name('dashboard');
    Route::group(['middleware'=>['role:Super Admin']],function (){
        Route::prefix('admin')->name('admin.')->group(function (){
            // Route::get('dashboard',[AdminController::class, 'adminWelcome'])->name('dashboard');
            Route::prefix('settings')->name('settings.')->group(function(){
                Route::get('index',[MainController::class, 'index'])->name('index');
                Route::patch('/updateContent/{id}',[SMScontroller::class,'update'])->name('updateContent');
                Route::resource('contact',ContactController::class);
            });
            Route::prefix('users')->name('users.')->group(function (){
                Route::get('index',[UserController::class,'index'])->name('index');
                Route::post('register-user',[UserController::class,'store'])->name('register-user');
                Route::delete('destroy-user/{id}',[UserController::class,'destroy'])->name('destroy-user');
            });
            Route::post('notify-message/{id}',[SendSMSController::class,'notifyMessage'])->name('notify_message');
        });
    });
    Route::group(['middleware'=>['role:Guest']],function (){
        Route::prefix('floods')->name('floods.')->group(function (){
            Route::get('index',[FloodController::class,'index'])->name('index');
            Route::get('preparing-flood',[FloodController::class,'preparing_flood'])->name('preparing-flood');
            Route::get('flood-water-safety',[FloodController::class,'flood_water_safety'])->name('flood-water-safety');
            Route::get('returning-home',[FloodController::class,'returning_home'])->name('returning-home');
        });
    });
});
