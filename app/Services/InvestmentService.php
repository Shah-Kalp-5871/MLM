<?php

namespace App\Services;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Investment;
use App\Models\Wallet;

use Illuminate\Support\Facades\DB;

use App\Models\ROIIncome;
use App\Models\LevelSetting;
use App\Models\LevelCommission;
use App\Models\WalletTransaction;

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
            $deposit->update(['status' => 'approved', 'approved_at' => now(), 'approved_by' => auth()->id()]);

            // Mark applied voucher as used
            if ($deposit->voucher_code) {
                $voucher = \App\Models\Voucher::where('code', $deposit->voucher_code)->first();
                if ($voucher && $voucher->status === 'unused') {
                    $voucher->update(['status' => 'used', 'used_at' => now()]);
                }
            }

            // 2. Add Funds to Wallet (if not internal transfer)
            if ($deposit->payment_method !== 'internal_wallet') {
                $actualCashPaid = $deposit->amount - ($deposit->discount_amount ?? 0);
                if ($actualCashPaid > 0) {
                    $this->addToWallet($deposit->user_id, $actualCashPaid, $deposit->payment_method);
                }
            }

            $weeklyROI = \App\Models\Setting::get('weekly_roi_percentage');

            $investment = Investment::create([
                'user_id' => $deposit->user_id,
                'amount' => $deposit->amount,
                'daily_roi_percentage' => $weeklyROI / 7, // Kept for legacy if needed
                'weekly_roi_percentage' => $weeklyROI,
                'status' => 'active',
                'next_payout_at' => now()->addDays(7),
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
    public function distributeBusiness(int $userId, float $amount)
    {
        $user = User::findOrFail($userId);
        $uplineId = $user->upline_id;
        $level = 1;

        while ($uplineId) {
            $upline = User::find($uplineId);
            if (!$upline) break;

            // Direct Business for Level 1 only
            if ($level === 1) {
                $upline->increment('direct_business', $amount);
            }

            // Team Business for all levels (Infinite Depth)
            $upline->increment('team_business', $amount);

            // Check for Club Qualification
            $this->checkClubQualification($upline);

            $uplineId = $upline->upline_id;
            $level++;
        }
    }

    public function invokeCheckClubQualification(User $user)
    {
        $this->checkClubQualification($user);
    }

    protected function checkClubQualification(User $user)
    {
        $clubLevels = \App\Models\ClubLevel::orderBy('level', 'asc')->get();

        foreach ($clubLevels as $level) {
            $type = "club_{$level->level}";
            
            // Check targets
            if ($user->direct_business >= $level->direct_required && $user->team_business >= $level->team_required) {
                
                // One-time reward check for this specific level
                $alreadyRewarded = $user->vouchers()
                    ->where('type', $type)
                    ->exists();

                if (!$alreadyRewarded) {
                    $user->vouchers()->create([
                        'code' => strtoupper("CLUB{$level->level}-" . str_replace('.', '', uniqid('', true))),
                        'amount' => $level->reward_amount,
                        'description' => $level->title, // Add title to voucher description if needed
                        'type' => $type,
                        'status' => 'unused',
                    ]);
                }
            }
        }
    }

    /**
     * Distribute commissions to uplines when a downline receives ROI.
     */
    public function distributeROICommissions(ROIIncome $roiIncome)
    {
        DB::transaction(function () use ($roiIncome) {
            $user = $roiIncome->user;
            $uplineId = $user->upline_id;
            $level = 1;

            while ($uplineId && $level <= 15) {
                $upline = User::find($uplineId);
                if (!$upline) break;

                // ONLY GIVE INCOME IF UPLINE HAS ACTIVE INVESTMENT
                $hasActiveInvestment = $upline->investments()->where('status', 'active')->exists();

                if (!$hasActiveInvestment) {
                    // Skip inactive upline, move to next
                    $uplineId = $upline->upline_id;
                    $level++;
                    continue;
                }

                // Get commission percentage for this level
                $levelSetting = LevelSetting::where('level', $level)->where('is_active', true)->first();
                
                if ($levelSetting) {
                    $commissionAmount = $roiIncome->roi_amount * ($levelSetting->percentage / 100);

                    if ($commissionAmount > 0) {
                        // 1. Credit Upline Wallet
                        $wallet = Wallet::firstOrCreate(['user_id' => $upline->id]);
                        $wallet->increment('balance', $commissionAmount);

                        // 2. Create Level Commission Record
                        LevelCommission::create([
                            'receiver_id' => $upline->id,
                            'from_user_id' => $user->id,
                            'roi_income_id' => $roiIncome->id,
                            'level' => $level,
                            'roi_amount' => $roiIncome->roi_amount,
                            'commission_percentage' => $levelSetting->percentage,
                            'commission_amount' => $commissionAmount,
                            'created_at' => now(),
                        ]);

                        // 3. Log Transaction
                        $upline->transactions()->create([
                            'amount' => $commissionAmount,
                            'type' => 'level_income',
                            'wallet' => 'cash',
                            'direction' => 'credit',
                            'balance_after' => $wallet->balance,
                            'description' => "Level {$level} ROI commission from {$user->name}",
                        ]);
                    }
                }

                $uplineId = $upline->upline_id;
                $level++;
            }
        });
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
