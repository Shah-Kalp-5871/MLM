<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClubMilestoneSeeder extends Seeder
{
    public function run(): void
    {
        // 7 tiers per documentation
        $milestones = [
            [
                'tier'                    => 1,
                'name'                    => 'Bronze Club',
                'direct_business_target'  => 5000.00,
                'team_business_target'    => 15000.00,
                'voucher_value'           => 500.00,
            ],
            [
                'tier'                    => 2,
                'name'                    => 'Silver Club',
                'direct_business_target'  => 7000.00,
                'team_business_target'    => 20000.00,
                'voucher_value'           => 1000.00,
            ],
            [
                'tier'                    => 3,
                'name'                    => 'Gold Club',
                'direct_business_target'  => 10000.00,
                'team_business_target'    => 40000.00,
                'voucher_value'           => 2000.00,
            ],
            [
                'tier'                    => 4,
                'name'                    => 'Platinum Club',
                'direct_business_target'  => 15000.00,
                'team_business_target'    => 100000.00,
                'voucher_value'           => 2500.00,
            ],
            [
                'tier'                    => 5,
                'name'                    => 'Diamond Club',
                'direct_business_target'  => 20000.00,
                'team_business_target'    => 200000.00,
                'voucher_value'           => 3000.00,
            ],
            [
                'tier'                    => 6,
                'name'                    => 'Elite Club',
                'direct_business_target'  => 30000.00,
                'team_business_target'    => 300000.00,
                'voucher_value'           => 3500.00,
            ],
            [
                'tier'                    => 7,
                'name'                    => 'Crown Club',
                'direct_business_target'  => 50000.00,
                'team_business_target'    => 700000.00,
                'voucher_value'           => 5000.00,
            ],
        ];

        foreach ($milestones as &$m) {
            $m['is_active']  = true;
            $m['created_at'] = now();
            $m['updated_at'] = now();
        }

        DB::table('club_milestones')->insert($milestones);
        $this->command->info('✓ Club milestones seeded: 7 tiers (Bronze → Crown)');
    }
}
