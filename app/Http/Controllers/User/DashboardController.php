<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\MLMTree;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/auth/login');
        }

        $wallet = $user->wallet ?: $user->wallet()->create(['balance' => 0]);

        $activeInvestments = $user->investments()->where('status', 'active')->get();
        $totalInvestment = $activeInvestments->sum('amount');
        
        $totalWeeklyEarnings = 0;
        $nextRoiPayout = null;

        foreach ($activeInvestments as $inv) {
            $totalWeeklyEarnings += $inv->amount * ($inv->weekly_roi_percentage / 100);
            if (!$nextRoiPayout || $inv->next_payout_at < $nextRoiPayout) {
                $nextRoiPayout = $inv->next_payout_at;
            }
        }

        // Count all descendants in the MLM tree (distance > 0 excludes self)
        $teamSize = MLMTree::where('ancestor_id', $user->id)->where('distance', '>', 0)->count();

        $directReferrals = $user->referrals()->count();

        // Level Income Stats
        $totalLevelIncome = $user->transactions()->where('type', 'level_income')->sum('amount');
        $levelIncomeToday = $user->transactions()
            ->where('type', 'level_income')
            ->whereDate('created_at', now()->toDateString())
            ->sum('amount');

        $stats = [
            'wallet_balance'     => $wallet->balance,
            'total_investment'   => $totalInvestment,
            'weekly_earnings'    => $totalWeeklyEarnings,
            'next_payout_at'     => $nextRoiPayout,
            'team_size'          => $teamSize,
            'direct_referrals'   => $directReferrals,
            'direct_business'    => $user->direct_business,
            'team_business'      => $user->team_business,
            'roi_percentage'     => \App\Models\Setting::get('weekly_roi_percentage', 3),
            'total_level_income' => $totalLevelIncome,
            'level_income_today' => $levelIncomeToday,
        ];

        $recent_transactions = $user->transactions()->orderBy('created_at', 'desc')->limit(5)->get();

        return view('user.dashboard', compact('stats', 'recent_transactions', 'user'));
    }
}
