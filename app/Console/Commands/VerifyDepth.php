<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Investment;
use App\Models\ROIIncome;
use App\Models\Wallet;
use App\Services\InvestmentService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class VerifyDepth extends Command
{
    protected $signature = 'mlm:verify';
    protected $description = 'Verify dynamic depth logic';

    public function handle()
    {
        $service = app(InvestmentService::class);
        $this->info("--- MLM DYNAMIC DEPTH VERIFICATION ---");

        DB::beginTransaction();
        try {
            // Clear existing test users
            User::where('email', 'like', 'test%')->delete();
            User::where('email', 'like', 'direct%')->delete();

            // 1. Setup Chain: A -> B -> C -> D -> E
            // Levels from E's perspective: D=1, C=2, B=3, A=4
            $a = User::create(['name' => 'Test A', 'email' => 'testA@example.com', 'password' => 'pass', 'referral_code' => 'A'.uniqid()]);
            $b = User::create(['name' => 'Test B', 'email' => 'testB@example.com', 'password' => 'pass', 'referral_code' => 'B'.uniqid(), 'upline_id' => $a->id]);
            $c = User::create(['name' => 'Test C', 'email' => 'testC@example.com', 'password' => 'pass', 'referral_code' => 'C'.uniqid(), 'upline_id' => $b->id]);
            $d = User::create(['name' => 'Test D', 'email' => 'testD@example.com', 'password' => 'pass', 'referral_code' => 'D'.uniqid(), 'upline_id' => $c->id]);
            $e = User::create(['name' => 'Test E', 'email' => 'testE@example.com', 'password' => 'pass', 'referral_code' => 'E'.uniqid(), 'upline_id' => $d->id]);

            Wallet::create(['user_id' => $a->id, 'balance' => 0]);
            Wallet::create(['user_id' => $b->id, 'balance' => 0]);
            Wallet::create(['user_id' => $c->id, 'balance' => 0]);
            Wallet::create(['user_id' => $d->id, 'balance' => 0]);
            Wallet::create(['user_id' => $e->id, 'balance' => 0]);

            // A needs $500 investment to be qualified at all
            $a->investments()->create([
                'amount' => 500, 'status' => 'active', 'weekly_roi_percentage' => 3, 'daily_roi_percentage' => 3/7,
                'next_payout_at' => now()->addDays(7), 'activated_at' => now(), 'matures_at' => now()->addYear()
            ]);
            // B needs an investment so A has 1 active direct
            $b->investments()->create([
                'amount' => 500, 'status' => 'active', 'weekly_roi_percentage' => 3, 'daily_roi_percentage' => 3/7,
                'next_payout_at' => now()->addDays(7), 'activated_at' => now(), 'matures_at' => now()->addYear()
            ]);
            // E also needs $500 to count for uplines
            $e->investments()->create([
                'amount' => 500, 'status' => 'active', 'weekly_roi_percentage' => 3, 'daily_roi_percentage' => 3/7,
                'next_payout_at' => now()->addDays(7), 'activated_at' => now(), 'matures_at' => now()->addYear()
            ]);

            // --- TEST CASE 1: A has only 1 direct (B) ---
            $this->warn("\nTEST 1: A has 1 direct (B). Eligible Depth = 1.");
            $this->info("A Eligible Depth: " . $a->getEligibleDepth());
            
            $this->info("Action: E (Level 4) invests $1000.");
            $service->distributeBusiness($e->id, 1000);
            $a->refresh();
            $this->info("A Team Business: $" . $a->team_business . " (Expected: 0)");

            $this->info("Action: B (Level 1) invests $1000.");
            $service->distributeBusiness($b->id, 1000);
            $a->refresh();
            $this->info("A Team Business: $" . $a->team_business . " (Expected: 1000)");

            // --- TEST CASE 2: A has 4 directs ---
            $this->warn("\nTEST 2: A has 4 directs. E is Level 4.");
            for($i=1; $i<=3; $i++) {
                $u = User::create(['name' => "Direct $i", 'email' => "direct$i@example.com", 'password' => 'pass', 'referral_code' => "D".uniqid(), 'upline_id' => $a->id]);
                $u->investments()->create([
                    'amount' => 500, 
                    'status' => 'active', 
                    'weekly_roi_percentage' => 3, 
                    'daily_roi_percentage' => 3/7,
                    'next_payout_at' => now()->addDays(7), 
                    'activated_at' => now(),
                    'matures_at' => now()->addYear()
                ]);
            }
            $a->refresh();
            $this->info("A Eligible Depth: " . $a->getEligibleDepth());
            $service->distributeBusiness($e->id, 1000);
            $a->refresh();
            $this->info("A Team Business: $" . $a->team_business . " (Expected: 1000)");

            // --- TEST CASE 3: Level Income Distribution ---
            $this->warn("\nTEST 3: Level Income Distribution (A has depth 4, E is Level 4)");
            $roi = ROIIncome::create([
                'user_id' => $e->id,
                'investment_id' => $e->investments->first()->id,
                'week_key' => '2026-W01',
                'investment_amount' => 500,
                'roi_percentage' => 3,
                'roi_amount' => 100,
                'week_number' => 1,
                'for_week_ending' => now(),
                'distributed_at' => now()
            ]);
            $service->distributeROICommissions($roi);
            $a->refresh();
            $commission = $a->levelCommissions()->where('from_user_id', $e->id)->first();
            $this->info("A Level Commission: " . ($commission ? '$'.$commission->commission_amount : 'None') . " (Expected: > 0)");

            // --- TEST CASE 4: Level Income Restricted ---
            $this->warn("\nTEST 4: Level Income Restricted (A has depth 4, F is Level 5)");
            $f = User::create(['name' => 'Test F', 'email' => 'testF@example.com', 'password' => 'pass', 'referral_code' => 'F1', 'upline_id' => $e->id]);
            Wallet::create(['user_id' => $f->id, 'balance' => 0]);
            // F needs $500 for A to even consider them? No, ROI distribution checks investor qualification.
            $f->investments()->create([
                'amount' => 500, 
                'status' => 'active', 
                'weekly_roi_percentage' => 3, 
                'daily_roi_percentage' => 3/7,
                'next_payout_at' => now()->addDays(7), 
                'activated_at' => now(),
                'matures_at' => now()->addYear()
            ]);
            
            $roiF = ROIIncome::create([
                'user_id' => $f->id,
                'investment_id' => $f->investments->first()->id,
                'week_key' => '2026-W02',
                'investment_amount' => 500,
                'roi_percentage' => 3,
                'roi_amount' => 100,
                'week_number' => 1,
                'for_week_ending' => now(),
                'distributed_at' => now()
            ]);
            $service->distributeROICommissions($roiF);
            $a->refresh();
            $commissionF = $a->levelCommissions()->where('from_user_id', $f->id)->first();
            $this->info("A Level Commission from F: " . ($commissionF ? '$'.$commissionF->commission_amount : 'None') . " (Expected: None)");

            $this->info("\nAll tests completed successfully.");
        } catch (\Exception $e) {
            $this->error("Error during verification: " . $e->getMessage());
        } finally {
            DB::rollBack();
        }
    }
}
