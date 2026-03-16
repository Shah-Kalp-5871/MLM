<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PackageSeeder::class,
            LevelSettingSeeder::class,
            ClubMilestoneSeeder::class,
            SettingsSeeder::class,
            AdminSeeder::class,
        ]);
    }
}
