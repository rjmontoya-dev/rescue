<?php

namespace App\Http\Controllers\Admin\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
class UserController extends Controller
{
    public function index(Request $request){
        $user = User::where(function ($query) use ($request) {
            $query->when($request->has('params'), function ($query) {
                $query->where('id', '!=', 1);
            });
        })
        ->paginate(10);
        return inertia('Admin/Users/Index',['users'=>$user]);
    }
    public function store(Request $request){
             $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password, 'confirmed'],

             ]);

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);
        $user->assignRole('Guest');
        return redirect()->back();
    }
    public function destroy($id){
        $find = User::findOrFail($id);
        $find->delete();
        return redirect()->back();
    }
}
