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

            $withdrawal->update(['status' => 'approved']);
            
            return back()->with('success', 'Withdrawal approved.');
        });
    }

    public function reject($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $withdrawal = Withdrawal::findOrFail($id);
            if ($withdrawal->status !== 'pending') {
                throw new \Exception("Withdrawal is already processed.");
            }

            // Refund user wallet
            $wallet = Wallet::where('user_id', $withdrawal->user_id)->first();
            $wallet->increment('balance', $withdrawal->amount);

            $withdrawal->update([
                'status' => 'rejected',
                'admin_note' => $request->input('note'),
            ]);

            return back()->with('success', 'Withdrawal rejected and funds refunded.');
        });
    }
}
