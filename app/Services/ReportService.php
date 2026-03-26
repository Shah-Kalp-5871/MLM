<?php

namespace App\Services;

use App\Models\User;
use App\Models\Investment;
use App\Models\Withdrawal;
use App\Models\ROIIncome;
use App\Models\LevelCommission;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Get consolidated report data for a given date range.
     *
     * @param Carbon|null $startDate
     * @param Carbon|null $endDate
     * @return array
     */
    public function getConsolidatedReport($startDate = null, $endDate = null)
    {
        $startDate = $startDate ?? Carbon::create(2020, 1, 1);
        $endDate = $endDate ?? Carbon::now();

        $data = [];

        // 1. User Stats
        $data['users'] = [
            'total' => User::count(),
            'new' => User::whereBetween('created_at', [$startDate, $endDate])->count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', '!=', 'active')->count(),
        ];

        // 2. Investment Stats
        $data['investments'] = [
            'total_amount' => Investment::whereBetween('created_at', [$startDate, $endDate])->sum('amount'),
            'total_count' => Investment::whereBetween('created_at', [$startDate, $endDate])->count(),
            'active_amount' => Investment::where('status', 'active')->sum('amount'),
        ];

        // 3. Earnings / Payouts (ROI + Level)
        $data['payouts'] = [
            'roi_given' => ROIIncome::whereBetween('distributed_at', [$startDate, $endDate])->sum('roi_amount'),
            'level_commissions' => LevelCommission::whereBetween('created_at', [$startDate, $endDate])->sum('commission_amount'),
        ];
        $data['payouts']['total'] = $data['payouts']['roi_given'] + $data['payouts']['level_commissions'];

        // 4. Withdrawal Granularity
        $data['withdrawals'] = [
            'total_requested' => Withdrawal::whereBetween('created_at', [$startDate, $endDate])->sum('amount'),
            'processed' => Withdrawal::where('status', 'paid')
                ->whereBetween('paid_at', [$startDate, $endDate])
                ->sum('amount'),
            'pending' => Withdrawal::where('status', 'pending')->sum('amount'),
            'rejected' => Withdrawal::where('status', 'rejected')->whereBetween('updated_at', [$startDate, $endDate])->sum('amount'),
        ];

        // 5. Voucher Metrics (Current Snapshot)
        $data['vouchers'] = [
            'total_count' => \App\Models\Voucher::count(),
            'total_value' => \App\Models\Voucher::sum('amount'),
            'used_count' => \App\Models\Voucher::where('status', 'used')->count(),
            'unused_value' => \App\Models\Voucher::where('status', 'unused')->sum('amount'),
        ];

        // 6. Business Volume (BV)
        $data['business'] = [
            'total_direct_bv' => User::sum('direct_business'),
            'total_team_bv' => User::sum('team_business'),
        ];

        // 7. Trends (Last 7 Days) for Charts
        $data['trends'] = $this->getTrends();

        // 8. Club Achievements (Empty for now)
        $data['clubs'] = [];

        // 9. Success Ratio / KPIs
        $data['kpis'] = [
            'payout_ratio' => $data['investments']['total_amount'] > 0 
                ? round(($data['payouts']['total'] / $data['investments']['total_amount']) * 100, 2) 
                : 0,
            'withdrawal_ratio' => $data['payouts']['total'] > 0 
                ? round(($data['withdrawals']['processed'] / $data['payouts']['total']) * 100, 2) 
                : 0,
            'user_activity_rate' => $data['users']['total'] > 0
                ? round(($data['users']['active'] / $data['users']['total']) * 100, 1)
                : 0,
        ];

        return $data;
    }

    /**
     * Get daily trends for the last 7 days.
     */
    protected function getTrends()
    {
        $days = [];
        $registrations = [];
        $investments = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $days[] = $date->format('d M');
            
            $registrations[] = User::whereDate('created_at', $date)->count();
            $investments[] = Investment::whereDate('created_at', $date)->sum('amount');
        }

        return [
            'labels' => $days,
            'registrations' => $registrations,
            'investments' => $investments,
        ];
    }
}
