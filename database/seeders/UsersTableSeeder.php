<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Creating a single admin user
        $user = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password'), // Remember to hash passwords
        ]);

        // Assigning a remember token
        // $user->remember_token = $user->createToken("API TOKEN")->plainTextToken;
        $user->save();
    }
}
