<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function __construct(protected \App\Services\VoucherService $voucherService) {}

    public function index()
    {
        $vouchers = Voucher::where('owner_id', auth()->id())->orderBy('created_at', 'desc')->paginate(10);
        $redeemedVouchers = Voucher::where('used_by', auth()->id())->orderBy('used_at', 'desc')->paginate(10);
        return view('user.vouchers.index', compact('vouchers', 'redeemedVouchers'));
    }

    public function showRedeemForm()
    {
        return view('user.vouchers.redeem');
    }

    public function redeem(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        try {
            $this->voucherService->redeem($request->code, auth()->id());
            return redirect()->route('investments.index')->with('success', 'Voucher redeemed successfully! Your investment is now active.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
