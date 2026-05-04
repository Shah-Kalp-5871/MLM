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
        
        $minWithdrawal = \App\Models\Setting::get(
            'min_withdrawal_amount',
            \App\Models\Setting::get('min_withdrawal', 200)
        );

        $request->validate([
            'amount' => "required|numeric|min:{$minWithdrawal}", 
            'payment_method' => 'required|string|in:usdt_trc20,usdt_bep20,usdt_erc20',
            'wallet_address' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->payment_method === 'usdt_trc20') {
                        if (!preg_match('/^T[a-zA-Z0-9]{33}$/', $value)) {
                            $fail('The wallet address is not a valid USDT TRC20 address (must start with T and be 34 characters).');
                        }
                    } elseif (in_array($request->payment_method, ['usdt_bep20', 'usdt_erc20'])) {
                        if (!preg_match('/^0x[a-fA-F0-9]{40}$/', $value)) {
                            $fail('The wallet address is not a valid ' . strtoupper(str_replace('usdt_', '', $request->payment_method)) . ' address (must start with 0x and be 42 characters).');
                        }
                    }
                },
            ],
        ]);

        if ($user->withdrawals()->where('status', 'pending')->exists()) {
            return back()->with('error', 'You already have a pending withdrawal request. Please wait for admin approval.');
        }

        try {
            DB::transaction(function () use ($user, $request) {
                // 1. Lock wallet earnings only; investment principal is never withdrawable.
                $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->firstOrFail();

                if ($wallet->balance < $request->amount) {
                    throw new \Exception('Insufficient balance in wallet.');
                }

                // 2. Create Withdrawal Record (Pending)
                Withdrawal::create([
                    'user_id' => $user->id,
                    'amount' => $request->amount,
                    'payment_method' => $request->payment_method,
                    'wallet_address' => $request->wallet_address,
                    'status' => 'pending',
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
