<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Withdrawal;
use App\Models\Investment;
use App\Models\Wallet;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('status', 'active')->count(),
            'blocked_users' => User::where('status', 'blocked')->count(),
            'total_deposits' => Deposit::where('status', 'approved')->sum('amount'),
            'total_withdrawals' => Withdrawal::where('status', 'approved')->sum('amount'),
            'total_roi_paid' => Investment::sum('total_roi_earned'),
            'pending_deposits' => Deposit::where('status', 'pending')->count(),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'wallet_balances' => Wallet::sum('balance'),
        ];

        $recent_users = User::orderBy('created_at', 'desc')->limit(5)->get();
        $recent_deposits = Deposit::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recent_users', 'recent_deposits'));
    }
}
