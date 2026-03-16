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
        $totalUsers = User::count();
        $pendingDeposits = Deposit::where('status', 'pending')->sum('amount');
        $activeInvestments = Investment::where('status', 'active')->sum('amount');
        $withdrawalsPending = Withdrawal::where('status', 'pending')->sum('amount');
        $totalBusiness = Deposit::where('status', 'approved')->sum('amount');

        $stats = [
            'total_users' => $totalUsers,
            'pending_deposits' => $pendingDeposits,
            'active_investments' => $activeInvestments,
            'withdrawals_pending' => $withdrawalsPending,
            'total_business' => $totalBusiness,
        ];

        $recent_users = User::orderBy('created_at', 'desc')->limit(5)->get();
        $recent_deposits = Deposit::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recent_users', 'recent_deposits'));
    }
}
