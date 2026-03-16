<?php

namespace App\Services;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Investment;
use App\Models\Package;
use App\Models\Wallet;
use App\Models\MLMTree;
use App\Models\ClubQualification;
use App\Models\ClubMilestone;
use Illuminate\Support\Facades\DB;

class InvestmentService
{
    public function __construct(protected ClubService $clubService) {}

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

            // 2. Create Investment
            // For now, we assume the deposit amount is fully invested into a package
            // In a real flow, the user might deposit to wallet first, then choose a package.
            // But for this "banger" flow, we link them.
            
            $package = Package::where('price', '<=', $deposit->amount)
                ->orderBy('price', 'desc')
                ->first();

            if (!$package) {
                // If no package matches, we just add to wallet balance
                $this->addToWallet($deposit->user_id, $deposit->amount, 'deposit');
                return $deposit;
            }

            $investment = Investment::create([
                'user_id' => $deposit->user_id,
                'package_id' => $package->id,
                'amount' => $deposit->amount,
                'daily_roi_percentage' => $package->roi_percentage,
                'status' => 'active',
                'next_payout_at' => now()->addDays(1), // Assume daily ROI for logic
                'matures_at' => now()->addDays($package->duration_days ?? 365),
            ]);

            // 3. Distribute Business Volume (BV) up the tree
            $this->distributeBusinessVolume($deposit->user_id, $deposit->amount);

            return $investment;
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

    /**
     * Distribute BV to all ancestors in the MLM Tree.
     */
    protected function distributeBusinessVolume(int $userId, float $amount)
    {
        // 1. Update Direct Upline's Direct BV
        $user = User::findOrFail($userId);
        if ($user->upline_id) {
            $uplineQual = ClubQualification::firstOrCreate(['user_id' => $user->upline_id]);
            $uplineQual->increment('direct_business', $amount);
            $this->checkMilestoneQualified($user->upline_id);
        }

        // 2. Update Team BV for all ancestors using Closure Table
        $ancestors = MLMTree::where('descendant_id', $userId)
            ->where('distance', '>', 0)
            ->get();

        foreach ($ancestors as $link) {
            $qual = ClubQualification::firstOrCreate(['user_id' => $link->ancestor_id]);
            $qual->increment('team_business', $amount);
            $this->checkMilestoneQualified($link->ancestor_id);
        }
    }

    /**
     * Check if a user now qualifies for a higher club milestone.
     */
    public function checkMilestoneQualified(int $userId)
    {
        $qual = ClubQualification::where('user_id', $userId)->first();
        if (!$qual) return;

        $nextMilestone = ClubMilestone::where('tier', '>', $qual->current_tier)
            ->where('direct_business_target', '<=', $qual->direct_business)
            ->where('team_business_target', '<=', $qual->team_business)
            ->orderBy('tier', 'desc')
            ->first();

        if ($nextMilestone) {
            $qual->update([
                'current_tier' => $nextMilestone->tier,
                'last_qualified_at' => now(),
            ]);
            
            $this->issueClubReward($userId, $nextMilestone);
        }
    }

    protected function issueClubReward(int $userId, ClubMilestone $milestone)
    {
        $this->clubService->awardMilestoneReward($userId, $milestone);
    }
}
