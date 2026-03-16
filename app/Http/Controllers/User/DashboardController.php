<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Investment;
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

        $totalInvestment = $user->investments()->where('status', 'active')->sum('amount');
        $weeklyRoi = $wallet->total_roi_earned; // can be refined to last 7 days if needed
        $teamSize = $user->mlmDescendants()->count() ?? 0; // assumes a descendants relation or returns 0
        $directReferrals = $user->referrals()->count();

        $stats = [
            'wallet_balance' => $wallet->balance,
            'total_investment' => $totalInvestment,
            'weekly_roi' => $weeklyRoi,
            'team_size' => $teamSize,
            'direct_referrals' => $directReferrals,
        ];

        $recent_transactions = $user->transactions()->orderBy('created_at', 'desc')->limit(5)->get();

        return view('user.dashboard', compact('stats', 'recent_transactions', 'user'));
    }
}
