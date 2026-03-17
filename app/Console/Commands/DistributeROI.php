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
            ->where('next_payout_at', '<=', now())
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
            $roiAmount = $investment->amount * ($investment->weekly_roi_percentage / 100);

            // 1. Credit Wallet
            $wallet = Wallet::firstOrCreate(['user_id' => $investment->user_id]);
            $wallet->increment('balance', $roiAmount);

            // 2. Log Transaction
            WalletTransaction::create([
                'user_id' => $investment->user_id,
                'amount' => $roiAmount,
                'type' => 'roi',
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
            $investment->update([
                'next_payout_at' => $investment->next_payout_at->addDays(7),
            ]);

            $this->line("Successfully processed \$" . number_format($roiAmount, 2) . " for User ID: {$investment->user_id}");
        });
    }
}
