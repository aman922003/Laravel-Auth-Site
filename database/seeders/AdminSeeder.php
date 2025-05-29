<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('Admin@123'),
            // 'password' =>'Admin@123',
            'role' => 'admin', // Make sure this matches your role field in DB
        ]);
    }
}
