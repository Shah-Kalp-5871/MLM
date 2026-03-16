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
        // For static demo purpose if Auth is not fully set up yet
        $user = Auth::user() ?? User::first(); 
        
        if (!$user) {
            return redirect('/auth/login');
        }

        $wallet = $user->wallet ?: $user->wallet()->create(['balance' => 0]);
        
        $stats = [
            'balance' => $wallet->balance,
            'roi_earned' => $wallet->total_roi_earned,
            'commission_earned' => $wallet->total_level_earned,
            'total_investment' => $user->investments()->where('status', 'active')->sum('amount'),
            'referral_count' => $user->referrals()->count(),
            'active_investments' => $user->investments()->where('status', 'active')->count(),
        ];

        $recent_transactions = $user->transactions()->orderBy('created_at', 'desc')->limit(5)->get();

        return view('user.dashboard', compact('stats', 'recent_transactions', 'user'));
    }
}
