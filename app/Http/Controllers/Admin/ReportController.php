<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Investment;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'monthly_users' => User::where('created_at', '>=', Carbon::now()->startOfMonth())->count(),
            'total_deposits' => Deposit::where('status', 'approved')->sum('amount'),
            'total_investments' => Investment::where('status', 'active')->sum('amount'),
            'total_withdrawals' => Withdrawal::where('status', 'approved')->sum('amount'),
            'daily_avg_revenue' => Deposit::where('status', 'approved')
                ->where('created_at', '>=', Carbon::now()->subDays(30))
                ->sum('amount') / 30,
        ];

        // Payout Composition
        $roi_total = \App\Models\ROIIncome::sum('amount') ?: 1;
        $level_total = \App\Models\LevelCommission::sum('amount') ?: 0;
        $voucher_total = \App\Models\Voucher::sum('value') ?: 0;
        $grand_total = $roi_total + $level_total + $voucher_total;

        $stats['payouts'] = [
            'roi' => round(($roi_total / $grand_total) * 100),
            'level' => round(($level_total / $grand_total) * 100),
            'vouchers' => round(($voucher_total / $grand_total) * 100),
        ];

        // Top leaders by team size (standard MLM metric)
        $leaders = User::withCount('referrals')
            ->orderBy('referrals_count', 'desc')
            ->take(10)
            ->get();
            
        foreach($leaders as $leader) {
             $leader->direct_bv = Investment::whereIn('user_id', $leader->referrals->pluck('id'))->sum('amount');
        }

        return view('admin.reports.index', compact('stats', 'leaders'));
    }
}
