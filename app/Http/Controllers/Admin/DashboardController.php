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
        $totalBusiness = Deposit::where('status', 'approved')->sum('amount');
        
        $pendingDepositsCount = Deposit::where('status', 'pending')->count();
        $pendingDepositsAmount = Deposit::where('status', 'pending')->sum('amount');
        $pendingWithdrawalsCount = Withdrawal::where('status', 'pending')->count();
        $pendingWithdrawalsAmount = Withdrawal::where('status', 'pending')->sum('amount');
        
        $totalInvestments = Investment::sum('amount');
        $totalROIPaid = \App\Models\ROIIncome::sum('roi_amount');
        $totalCommissionsPaid = \App\Models\LevelCommission::sum('commission_amount');
        
        $stats = [
            'total_users' => $totalUsers,
            'total_deposits' => $totalBusiness,
            'pending_deposits_count' => $pendingDepositsCount,
            'pending_deposits_amount' => $pendingDepositsAmount,
            'pending_withdrawals_count' => $pendingWithdrawalsCount,
            'pending_withdrawals_amount' => $pendingWithdrawalsAmount,
            'total_investments' => $totalInvestments,
            'total_roi_paid' => $totalROIPaid,
            'total_commissions_paid' => $totalCommissionsPaid,
        ];

        $recent_users = User::with(['upline' => fn($q) => $q->withTrashed()])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recent_activity = collect();
        
        $deposits = Deposit::with('user')->latest()->limit(5)->get()->map(fn($i) => ['type' => 'Deposit', 'user' => $i->user->name ?? 'Guest', 'amount' => $i->amount, 'time' => $i->created_at->diffForHumans()]);
        $withdrawals = Withdrawal::with('user')->latest()->limit(5)->get()->map(fn($i) => ['type' => 'Withdrawal', 'user' => $i->user->name ?? 'Guest', 'amount' => $i->amount, 'time' => $i->created_at->diffForHumans()]);
        $registrations = User::latest()->limit(5)->get()->map(fn($i) => ['type' => 'Registration', 'user' => $i->name, 'amount' => null, 'time' => $i->created_at->diffForHumans()]);
        $roi = \App\Models\ROIIncome::with('user')->latest('distributed_at')->limit(5)->get()->map(fn($i) => ['type' => 'ROI', 'user' => $i->user->name ?? 'Guest', 'amount' => $i->roi_amount, 'time' => $i->distributed_at->diffForHumans()]);

        $recent_activity = $deposits->concat($withdrawals)->concat($registrations)->concat($roi)->sortByDesc('time')->take(10);

        return view('admin.dashboard.index', compact('stats', 'recent_users', 'recent_activity'));
    }
}
