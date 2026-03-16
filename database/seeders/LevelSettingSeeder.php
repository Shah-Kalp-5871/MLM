<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSettingSeeder extends Seeder
{
    public function run(): void
    {
        // Commission structure per documentation:
        // Level 1: 20%, Level 2: 12%, Level 3: 9%
        // Levels 4–6: 6%, Levels 7–10: 4%, Levels 11–15: 2%
        $levels = [
            ['level' => 1,  'percentage' => 20.00, 'label' => 'Direct Referral'],
            ['level' => 2,  'percentage' => 12.00, 'label' => 'Level 2'],
            ['level' => 3,  'percentage' => 9.00,  'label' => 'Level 3'],
            ['level' => 4,  'percentage' => 6.00,  'label' => 'Level 4'],
            ['level' => 5,  'percentage' => 6.00,  'label' => 'Level 5'],
            ['level' => 6,  'percentage' => 6.00,  'label' => 'Level 6'],
            ['level' => 7,  'percentage' => 4.00,  'label' => 'Level 7'],
            ['level' => 8,  'percentage' => 4.00,  'label' => 'Level 8'],
            ['level' => 9,  'percentage' => 4.00,  'label' => 'Level 9'],
            ['level' => 10, 'percentage' => 4.00,  'label' => 'Level 10'],
            ['level' => 11, 'percentage' => 2.00,  'label' => 'Level 11'],
            ['level' => 12, 'percentage' => 2.00,  'label' => 'Level 12'],
            ['level' => 13, 'percentage' => 2.00,  'label' => 'Level 13'],
            ['level' => 14, 'percentage' => 2.00,  'label' => 'Level 14'],
            ['level' => 15, 'percentage' => 2.00,  'label' => 'Level 15'],
        ];

        foreach ($levels as &$level) {
            $level['is_active']   = true;
            $level['created_at']  = now();
            $level['updated_at']  = now();
        }

        DB::table('level_settings')->insert($levels);
        $this->command->info('✓ Level settings seeded: 15 levels with commission percentages');
    }
}
