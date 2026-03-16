<?php

namespace App\Services;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Investment;
use App\Models\Wallet;
use App\Models\MLMTree;
use Illuminate\Support\Facades\DB;

class InvestmentService
{
    /**
     * Create a new deposit request (waiting for proof verification).
     */
    public function createDeposit(array $data)
    {
        return Deposit::create([
            'user_id' => auth()->id(),
            'amount' => $data['amount'],
            'payment_method' => $data['payment_method'],
            'transaction_hash' => $data['transaction_hash'] ?? null,
            'payment_proof' => $data['payment_proof'] ?? null,
            'status' => 'pending',
        ]);
    }

    /**
     * Approve a deposit and start the investment process.
     */
    public function approveDepositAndInvest(int $depositId)
    {
        return DB::transaction(function () use ($depositId) {
            $deposit = Deposit::findOrFail($depositId);
            
            if ($deposit->status !== 'pending') {
                throw new \Exception("Deposit is already processed.");
            }

            // 1. Update Deposit Status
            $deposit->update(['status' => 'approved']);

            $investment = Investment::create([
                'user_id' => $deposit->user_id,
                'amount' => $deposit->amount,
                'daily_roi_percentage' => 1.0, 
                'status' => 'active',
                'next_payout_at' => now()->addDays(1),
                'matures_at' => now()->addDays(365),
            ]);

            // 2. Distribute Business to Uplines (15 Levels)
            $this->distributeBusiness($deposit->user_id, $deposit->amount);

            return $investment;
        });
    }

    /**
     * Distribute business totals to uplines up to 15 levels.
     */
    protected function distributeBusiness(int $userId, float $amount)
    {
        $user = User::findOrFail($userId);
        $uplineId = $user->upline_id;
        $level = 1;

        while ($uplineId && $level <= 15) {
            $upline = User::find($uplineId);
            if (!$upline) break;

            // Direct Business for Level 1
            if ($level === 1) {
                $upline->increment('direct_business', $amount);
            }

            // Team Business for all levels (1-15)
            $upline->increment('team_business', $amount);

            // Check for Club Qualification
            $this->checkClubQualification($upline);

            $uplineId = $upline->upline_id;
            $level++;
        }
    }

    /**
     * Check if user qualifies for any of the 7 Club Reward Vouchers.
     */
    protected function checkClubQualification(User $user)
    {
        $clubLevels = [
            ['id' => 1, 'direct' => 5000,  'team' => 15000,  'reward' => 500],
            ['id' => 2, 'direct' => 7000,  'team' => 20000,  'reward' => 1000],
            ['id' => 3, 'direct' => 10000, 'team' => 40000,  'reward' => 2000],
            ['id' => 4, 'direct' => 15000, 'team' => 100000, 'reward' => 2500],
            ['id' => 5, 'direct' => 20000, 'team' => 200000, 'reward' => 3000],
            ['id' => 6, 'direct' => 30000, 'team' => 300000, 'reward' => 3500],
            ['id' => 7, 'direct' => 50000, 'team' => 700000, 'reward' => 5000],
        ];

        foreach ($clubLevels as $level) {
            $type = "club_{$level['id']}";
            
            // Check targets
            if ($user->direct_business >= $level['direct'] && $user->team_business >= $level['team']) {
                
                // One-time reward check for this specific level
                $alreadyRewarded = $user->vouchers()
                    ->where('type', $type)
                    ->exists();

                if (!$alreadyRewarded) {
                    $user->vouchers()->create([
                        'code' => strtoupper("CLUB{$level['id']}-" . str_replace('.', '', uniqid('', true))),
                        'amount' => $level['reward'],
                        'type' => $type,
                        'status' => 'unused',
                    ]);
                }
            }
        }
    }

    /**
     * Add funds to user wallet.
     */
    protected function addToWallet(int $userId, float $amount, string $category)
    {
        $wallet = Wallet::firstOrCreate(['user_id' => $userId]);
        $wallet->increment('balance', $amount);
        $wallet->increment('total_deposited', $amount);

        $wallet->user->transactions()->create([
            'amount' => $amount,
            'type' => 'deposit',
            'wallet' => 'cash',
            'direction' => 'credit',
            'balance_after' => $wallet->balance,
            'description' => "Funds credited via " . ucfirst($category),
        ]);
    }
}
