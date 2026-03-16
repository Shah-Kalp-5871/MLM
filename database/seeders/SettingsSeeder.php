<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // ROI Config
            ['key' => 'roi_min_percentage',     'value' => '3.00',      'type' => 'decimal',  'group' => 'roi',        'label' => 'Minimum Weekly ROI %',          'is_public' => true],
            ['key' => 'roi_max_percentage',     'value' => '3.50',      'type' => 'decimal',  'group' => 'roi',        'label' => 'Maximum Weekly ROI %',          'is_public' => true],
            ['key' => 'roi_distribution_day',   'value' => 'monday',    'type' => 'string',   'group' => 'roi',        'label' => 'Day ROI is distributed',        'is_public' => false],

            // Withdrawal Config
            ['key' => 'min_withdrawal_amount',  'value' => '50.00',     'type' => 'decimal',  'group' => 'withdrawal', 'label' => 'Minimum Withdrawal Amount',     'is_public' => true],
            ['key' => 'withdrawal_fee_percent', 'value' => '0.00',      'type' => 'decimal',  'group' => 'withdrawal', 'label' => 'Withdrawal Fee (%)',            'is_public' => true],
            ['key' => 'withdrawal_processing_days', 'value' => '2',     'type' => 'integer',  'group' => 'withdrawal', 'label' => 'Processing Days (max)',         'is_public' => true],

            // Platform Config
            ['key' => 'platform_name',          'value' => 'NexaNet',   'type' => 'string',   'group' => 'general',    'label' => 'Platform Name',                'is_public' => true],
            ['key' => 'platform_currency',      'value' => 'USD',       'type' => 'string',   'group' => 'general',    'label' => 'Currency Code',                'is_public' => true],
            ['key' => 'platform_currency_symbol','value' => '$',        'type' => 'string',   'group' => 'general',    'label' => 'Currency Symbol',              'is_public' => true],
            ['key' => 'referral_link_base',     'value' => '/auth/register?ref=', 'type' => 'string', 'group' => 'referral', 'label' => 'Referral Link Base URL', 'is_public' => true],

            // Level Income Config
            ['key' => 'max_level_depth',        'value' => '15',        'type' => 'integer',  'group' => 'level',      'label' => 'Max Level Depth for Commissions', 'is_public' => true],

            // Club Config
            ['key' => 'club_recalculation_frequency', 'value' => 'daily', 'type' => 'string', 'group' => 'club',      'label' => 'How often club stats refresh',  'is_public' => false],
        ];

        foreach ($settings as &$s) {
            $s['created_at'] = now();
            $s['updated_at'] = now();
        }

        DB::table('settings')->insert($settings);
        $this->command->info('✓ Platform settings seeded (ROI, Withdrawal, General)');
    }
}
