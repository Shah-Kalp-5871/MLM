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
        $withdrawals = $user->withdrawals()->orderBy('created_at', 'desc')->paginate(15);
        return view('user.withdrawals.index', compact('wallet', 'withdrawals'));
    }

    public function create()
    {
        $wallet = auth()->user()->wallet;
        $withdrawals = auth()->user()->withdrawals()->orderBy('created_at', 'desc')->limit(10)->get();
        return view('user.withdrawals.create', compact('wallet', 'withdrawals'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $minWithdrawal = \App\Models\Setting::get('min_withdrawal', 200);

        $request->validate([
            'amount' => "required|numeric|min:{$minWithdrawal}", 
            'payment_method' => 'required|string',
            'wallet_address' => 'required|string',
        ]);

        if ($user->withdrawals()->where('status', 'pending')->exists()) {
            return back()->with('error', 'You already have a pending withdrawal request. Please wait for admin approval.');
        }

        try {
            DB::transaction(function () use ($user, $request) {
                // 1. Lock Wallet row for check (don't deduct yet)
                $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->firstOrFail();

                if ($wallet->balance < $request->amount) {
                    throw new \Exception('Insufficient balance in wallet.');
                }

                // 2. Create Withdrawal Record (Pending)
                Withdrawal::create([
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'method' => $request->payment_method,
                    'status' => 'pending',
                    'admin_note' => 'Withdrawal request to ' . $request->wallet_address,
                ]);
            });

            return redirect()->route('withdraw.create')->with('success', 'Withdrawal request submitted successfully.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    public function receipt($id)
    {
        $withdrawal = auth()->user()->withdrawals()->findOrFail($id);
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('user.withdrawals.receipt', compact('withdrawal', 'settings'));
    }
}
