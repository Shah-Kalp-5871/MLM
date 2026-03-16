<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use App\Services\InvestmentService;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function __construct(protected InvestmentService $investmentService) {}

    public function index()
    {
        $deposits = Deposit::with('user')->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.deposits.index', compact('deposits'));
    }

    public function approve($id)
    {
        try {
            $this->investmentService->approveDepositAndInvest($id);
            return back()->with('success', 'Deposit approved and investment activated.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function reject($id, Request $request)
    {
        $deposit = Deposit::findOrFail($id);
        $deposit->update([
            'status' => 'rejected',
            'admin_note' => $request->input('note'),
        ]);

        return back()->with('success', 'Deposit rejected.');
    }
}
