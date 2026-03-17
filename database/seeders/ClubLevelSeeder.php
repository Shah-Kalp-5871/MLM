<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClubLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\ClubLevel::truncate();

        $levels = [
            [
                'level' => 1,
                'title' => 'Star Club',
                'direct_required' => 5000,
                'team_required' => 15000,
                'reward_amount' => 500
            ],
            [
                'level' => 2,
                'title' => 'Silver Club',
                'direct_required' => 7000,
                'team_required' => 20000,
                'reward_amount' => 1000
            ],
            [
                'level' => 3,
                'title' => 'Gold Club',
                'direct_required' => 10000,
                'team_required' => 40000,
                'reward_amount' => 2000
            ],
            [
                'level' => 4,
                'title' => 'Platinum Club',
                'direct_required' => 15000,
                'team_required' => 100000,
                'reward_amount' => 2500
            ],
            [
                'level' => 5,
                'title' => 'Diamond Club',
                'direct_required' => 20000,
                'team_required' => 200000,
                'reward_amount' => 3000
            ],
            [
                'level' => 6,
                'title' => 'Crown Club',
                'direct_required' => 30000,
                'team_required' => 300000,
                'reward_amount' => 3500
            ],
            [
                'level' => 7,
                'title' => 'Ambassador Club',
                'direct_required' => 50000,
                'team_required' => 700000,
                'reward_amount' => 5000
            ],
        ];

        foreach ($levels as $level) {
            \App\Models\ClubLevel::create($level);
        }
    }
}
