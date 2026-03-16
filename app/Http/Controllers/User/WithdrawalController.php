<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $wallet = $user->wallet;
        $withdrawals = $user->withdrawls()->orderBy('created_at', 'desc')->paginate(15);
        return view('user.withdrawals.index', compact('wallet', 'withdrawals'));
    }

    public function create()
    {
        $wallet = auth()->user()->wallet;
        $withdrawals = auth()->user()->withdrawls()->orderBy('created_at', 'desc')->limit(10)->get();
        return view('user.withdrawals.create', compact('wallet', 'withdrawals'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'amount' => 'required|numeric|min:10', 
            'payment_method' => 'required|string',
            'wallet_address' => 'required|string',
        ]);

        try {
            DB::transaction(function () use ($user, $request) {
                // 1. Lock Wallet row for update
                $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->firstOrFail();

                if ($wallet->balance < $request->amount) {
                    throw new \Exception('Insufficient balance in wallet.');
                }

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
                    'wallet' => 'cash',
                    'direction' => 'debit',
                    'balance_after' => $wallet->balance,
                    'description' => "Withdrawal request of " . (\App\Models\Setting::where('key', 'platform_currency_symbol')->value('value') ?? '$') . number_format($request->amount, 2),
                ]);
            });

            return redirect()->route('withdraw.create')->with('success', 'Withdrawal request submitted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
