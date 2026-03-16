<?php

namespace App\Http\Controllers;

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

class TestController extends Controller
{
    public function verify()
    {
        return DB::transaction(function () {
            $output = [];
            
            // 1. Setup Environment
            $output[] = "Setting up test environment...";
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            LevelSetting::query()->delete();
            ClubMilestone::query()->delete();
            Package::query()->delete();
            MLMTree::query()->delete();
            User::withTrashed()->whereIn('email', ['admin@test.com', 'upline@test.com', 'downline@test.com'])->forceDelete();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            foreach ([1 => 20, 2 => 12, 3 => 8, 4 => 5, 5 => 3] as $lvl => $pct) {
                LevelSetting::create(['level' => $lvl, 'percentage' => $pct]);
            }

            ClubMilestone::create([
                'tier' => 1,
                'name' => 'Bronze',
                'direct_business_target' => 1000,
                'team_business_target' => 5000,
                'voucher_value' => 500
            ]);

            Package::create([
                'name' => 'Gold Starter',
                'price' => 1000,
                'roi_percentage' => 1.5,
                'duration_days' => 365,
                'status' => 'active'
            ]);
            $package = Package::first();

            // 2. Setup Hierarchy
            $output[] = "Setting up tree...";
            $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin', 'email' => 'admin@test.com', 'name' => 'Admin User']);
            $upline = User::factory()->create(['name' => 'Upline User', 'email' => 'upline@test.com', 'upline_id' => $admin->id]);
            $downline = User::factory()->create(['name' => 'Downline User', 'email' => 'downline@test.com', 'upline_id' => $upline->id]);

            // Clear previous tree for these users to avoid duplicates
            MLMTree::whereIn('descendant_id', [$admin->id, $upline->id, $downline->id])->delete();

            // Closure table update
            MLMTree::create(['ancestor_id' => $admin->id, 'descendant_id' => $admin->id, 'distance' => 0]);
            MLMTree::create(['ancestor_id' => $admin->id, 'descendant_id' => $upline->id, 'distance' => 1]);
            MLMTree::create(['ancestor_id' => $upline->id, 'descendant_id' => $upline->id, 'distance' => 0]);
            MLMTree::create(['ancestor_id' => $admin->id, 'descendant_id' => $downline->id, 'distance' => 2]);
            MLMTree::create(['ancestor_id' => $upline->id, 'descendant_id' => $downline->id, 'distance' => 1]);
            MLMTree::create(['ancestor_id' => $downline->id, 'descendant_id' => $downline->id, 'distance' => 0]);

            // 3. Test Investment Flow
            $output[] = "Testing Investment Flow...";
            $deposit = Deposit::create([
                'user_id' => $downline->id,
                'package_id' => $package->id,
                'amount' => 1000,
                'payment_method' => 'upi',
                'status' => 'pending'
            ]);

            $service = app(InvestmentService::class);
            $investment = $service->approveDepositAndInvest($deposit->id);
            $investment->update(['next_payout_at' => now()]);

            $uplineQual = $upline->fresh()->clubQualification;
            $output[] = "Upline Direct BV: " . ($uplineQual->direct_business ?? 0);

            // 4. Test ROI Engine
            $output[] = "Testing ROI Engine...";
            $roiEngine = app(ROIEngine::class);
            $res = $roiEngine->distributeROI();
            $output[] = "ROI Distributed to: " . $res['processed'] . " accounts";

            $uplineWallet = $upline->fresh()->wallet;
            $output[] = "Upline Commission Balance: " . ($uplineWallet->total_level_earned ?? 0);

            return response()->json($output);
        });
    }
}
