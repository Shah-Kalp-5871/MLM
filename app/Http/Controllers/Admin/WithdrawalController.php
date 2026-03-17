<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $withdrawals = Withdrawal::with(['user' => fn($q) => $q->withTrashed()])->orderBy('created_at', 'desc')->paginate(20);
        $pendingCount = Withdrawal::where('status', 'pending')->count();
        return view('admin.withdrawals.index', compact('withdrawals', 'pendingCount'));
    }

    public function approve($id)
    {
        return DB::transaction(function () use ($id) {
            $withdrawal = Withdrawal::findOrFail($id);
            if ($withdrawal->status !== 'pending') {
                throw new \Exception("Withdrawal is already processed.");
            }

            $wallet = Wallet::where('user_id', $withdrawal->user_id)->lockForUpdate()->firstOrFail();

            if ($wallet->balance < $withdrawal->amount) {
                throw new \Exception("User does not have enough balance to process this withdrawal.");
            }

            // Deduct balance
            $wallet->decrement('balance', $withdrawal->amount);
            $wallet->increment('total_withdrawn', $withdrawal->amount);

            // Log Transaction now that it's approved
            $withdrawal->user->transactions()->create([
                'amount' => $withdrawal->amount,
                'type' => 'withdrawal',
                'wallet' => 'cash',
                'direction' => 'debit',
                'balance_after' => $wallet->balance,
                'description' => "Approved withdrawal of " . (\App\Models\Setting::where('key', 'platform_currency_symbol')->value('value') ?? '$') . number_format($withdrawal->amount, 2),
            ]);

            $withdrawal->update(['status' => 'approved']);
            
            return back()->with('success', 'Withdrawal approved and funds deducted.');
        });
    }

    public function reject($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $withdrawal = Withdrawal::findOrFail($id);
            if ($withdrawal->status !== 'pending') {
                throw new \Exception("Withdrawal is already processed.");
            }

            // No refund needed, because balance was never deducted in store()
            $withdrawal->update([
                'status' => 'rejected',
                'admin_note' => $request->input('note'),
            ]);

            return back()->with('success', 'Withdrawal rejected.');
        });
    }
}
