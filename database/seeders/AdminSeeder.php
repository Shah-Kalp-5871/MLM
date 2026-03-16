<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@nexanet.com'],
            [
                'name'              => 'Super Admin',
                'password'          => Hash::make('Admin@123'),
                'role'              => 'admin',
                'status'            => 'active',
                'referral_code'     => 'ADMIN001',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        );

        $this->command->info('✓ Admin seeded: admin@nexanet.com / Admin@123 (CHANGE IN PRODUCTION!)');
    }
}
