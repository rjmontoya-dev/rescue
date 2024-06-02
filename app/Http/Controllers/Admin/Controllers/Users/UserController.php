<?php

namespace App\Http\Controllers\Admin\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\ContactInformation;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                'phone_number'=>['nullable'],
             ]);
        DB::beginTransaction();
        try{
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            ContactInformation::create([
                'name'=> $request['name'],
                'phone_number' => $request['phone_number'],
                'details'=> $request['name'].'Guest Mobile number',
            ]);

            $user->assignRole('Guest');

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $e;
        }

        return redirect()->back();
    }
    public function destroy($id){
        $find = User::findOrFail($id);
        $find->delete();
        return redirect()->back();
    }
}
