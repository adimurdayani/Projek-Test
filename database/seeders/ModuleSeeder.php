<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::create([
            "module_name" => "Login",
            "module_code" => "001L"
        ]);

        Module::create([
            "module_name" => "View Dashboard",
            "module_code" => "002D"
        ]);

        Module::create([
            "module_name" => "User Management",
            "module_code" => "003U"
        ]);

        Module::create([
            "module_name" => "Role Management",
            "module_code" => "004R"
        ]);

        Module::create([
            "module_name" => "Assign Role to Module",
            "module_code" => "004RT"
        ]);

        Module::create([
            "module_name" => "Allow Settings",
            "module_code" => "005S"
        ]);
    }
}
