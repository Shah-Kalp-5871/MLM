<?php

use App\Models\User;
use App\Models\Wallet;
use App\Models\Deposit;
use App\Models\Package;
use App\Models\MLMTree;
use App\Models\LevelSetting;
use App\Models\ClubMilestone;
use App\Services\InvestmentService;
use App\Services\ROIEngine;
use Illuminate\Support\Facades\DB;

// 1. Setup Environment
echo "Setting up test environment...\n";
LevelSetting::truncate();
foreach ([1 => 20, 2 => 12, 3 => 8, 4 => 5, 5 => 3] as $lvl => $pct) {
    LevelSetting::create(['level' => $lvl, 'percentage' => $pct]);
}

ClubMilestone::truncate();
ClubMilestone::create([
    'tier' => 1,
    'name' => 'Bronze',
    'direct_business_target' => 1000,
    'team_business_target' => 5000,
    'voucher_value' => 500
]);

Package::truncate();
Package::create([
    'name' => 'Gold Starter',
    'price' => 1000,
    'roi_percentage' => 1.5,
    'duration_days' => 200,
    'status' => 'active'
]);

// 2. Setup Hierarchy
echo "Setting up tree...\n";
$admin = User::first();
$upline = User::factory()->create(['name' => 'Upline User', 'upline_id' => $admin->id]);
$downline = User::factory()->create(['name' => 'Downline User', 'upline_id' => $upline->id]);

// Closure table update (Manual for test script)
MLMTree::create(['ancestor_id' => $admin->id, 'descendant_id' => $admin->id, 'distance' => 0]);
MLMTree::create(['ancestor_id' => $admin->id, 'descendant_id' => $upline->id, 'distance' => 1]);
MLMTree::create(['ancestor_id' => $upline->id, 'descendant_id' => $upline->id, 'distance' => 0]);
MLMTree::create(['ancestor_id' => $admin->id, 'descendant_id' => $downline->id, 'distance' => 2]);
MLMTree::create(['ancestor_id' => $upline->id, 'descendant_id' => $downline->id, 'distance' => 1]);
MLMTree::create(['ancestor_id' => $downline->id, 'descendant_id' => $downline->id, 'distance' => 0]);

// 3. Test Investment Flow
echo "Testing Investment Flow...\n";
$deposit = Deposit::create([
    'user_id' => $downline->id,
    'amount' => 1000,
    'method' => 'UPI',
    'status' => 'pending'
]);

$service = app(InvestmentService::class);
$service->approveDepositAndInvest($deposit->id);

echo "Checking BV...\n";
$uplineQual = $upline->clubQualification;
echo "Upline Direct BV: {$uplineQual->direct_business_volume}\n"; // Should be 1000

// 4. Test ROI Engine
echo "Testing ROI Engine...\n";
$roiEngine = app(ROIEngine::class);
$roiEngine->distributeROI();

$uplineWallet = $upline->wallet;
echo "Upline Commission Balance: {$uplineWallet->commission_balance}\n"; // 1000 * 1.5% = 15 ROI. 15 * 20% = 3 Commission.

echo "Verification Complete!\n";
