<?php

namespace App\Console\Commands;

use App\Models\Investment;
use App\Models\ROIIncome;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DistributeROI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roi:distribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate and distribute weekly ROI to users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $investments = Investment::where('status', 'active')
            ->where('next_payout_at', '<=', now()->endOfDay())
            ->get();

        if ($investments->isEmpty()) {
            $this->info('No investments due for payout.');
            return;
        }

        $this->info('Processing ' . $investments->count() . ' investments...');

        foreach ($investments as $investment) {
            $this->processPayout($investment);
        }

        $this->info('ROI distribution completed.');
    }

    protected function processPayout(Investment $investment)
    {
        DB::transaction(function () use ($investment) {
            // Key is the Monday date of this payout cycle (e.g. "2026-06-09")
            $weekKey = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->format('Y-m-d');

            // Duplicate Protection Check (Strict Weekly)
            $alreadyPaidThisWeek = ROIIncome::where('investment_id', $investment->id)
                ->where('week_key', $weekKey)
                ->exists();
                
            if ($alreadyPaidThisWeek) {
                return;
            }

            // $500 Minimum Threshold Check
            $totalActiveInvestment = \App\Models\Investment::where('user_id', $investment->user_id)
                ->where('status', 'active')
                ->sum('amount');
                
            if ($totalActiveInvestment < Investment::MIN_QUALIFIED_AMOUNT) {
                // Postpone payout by 7 days since threshold isn't met (Align to next Monday)
                $nextPostponedMonday = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY);
                if ($nextPostponedMonday->isToday() || $nextPostponedMonday->isPast()) {
                    $nextPostponedMonday->addWeek();
                }
                
                $investment->update([
                    'next_payout_at' => $nextPostponedMonday,
                ]);
                $this->line("Skipped User ID: {$investment->user_id} (Total investment: \${$totalActiveInvestment} < \$" . Investment::MIN_QUALIFIED_AMOUNT . ")");
                return;
            }

            // --- Monday-Centralized ROI Calculation ---
            // First payout: pro-rata daily rate × days active since activation
            // All subsequent payouts: flat weekly rate
            $isFirstPayout = ($investment->total_roi_earned == 0);

            if ($isFirstPayout) {
                $activatedDay  = $investment->created_at->startOfDay();
                $thisMondayDay = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->startOfDay();
                $daysActive    = $activatedDay->diffInDays($thisMondayDay);

                $dailyRoiAmount = $investment->amount * ($investment->weekly_roi_percentage / 7 / 100);
                $roiAmount      = round($dailyRoiAmount * $daysActive, 2);

                $this->line("First payout for User ID: {$investment->user_id} — {$daysActive} active days (pro-rata \$" . number_format($roiAmount, 2) . ")");
            } else {
                // Flat weekly ROI for all payouts after the first
                $roiAmount = $investment->amount * ($investment->weekly_roi_percentage / 100);
            }

            // 1. Credit Wallet
            $wallet = Wallet::firstOrCreate(['user_id' => $investment->user_id]);
            $wallet->increment('balance', $roiAmount);

            // 2. Log Transaction
            WalletTransaction::create([
                'user_id' => $investment->user_id,
                'amount' => $roiAmount,
                'type' => 'roi_income',
                'wallet' => 'cash',
                'direction' => 'credit',
                'balance_after' => $wallet->balance,
                'description' => "Weekly ROI for Plan #PLAT-{$investment->id}",
            ]);

            // 3. Record ROI Income
            $weekNumber = ROIIncome::where('investment_id', $investment->id)->count() + 1;
            
            $roiIncome = ROIIncome::create([
                'user_id' => $investment->user_id,
                'investment_id' => $investment->id,
                'week_key' => $weekKey,
                'investment_amount' => $investment->amount,
                'roi_percentage' => $investment->weekly_roi_percentage,
                'roi_amount' => $roiAmount,
                'week_number' => $weekNumber,
                'for_week_ending' => now(),
                'distributed_at' => now(),
            ]);

            // 4. Distribute Network Commissions
            app(\App\Services\InvestmentService::class)->distributeROICommissions($roiIncome);

            // 5. Update Investment record
            $investment->increment('total_roi_earned', $roiAmount);

            // Strictly align next payout to the next upcoming Monday
            $nextMondayDate = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY);
            if ($nextMondayDate->isToday() || $nextMondayDate->isPast()) {
                $nextMondayDate->addWeek();
            }

            $investment->update([
                'next_payout_at' => $nextMondayDate,
            ]);

            $this->line("Successfully processed \$" . number_format($roiAmount, 2) . " for User ID: {$investment->user_id}");
        });
    }
}
