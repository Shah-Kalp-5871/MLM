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
    public function awardMilestoneReward(int $userId, ClubMilestone $milestone)
    {
        return DB::transaction(function () use ($userId, $milestone) {
            // 1. Log the Reward (Audit trail)
            $reward = ClubReward::create([
                'user_id' => $userId,
                'club_milestone_id' => $milestone->id,
                'tier' => $milestone->tier ?? 0,
                'reward_amount' => $milestone->voucher_value,
                'status' => 'awarded',
                'awarded_at' => now(),
            ]);

            // 2. Generate and Issue Voucher (The transferable asset)
            if ($milestone->voucher_value > 0) {
                $voucher = Voucher::create([
                    'code' => 'CLUB-' . strtoupper(Str::random(10)), // Longer code for security
                    'amount' => $milestone->voucher_value,
                    'owner_id' => $userId,
                    'type' => "club_{$milestone->tier}",
                    'status' => 'unused',
                ]);

                // 3. Update User's Voucher Balance in Wallet (Informational only now)
                $wallet = Wallet::firstOrCreate(['user_id' => $userId]);
                $wallet->increment('voucher_balance', $milestone->voucher_value);

                // 4. Log Transaction
                $wallet->refresh(); 
                $wallet->transactions()->create([
                    'user_id' => $userId,
                    'type' => 'voucher_earned',
                    'wallet' => 'voucher',
                    'amount' => $milestone->voucher_value,
                    'direction' => 'credit',
                    'balance_after' => $wallet->voucher_balance,
                    'description' => "Voucher Earned: {$milestone->name}",
                    'reference_id' => $voucher->id,
                    'reference_type' => Voucher::class,
                ]);
            }

            return $reward;
        });
    }
}
