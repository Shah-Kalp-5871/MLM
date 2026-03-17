<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Investment;
use App\Models\ROIIncome;
use App\Models\LevelCommission;
use App\Models\Voucher;
use App\Models\WalletTransaction;
use App\Models\Deposit;
use App\Models\Setting;
use App\Services\InvestmentService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SimulateMLM extends Command
{
    protected $signature = 'mlm:simulate {--reset : Reset database before simulation}';
    protected $description = 'Simulate 3 months of MLM activity with 200 users';

    public function handle()
    {
        if ($this->option('reset')) {
            $this->resetDatabase();
        }

        $this->info('Starting MLM Simulation...');

        // 1. Create 200 Users in a Tree Structure
        $users = $this->createUsers(200);
        $this->info('200 Users created in hierarchy.');

        // 2. Each user invests $1000
        $this->initiateInvestments($users);
        $this->info('Investments of $1000 initiated for all users.');

        // 3. 90-Day Simulation Loop
        $this->simulateTime(90);

        $this->info('Simulation Completed.');
        $this->showResults();
    }

    protected function resetDatabase()
    {
        $this->warn('Resetting database tables...');
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        Investment::truncate();
        ROIIncome::truncate();
        LevelCommission::truncate();
        Voucher::truncate();
        WalletTransaction::truncate();
        Wallet::truncate();
        Deposit::truncate();
        DB::table('referrals')->truncate();
        DB::table('user_profiles')->truncate();
        DB::table('level_settings')->truncate();
        DB::table('settings')->truncate();
        DB::table('withdrawals')->truncate();
        DB::table('club_levels')->truncate(); // Added for safety
        
        // Delete all users
        User::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Ensure Core Settings & Levels are present
        $this->call('db:seed', ['--class' => 'SettingsSeeder']);
        $this->call('db:seed', ['--class' => 'LevelSettingSeeder']);
        $this->call('db:seed', ['--class' => 'ClubLevelSeeder']);
    }

    protected function createUsers($count)
    {
        $this->info("Creating root user and {$count} downlines...");
        
        // Create Root User (Level 1)
        $root = User::create([
            'name' => "Root User",
            'email' => "root@example.com",
            'password' => Hash::make('password'),
            'phone' => '0000000000',
            'referral_code' => 'ROOTMASTER',
            'upline_id' => null,
            'status' => 'active',
        ]);
        Wallet::create(['user_id' => $root->id, 'balance' => 0]);

        $users = [$root];
        $createdCount = 0;
        
        // Use a queue-like structure to build a balanced tree (2 per parent)
        $parentQueue = [$root];
        
        while ($createdCount < ($count - 1)) {
            $parent = array_shift($parentQueue);
            
            for ($i = 0; $i < 2 && $createdCount < ($count - 1); $i++) {
                $user = User::create([
                    'name' => "User " . ($createdCount + 1),
                    'email' => "user" . ($createdCount + 1) . "@example.com",
                    'password' => Hash::make('password'),
                    'phone' => '123456789' . $createdCount,
                    'referral_code' => strtoupper(Str::random(10)),
                    'upline_id' => $parent->id,
                    'status' => 'active',
                ]);
                
                // Initialize Wallet
                Wallet::create(['user_id' => $user->id, 'balance' => 0]);
                
                $users[] = $user;
                $parentQueue[] = $user;
                $createdCount++;
            }
        }

        return $users;
    }

    protected function initiateInvestments($users)
    {
        $service = app(InvestmentService::class);
        $weeklyROI = Setting::get('weekly_roi_percentage', 3);

        foreach ($users as $user) {
            if ($user->email === 'admin@gmail.com') continue;

            // Create a deposit first to trigger business distribution
            $deposit = Deposit::create([
                'user_id' => $user->id,
                'amount' => 1000,
                'payment_method' => 'manual',
                'status' => 'approved',
                'approved_at' => Carbon::now(),
            ]);

            $investment = Investment::create([
                'user_id' => $user->id,
                'amount' => 1000,
                'daily_roi_percentage' => $weeklyROI / 7,
                'weekly_roi_percentage' => $weeklyROI,
                'status' => 'active',
                'activated_at' => Carbon::now(),
                'next_payout_at' => Carbon::now()->addDays(7),
                'matures_at' => Carbon::now()->addDays(365),
            ]);

            // Trigger business distribution manually since we're bypassing the normal service flow for speed/simulation
            $this->distributeBusiness($user, 1000);
        }
    }

    protected function distributeBusiness($user, $amount)
    {
        $uplineId = $user->upline_id;
        $level = 1;

        while ($uplineId) {
            $upline = User::find($uplineId);
            if (!$upline) break;

            if ($level === 1) {
                $upline->increment('direct_business', $amount);
            }
            $upline->increment('team_business', $amount);

            $uplineId = $upline->upline_id;
            $level++;
        }
    }

    protected function simulateTime($days)
    {
        $this->info("Simulating {$days} days...");
        $startDate = Carbon::now();

        for ($d = 1; $d <= $days; $d++) {
            $currentDate = $startDate->copy()->addDays($d);
            Carbon::setTestNow($currentDate);

            // 1. ROI Distribution (Every 7 days check within command)
            $this->call('roi:distribute');

            // 2. Club Qualification Check (Daily)
            $this->call('club:check');

            if ($d % 10 === 0) {
                $this->line("Day {$d} processed...");
            }
        }
        
        Carbon::setTestNow(); // Reset time
    }

    protected function showResults()
    {
        $totalUsers = User::count();
        $totalInvested = Investment::sum('amount');
        $totalROI = ROIIncome::sum('roi_amount');
        $totalLevel = LevelCommission::sum('commission_amount');
        $totalVouchers = Voucher::count();

        $this->newLine();
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Users', $totalUsers],
                ['Total Investment', '$' . number_format($totalInvested, 2)],
                ['Total ROI Paid', '$' . number_format($totalROI, 2)],
                ['Total Level Income', '$' . number_format($totalLevel, 2)],
                ['Total Vouchers Issued', $totalVouchers],
            ]
        );

        $topEarners = User::withSum('roiIncomes', 'roi_amount')
            ->withSum('levelCommissions', 'commission_amount')
            ->get()
            ->map(function($user) {
                $total = ($user->roi_incomes_sum_roi_amount ?? 0) + ($user->level_commissions_sum_commission_amount ?? 0);
                return [
                    'name' => $user->name,
                    'total_earned' => $total
                ];
            })
            ->sortByDesc('total_earned')
            ->take(10);

        $this->newLine();
        $this->info('Top 10 Earners:');
        $this->table(
            ['Name', 'Total Earned'],
            $topEarners->toArray()
        );
    }
}
