<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Manager',
            'email' => 'manager@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'role' => 1,
        ]);
        for ($i=0; $i < 50; $i++) { 
            User::create([
            'name' => 'Employee' . $i + 1,
            'email' => 'employee'. $i + 1 .'@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'role' => 0,
        ]);
        }
    }
}
