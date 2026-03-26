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

        // 4. Withdrawal Stats
        $data['withdrawals'] = [
            'requested' => Withdrawal::whereBetween('created_at', [$startDate, $endDate])->sum('amount'),
            'processed' => Withdrawal::where('status', 'paid')
                ->whereBetween('paid_at', [$startDate, $endDate])
                ->sum('amount'),
            'pending' => Withdrawal::where('status', 'pending')->sum('amount'),
        ];

        // 5. Business Volume (BV)
        // Assuming direct_business and team_business columns are updated periodically
        // For a report, we might want the growth in BV during the period
        // But since we don't have historical BV snapshots, we'll show current totals
        $data['business'] = [
            'total_direct_bv' => User::sum('direct_business'),
            'total_team_bv' => User::sum('team_business'),
        ];

        // 6. Club Achievements
        // Note: Club system mapping is pending implementation in the database schema.
        $data['clubs'] = [];
        /*
        $data['clubs'] = DB::table('users')
            ->join('club_rewards', 'users.id', '=', 'club_rewards.user_id')
            ->select('club_rewards.tier as level', DB::raw('count(*) as count'))
            ->groupBy('club_rewards.tier')
            ->get()
            ->pluck('count', 'level')
            ->toArray();
        */

        // 7. Success Ratio / KPIs
        $data['kpis'] = [
            'payout_ratio' => $data['investments']['total_amount'] > 0 
                ? round(($data['payouts']['total'] / $data['investments']['total_amount']) * 100, 2) 
                : 0,
            'withdrawal_ratio' => $data['payouts']['total'] > 0 
                ? round(($data['withdrawals']['processed'] / $data['payouts']['total']) * 100, 2) 
                : 0,
        ];

        return $data;
    }
}
