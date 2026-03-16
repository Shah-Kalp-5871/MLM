<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Voucher;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = auth()->user()->vouchers()->orderBy('created_at', 'desc')->paginate(10);
        return view('user.vouchers.index', compact('vouchers'));
    }
}
