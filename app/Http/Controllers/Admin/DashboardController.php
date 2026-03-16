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

        // Next ROI Payout (Next Monday)
        $nextPayoutDate = \Carbon\Carbon::now()->next(\Carbon\Carbon::MONDAY)->format('d M');
        $daysToPayout = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::now()->next(\Carbon\Carbon::MONDAY));
        
        $stats = [
            'total_users' => $totalUsers,
            'pending_deposits' => $pendingDeposits,
            'active_investments' => $activeInvestments,
            'withdrawals_pending' => $withdrawalsPending,
            'total_business' => $totalBusiness,
            'next_payout' => $nextPayoutDate,
            'days_to_payout' => "IN $daysToPayout DAYS",
            'eligible_amount' => $activeInvestments * 0.03, // Based on standard 3% weekly
            'active_user_rate' => $totalUsers > 0 ? round((Investment::where('status', 'active')->distinct('user_id')->count() / $totalUsers) * 100, 1) : 0,
        ];

        $recent_users = User::orderBy('created_at', 'desc')->limit(5)->get();
        $recent_deposits = Deposit::with('user')->orderBy('created_at', 'desc')->limit(5)->get();

        return view('admin.dashboard.index', compact('stats', 'recent_users', 'recent_deposits'));
    }
}
