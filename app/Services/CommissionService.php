<?php

namespace App\Services;

use App\Models\User;
use App\Models\LevelSetting;
use App\Models\LevelCommission;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\MLMTree;
use Illuminate\Support\Facades\DB;

class CommissionService
{
    /**
     * Distribute Level Commissions up to 15 levels based on the ROI earned by a downline.
     */
    public function distributeLevelCommissions(int $fromUserId, float $roiAmount, int $investmentId, int $roiId)
    {
        // 1. Load Level Settings once
        $settings = LevelSetting::orderBy('level', 'asc')->get()->keyBy('level');
        $maxLevels = $settings->max('level') ?? 15;

        // 2. Find ancestors using the Closure Table (MLMTree)
        // We order by distance to process Level 1, then Level 2, etc.
        $ancestors = MLMTree::where('descendant_id', $fromUserId)
            ->where('distance', '>', 0)
            ->where('distance', '<=', $maxLevels)
            ->orderBy('distance', 'asc')
            ->get();

        foreach ($ancestors as $link) {
            $level = $link->distance;
            $ancestorId = $link->ancestor_id;

            if (!isset($settings[$level])) continue;

            $percentage = $settings[$level]->percentage;
            if ($percentage <= 0) continue;

            $commissionAmount = ($roiAmount * $percentage) / 100;

            // 3. Create Level Commission Record
            $commission = LevelCommission::create([
                'receiver_id' => $ancestorId,
                'from_user_id' => $fromUserId,
                'roi_income_id' => $roiId,
                'level' => $level,
                'roi_amount' => $roiAmount,
                'commission_percentage' => $percentage,
                'commission_amount' => $commissionAmount,
                'created_at' => now(),
            ]);

            // 4. Credit Ancestor's Wallet
            $wallet = Wallet::firstOrCreate(['user_id' => $ancestorId]);
            $wallet->increment('balance', $commissionAmount);
            $wallet->increment('total_level_earned', $commissionAmount);

            // 5. Log Transaction
            $wallet->user->transactions()->create([
                'amount' => $commissionAmount,
                'type' => 'level_income',
                'wallet' => 'cash',
                'direction' => 'credit',
                'balance_after' => $wallet->balance,
                'description' => "Level {$level} commission from User #{$fromUserId}",
                'reference_id' => $commission->id,
                'reference_type' => LevelCommission::class,
            ]);
        }
    }
}
