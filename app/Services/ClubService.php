<?php

namespace App\Services;

use App\Models\User;
use App\Models\ClubMilestone;
use App\Models\ClubQualification;
use App\Models\ClubReward;
use App\Models\Voucher;
use App\Models\VoucherAssignment;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ClubService
{
    /**
     * Issue rewards for reaching a milestone.
     */
    public function awardMilestoneReward(int $userId, ClubMilestone $milestone)
    {
        return DB::transaction(function () use ($userId, $milestone) {
            // 1. Log the Reward
            $reward = ClubReward::create([
                'user_id' => $userId,
                'club_milestone_id' => $milestone->id,
                'tier' => $milestone->tier ?? 0,
                'reward_amount' => $milestone->voucher_value,
                'status' => 'awarded',
                'awarded_at' => now(),
            ]);

            // 2. Generate and Issue Voucher
            if ($milestone->voucher_value > 0) {
                $voucher = Voucher::create([
                    'code' => 'CLUB-' . strtoupper(Str::random(8)),
                    'value' => $milestone->voucher_value,
                    'club_reward_id' => $reward->id,
                    'status' => 'assigned',
                    'expires_at' => now()->addMonths(6),
                ]);

                // 3. Create Assignment record
                VoucherAssignment::create([
                    'voucher_id' => $voucher->id,
                    'user_id' => $userId,
                    'assigned_at' => now(),
                ]);

                // 4. Update User's Voucher Balance in Wallet
                $wallet = Wallet::firstOrCreate(['user_id' => $userId]);
                $wallet->increment('voucher_balance', $milestone->voucher_value);

                // 5. Log Transaction
                $wallet->refresh(); // Get updated balance
                $wallet->transactions()->create([
                    'user_id' => $userId,
                    'type' => 'voucher_awarded',
                    'wallet' => 'voucher',
                    'amount' => $milestone->voucher_value,
                    'direction' => 'credit',
                    'balance_after' => $wallet->voucher_balance,
                    'description' => "Voucher Reward for reaching {$milestone->name}",
                    'reference_id' => $voucher->id,
                    'reference_type' => Voucher::class,
                ]);
            }

            return $reward;
        });
    }
}
