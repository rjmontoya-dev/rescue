<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'super-admin@admin.com',
                'password' => bcrypt('password'),
                'email_verified_at'=>now(),
            ],
        ];
        foreach ($users as $user) {
            $exist = User::where('email', $user['email'])->first();
            if (!$exist) {
                User::create($user);
            }
        }
    }
}
