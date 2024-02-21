<?php

namespace Database\Seeders;

use App\Models\ProjectSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSettingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProjectSetting::create([
            "multi_login_device" => 1
        ]);
    }
}
