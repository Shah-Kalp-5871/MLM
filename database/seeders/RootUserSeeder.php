<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RootUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ROOT_USER_EMAIL', 'root@emp.com');
        
        // Skip if already exists
        if (User::where('email', $email)->exists()) {
            return;
        }

        $user = User::create([
            'name'          => 'System Root',
            'email'         => $email,
            'phone'         => '1234567890',
            'password'      => Hash::make(env('ROOT_USER_PASSWORD', 'emproot1234')),
            'referral_code' => 'EMP00000', // Specialized code for the first user
            'upline_id'     => null,      // The top of the tree
            'status'        => 'active',
        ]);

        Wallet::create([
            'user_id'                  => $user->id,
            'balance'                  => 0,
            'total_roi_earned'         => 0,
            'total_commission_earned'  => 0,
            'total_withdrawn'          => 0,
        ]);

        $this->command->info('✓ Root User seeded: ' . $email . ' (Code: EMP00000)');
    }
}
