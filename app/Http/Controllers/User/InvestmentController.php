<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = auth()->user()->investments()->orderBy('created_at', 'desc')->paginate(10);
        $pendingDeposits = auth()->user()->deposits()->where('status', 'pending')->get();
        $rejectedDeposits = auth()->user()->deposits()->where('status', 'rejected')->latest()->take(5)->get();
        $roiHistory = auth()->user()->roiIncomes()->orderBy('distributed_at', 'desc')->take(5)->get();
        
        return view('user.investments.index', compact('investments', 'pendingDeposits', 'rejectedDeposits', 'roiHistory'));
    }

    public function create()
    {
        $pendingDeposit = auth()->user()->deposits()
            ->where('status', 'pending')
            ->first();
            
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        
        return view('user.investments.create', compact('pendingDeposit', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'payment_proof' => 'required|image|max:2048',
            'voucher_code' => 'nullable|string',
        ]);

        // Check for pending again on server side
        $hasPending = auth()->user()->deposits()
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return back()->with('error', 'You already have a pending investment request. Please wait for admin approval.');
        }

        // Voucher Validation
        $discountAmount = 0;
        $voucherCode = null;

        if ($request->filled('voucher_code')) {
            $voucher = auth()->user()->vouchers()
                ->where('code', $request->voucher_code)
                ->where('status', 'unused')
                ->first();

            if (!$voucher) {
                return back()->withInput()->with('error', 'Invalid or already used voucher code.');
            }

            // Optional: Limit discount to deposit amount (so they don't get 'negative' charge)
            $discountAmount = min($voucher->amount, $request->amount);
            $voucherCode = $voucher->code;

            // Mark voucher as used immediately upon submission (or later upon admin approval depending on policy, user specified "during purchase")
            $voucher->update([
                'status' => 'used',
                'used_at' => now()
            ]);
        }

        $method = \App\Models\PaymentMethod::find($request->payment_method_id);
        
        $proofPath = $request->file('payment_proof')->store('proofs', 'public');

        auth()->user()->deposits()->create([
            'amount' => $request->amount,
            'payment_method' => strtolower($method->name),
            'payment_proof' => $proofPath,
            'voucher_code' => $voucherCode,
            'discount_amount' => $discountAmount,
            'status' => 'pending',
        ]);

        return redirect()->route('investments.index')->with('success', 'Investment request submitted successfully.');
    }
}
