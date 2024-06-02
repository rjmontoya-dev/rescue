<?php

namespace App\Actions\Fortify;

use App\Models\ContactInformation;
use App\Models\User;
use App\Services\SendMailService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number'=> ['nullable'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        DB::beginTransaction();
        try{
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => Hash::make($input['password']),
            ]);

            ContactInformation::create([
                'name'=> $input['name'],
                'phone_number' => $input['phone_number'],
                'details'=> $input['name'].'Guest Mobile number',
            ]);

            $user->assignRole('Guest');

            DB::commit();

            return $user;

        }catch(\Exception $e){
            DB::rollBack();
            return $e;
        }
        // SendMailService::newAccountMail($user);
    }
}
