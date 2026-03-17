<?php

namespace App\Services;

use App\Models\Voucher;
use App\Models\Investment;
use App\Models\Wallet;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Exception;

class VoucherService
{
    /**
     * Redeem a voucher and create an instant investment.
     *
     * @param string $code
     * @param int $userId
     * @return Investment
     * @throws Exception
     */
    public function redeem(string $code, int $userId)
    {
        return DB::transaction(function () use ($code, $userId) {
            $voucher = Voucher::where('code', $code)->lockForUpdate()->first();

            if (!$voucher) {
                throw new Exception("Invalid voucher code.");
            }

            if ($voucher->status === 'used') {
                throw new Exception("This voucher has already been used.");
            }

            // 1. Mark voucher as used
            $voucher->update([
                'status' => 'used',
                'used_by' => $userId,
                'used_at' => now(),
            ]);

            // 2. Create Instant Investment
            $weeklyROI = Setting::get('weekly_roi_percentage', 10);
            
            $investment = Investment::create([
                'user_id' => $userId,
                'amount' => $voucher->amount,
                'daily_roi_percentage' => $weeklyROI / 7,
                'weekly_roi_percentage' => $weeklyROI,
                'status' => 'active',
                'source' => 'voucher',
                'next_payout_at' => now()->addDays(7),
                'matures_at' => now()->addDays(365),
            ]);

            // 3. Update Voucher Balance Tracking
            // Decrement the balance of the ORIGINAL OWNER (the one who earned it)
            $ownerWallet = Wallet::firstOrCreate(['user_id' => $voucher->owner_id]);
            $ownerWallet->decrement('voucher_balance', $voucher->amount);

            // 4. Log Transaction for the redeemer (Debit the "voucher" they are using)
            $redeemerWallet = Wallet::firstOrCreate(['user_id' => $userId]);
            $redeemerWallet->transactions()->create([
                'user_id' => $userId,
                'amount' => $voucher->amount,
                'type' => 'voucher_redeem',
                'wallet' => 'voucher',
                'direction' => 'debit',
                'balance_after' => $redeemerWallet->voucher_balance,
                'description' => "Redeemed voucher {$code} (Earned by: " . ($voucher->owner?->name ?? 'System') . ")",
            ]);

            // 5. If owner is different, log a transfer/use record for the owner
            if ($voucher->owner_id !== $userId) {
                $redeemer = User::find($userId);
                $ownerWallet->transactions()->create([
                    'user_id' => $voucher->owner_id,
                    'amount' => $voucher->amount,
                    'type' => 'voucher_transferred_use',
                    'wallet' => 'voucher',
                    'direction' => 'debit',
                    'balance_after' => $ownerWallet->voucher_balance,
                    'description' => "Voucher {$code} was redeemed by " . ($redeemer?->name ?? 'User #'.$userId),
                ]);
            }

            return $investment;
        });
    }
}
