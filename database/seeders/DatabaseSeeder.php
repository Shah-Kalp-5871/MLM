<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingsSeeder::class,
            LevelSettingSeeder::class,
            ClubLevelSeeder::class,
            AdminSeeder::class,
            RootUserSeeder::class,
        ]);
    }
}
