<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('admins')->insert([
            [
                'name'       => 'Super Admin',
                'email'      => 'admin@nexanet.com',
                'password'   => Hash::make('Admin@123'),
                'role'       => 'super_admin',
                'status'     => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $this->command->info('✓ Admin seeded: admin@nexanet.com / Admin@123 (CHANGE IN PRODUCTION!)');
    }
}
