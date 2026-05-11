<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Investment;
use App\Models\Voucher;
use App\Models\ClubLevel;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ReconcileClubRewards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'club:reconcile 
                            {--dry-run : Preview changes without affecting the database} 
                            {--execute : Perform the actual reconciliation} 
                            {--force : Required for --execute to run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reconcile club rewards and business volumes based on new dynamic depth logic.';

    private $stats = [
        'checked' => 0,
        'affected_users' => 0,
        'revoked_vouchers' => 0,
        'manual_review_vouchers' => 0,
        'skipped_cases' => 0,
    ];

    private $logFile;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->logFile = storage_path('logs/club_reward_reconcile.log');

        $dryRun = $this->option('dry-run');
        $execute = $this->option('execute');
        $force = $this->option('force');

        if (!$dryRun && (!$execute || !$force)) {
            $this->error('ERROR: You must specify either --dry-run or both --execute and --force.');
            $this->info('Usage:');
            $this->line('  php artisan club:reconcile --dry-run');
            $this->line('  php artisan club:reconcile --execute --force');
            return 1;
        }

        if ($execute && !$force) {
            $this->error('ERROR: The --force flag is required when using --execute.');
            return 1;
        }

        $this->info($dryRun ? '=== [DRY RUN MODE] ===' : '=== [EXECUTE MODE] ===');
        $this->info('Starting Club Reward Reconciliation...');
        
        // Ensure log directory exists
        if (!File::exists(dirname($this->logFile))) {
            File::makeDirectory(dirname($this->logFile), 0755, true);
        }

        $this->log('------------------------------------------------------------');
        $this->log($dryRun ? "RECONCILIATION STARTED (DRY RUN)" : "RECONCILIATION STARTED (EXECUTE)");

        // We target users who have club vouchers or non-zero business values
        $users = User::where(function($query) {
            $query->whereHas('vouchers', function($q) {
                $q->where('type', 'like', 'club_%');
            })->orWhere('team_business', '>', 0)
              ->orWhere('direct_business', '>', 0);
        })->get();

        $this->info("Found " . $users->count() . " users to analyze.");
        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            $this->processUser($user, $dryRun);
            $this->stats['checked']++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        
        $this->displaySummary();
        $this->info("Detailed audit log available at: " . $this->logFile);
        $this->log("RECONCILIATION FINISHED");
        
        return 0;
    }

    /**
     * Process a single user and check their qualification against recalculated volume.
     */
    private function processUser(User $user, bool $dryRun)
    {
        $eligibleDepth = $user->getEligibleDepth();
        $recalculated = $this->recalculateBusiness($user, $eligibleDepth);

        // Check for discrepancies in current vs recalculated business
        $hasBusinessChange = (
            abs($user->direct_business - $recalculated['direct']) > 0.01 ||
            abs($user->team_business - $recalculated['team']) > 0.01
        );

        if ($hasBusinessChange) {
            $this->stats['affected_users']++;
            $this->log("User #{$user->id} ({$user->email}):");
            $this->log("  Business Correction: Direct: {$user->direct_business} -> {$recalculated['direct']}, Team: {$user->team_business} -> {$recalculated['team']} (Depth: {$eligibleDepth})");
            
            if (!$dryRun) {
                $user->update([
                    'direct_business' => $recalculated['direct'],
                    'team_business' => $recalculated['team']
                ]);
            }
        }

        // Check Club Vouchers against recalculated qualification
        $vouchers = $user->vouchers()->where('type', 'like', 'club_%')->get();
        $clubLevels = ClubLevel::orderBy('level', 'asc')->get();

        foreach ($vouchers as $voucher) {
            // Skip already revoked or manual review cases to avoid redundancy
            if (in_array($voucher->status, ['revoked', 'manual_review_required'])) {
                continue;
            }

            $levelNum = str_replace('club_', '', $voucher->type);
            $level = $clubLevels->where('level', $levelNum)->first();

            if (!$level) {
                $this->log("  [WARN] Voucher {$voucher->code} has unknown type: {$voucher->type}. Skipping.");
                $this->stats['skipped_cases']++;
                continue;
            }

            // Verify qualification using recalculated volumes
            $isQualified = (
                $recalculated['direct'] >= $level->direct_required && 
                $recalculated['team'] >= $level->team_required
            );

            if (!$isQualified) {
                if ($voucher->status === 'unused') {
                    $this->stats['revoked_vouchers']++;
                    $this->log("  [ACTION] Voucher {$voucher->code} (Level {$levelNum}) -> REVOKE (Reason: Depth Limit)");
                    
                    if (!$dryRun) {
                        $voucher->update([
                            'status' => 'revoked',
                            'description' => ($voucher->description ?? '') . " | Revoked via reconciliation on " . now()->toDateTimeString()
                        ]);
                    }
                } else {
                    // Voucher already used or redeemed
                    $this->stats['manual_review_vouchers']++;
                    $this->log("  [FLAG] Voucher {$voucher->code} (Level {$levelNum}) -> MANUAL REVIEW REQUIRED (Currently {$voucher->status})");
                    
                    if (!$dryRun) {
                        $voucher->update([
                            'status' => 'manual_review_required'
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Recalculate direct and team business using BFS up to the user's eligible depth.
     */
    private function recalculateBusiness(User $user, int $eligibleDepth)
    {
        $business = ['direct' => 0, 'team' => 0];
        
        if ($eligibleDepth <= 0) {
            return $business;
        }

        $queue = [[$user->id, 0]]; // [uplineId, currentLevel]
        $visited = [$user->id];

        while (!empty($queue)) {
            [$parentId, $currentLevel] = array_shift($queue);

            // Do not traverse beyond the user's eligible depth or the system max of 15
            if ($currentLevel >= 15 || $currentLevel >= $eligibleDepth) {
                continue;
            }

            $referrals = User::where('upline_id', $parentId)->get();

            foreach ($referrals as $referral) {
                if (in_array($referral->id, $visited)) continue;
                $visited[] = $referral->id;

                $levelRelativeToTarget = $currentLevel + 1;

                // Sum all non-cancelled investments.
                // We count them if the user meets the minimum qualification threshold (cumulative).
                $totalReferralInvestment = $referral->investments()
                    ->where('status', '!=', 'cancelled')
                    ->sum('amount');

                if ($totalReferralInvestment >= Investment::MIN_QUALIFIED_AMOUNT) {
                    if ($levelRelativeToTarget === 1) {
                        $business['direct'] += $totalReferralInvestment;
                    }
                    $business['team'] += $totalReferralInvestment;
                }

                // Continue traversal if depth remains
                if ($levelRelativeToTarget < $eligibleDepth && $levelRelativeToTarget < 15) {
                    $queue[] = [$referral->id, $levelRelativeToTarget];
                }
            }
        }

        return $business;
    }

    /**
     * Display a clean summary of the reconciliation results.
     */
    private function displaySummary()
    {
        $this->table(
            ['Metric', 'Value'],
            [
                ['Total Users Checked', $this->stats['checked']],
                ['Users with Business Updates', $this->stats['affected_users']],
                ['Vouchers Revoked (Unused)', $this->stats['revoked_vouchers']],
                ['Manual Review Required (Used)', $this->stats['manual_review_vouchers']],
                ['Skipped Uncertain Cases', $this->stats['skipped_cases']],
            ]
        );
    }

    /**
     * Append message to the reconciliation log file.
     */
    private function log($message)
    {
        $timestamp = now()->toDateTimeString();
        File::append($this->logFile, "[{$timestamp}] {$message}" . PHP_EOL);
    }
}
