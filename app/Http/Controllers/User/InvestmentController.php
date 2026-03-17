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
        
        return view('user.investments.index', compact('investments', 'pendingDeposits', 'rejectedDeposits'));
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
        ]);

        // Check for pending again on server side
        $hasPending = auth()->user()->deposits()
            ->where('status', 'pending')
            ->exists();

        if ($hasPending) {
            return back()->with('error', 'You already have a pending investment request. Please wait for admin approval.');
        }

        $method = \App\Models\PaymentMethod::find($request->payment_method_id);
        
        $proofPath = $request->file('payment_proof')->store('proofs', 'public');

        auth()->user()->deposits()->create([
            'amount' => $request->amount,
            'payment_method' => strtolower($method->name), // Consistently use the name or type
            'payment_proof' => $proofPath,
            'status' => 'pending',
        ]);

        return redirect()->route('investments.index')->with('success', 'Investment request submitted. Waiting for admin approval.');
    }
}
