<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "role_id" => 1,
            "email" => "admin@gmail.com",
            "name" => "Admin",
            "username" => "admin",
            "password" => Hash::make("admin123!@#")
        ]);
    }
}
