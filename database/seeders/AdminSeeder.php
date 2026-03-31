<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@emp.com');
        $admin = \App\Models\Admin::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'System Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'empadmin1234')),
                'status' => true,
            ]
        );

        $this->command->info('✓ Admin User seeded: ' . $email);
    }
}
