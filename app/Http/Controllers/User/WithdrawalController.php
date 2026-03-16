<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function create()
    {
        $wallet = auth()->user()->wallet;
        $withdrawals = auth()->user()->withdrawls()->orderBy('created_at', 'desc')->limit(10)->get();
        return view('user.withdrawals.create', compact('wallet', 'withdrawals'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        $request->validate([
            'amount' => 'required|numeric|min:10', // Example min withdrawal
            'payment_method' => 'required|string',
            'wallet_address' => 'required|string',
        ]);

        if ($wallet->balance < $request->amount) {
            return back()->with('error', 'Insufficient balance in wallet.');
        }

        DB::transaction(function () use ($user, $wallet, $request) {
            // 1. Create Withdrawal Record
            Withdrawal::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'method' => $request->payment_method,
                'status' => 'pending',
                'admin_note' => 'Withdrawal request to ' . $request->wallet_address,
            ]);

            // 2. Deduct from Wallet
            $wallet->decrement('balance', $request->amount);
            $wallet->increment('total_withdrawn', $request->amount);

            // 3. Log Transaction
            $user->transactions()->create([
                'amount' => $request->amount,
                'type' => 'withdrawal',
                'direction' => 'debit',
                'balance_after' => $wallet->balance,
                'description' => "Withdrawal request of ₹" . number_format($request->amount, 2),
            ]);
        });

        return redirect()->route('withdraw.create')->with('success', 'Withdrawal request submitted successfully.');
    }
}
