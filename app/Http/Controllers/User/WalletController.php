<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $wallet = $user->wallet;
        $transactions = $user->transactions()->orderBy('created_at', 'desc')->paginate(15);
        
        return view('user.wallet.index', compact('wallet', 'transactions'));
    }
}
