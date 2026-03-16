<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('packages')->insert([
            [
                'name'              => 'Starter',
                'price'             => 500.00,
                'roi_percentage'    => 3.00,
                'duration_weeks'    => null,
                'description'       => 'Perfect entry-level investment. Earn 3% ROI weekly on ₹500.',
                'status'            => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'Pro',
                'price'             => 1000.00,
                'roi_percentage'    => 3.20,
                'duration_weeks'    => null,
                'description'       => 'Grow faster. Earn 3.2% ROI weekly on ₹1,000.',
                'status'            => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'name'              => 'Elite',
                'price'             => 5000.00,
                'roi_percentage'    => 3.50,
                'duration_weeks'    => null,
                'description'       => 'Maximum growth. Earn 3.5% ROI weekly on ₹5,000.',
                'status'            => true,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);

        $this->command->info('✓ Packages seeded: Starter, Pro, Elite');
    }
}
