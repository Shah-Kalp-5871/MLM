<?php

namespace App\Services;

use App\Models\Investment;
use App\Models\ROIIncome;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ROIEngine
{
    public function __construct(protected CommissionService $commissionService) {}

    /**
     * Distribute ROI for all active investments.
     * This would typically be called by a scheduled console command.
     */
    public function distributeROI()
    {
        return DB::transaction(function () {
            // Get active investments where next_payout_at <= now
            $investments = Investment::where('status', 'active')
                ->where('next_payout_at', '<=', now())
                ->with('user.wallet')
                ->get();

            $results = [
                'processed' => 0,
                'total_amount' => 0,
            ];

            foreach ($investments as $investment) {
                $payoutAmount = ($investment->amount * $investment->daily_roi_percentage) / 100;

                // 1. Log ROI Income record
                $roi = ROIIncome::create([
                    'user_id' => $investment->user_id,
                    'investment_id' => $investment->id,
                    'investment_amount' => $investment->amount,
                    'roi_percentage' => $investment->daily_roi_percentage,
                    'roi_amount' => $payoutAmount,
                    'week_number' => now()->weekOfYear,
                    'for_week_ending' => now()->endOfWeek(),
                    'distributed_at' => now(),
                ]);

                // 2. Update Investment Stats
                $investment->increment('total_roi_earned', $payoutAmount);
                $investment->update(['next_payout_at' => now()->addDays(1)]);

                // 3. Credit User's ROI Balance in Wallet
                $wallet = Wallet::firstOrCreate(['user_id' => $investment->user_id]);
                $wallet->increment('balance', $payoutAmount);
                $wallet->increment('total_roi_earned', $payoutAmount);

                $wallet->user->transactions()->create([
                    'amount' => $payoutAmount,
                    'type' => 'roi_income',
                    'wallet' => 'cash',
                    'direction' => 'credit',
                    'balance_after' => $wallet->balance,
                    'description' => "Daily ROI for Investment #{$investment->id}",
                    'reference_id' => $roi->id,
                    'reference_type' => ROIIncome::class,
                ]);

                // 4. Trigger Level Commission Distribution
                $this->commissionService->distributeLevelCommissions($investment->user_id, $payoutAmount, $investment->id, $roi->id);

                $results['processed']++;
                $results['total_amount'] += $payoutAmount;
            }

            return $results;
        });
    }
}
