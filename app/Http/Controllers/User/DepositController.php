<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Deposit;
use App\Services\InvestmentService;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function __construct(protected InvestmentService $investmentService) {}

    public function index()
    {
        $deposits = auth()->user()->deposits()->orderBy('created_at', 'desc')->paginate(10);
        return view('user.deposits.index', compact('deposits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'transaction_hash' => 'nullable|string',
            'payment_proof' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['package_id', 'amount', 'payment_method', 'transaction_hash']);

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('deposits', 'public');
            $data['payment_proof'] = $path;
        }

        $this->investmentService->createDeposit($data);

        return redirect()->route('deposits.index')->with('success', 'Deposit request submitted successfully. Waiting for admin approval.');
    }
}
