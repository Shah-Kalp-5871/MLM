<?php

namespace App\Services;

use App\Models\User;
use App\Models\ClubMilestone;
use App\Models\ClubQualification;
use App\Models\ClubReward;
use App\Models\Voucher;
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
                'milestone_id' => $milestone->id,
                'reward_type' => 'voucher',
                'reward_value' => $milestone->voucher_value,
                'status' => 'awarded',
            ]);

            // 2. Generate and Issue Voucher
            if ($milestone->voucher_value > 0) {
                $voucher = Voucher::create([
                    'code' => 'CLUB-' . strtoupper(Str::random(8)),
                    'value' => $milestone->voucher_value,
                    'type' => 'club_reward',
                    'assigned_to' => $userId,
                    'is_used' => false,
                    'status' => 'active',
                ]);

                // 3. Update User's Voucher Balance in Wallet
                $wallet = Wallet::firstOrCreate(['user_id' => $userId]);
                $wallet->increment('voucher_balance', $milestone->voucher_value);

                // 4. Log Transaction
                $wallet->transactions()->create([
                    'amount' => $milestone->voucher_value,
                    'type' => 'credit',
                    'category' => 'voucher_redeem', // Using category loosely here for voucher accrual
                    'description' => "Voucher Reward for reaching {$milestone->name}",
                    'reference_id' => $voucher->id,
                    'reference_type' => Voucher::class,
                    'status' => 'completed',
                ]);
            }

            return $reward;
        });
    }
}
