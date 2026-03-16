<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MLMTree;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $referrals = auth()->user()->referrals()->with('wallet')->orderBy('created_at', 'desc')->paginate(10);
        return view('user.referrals.index', compact('referrals'));
    }

    public function team()
    {
        $user = auth()->user();
        
        // Stats
        $direct_referrals_count = $user->referrals()->count();
        $total_team_count = MLMTree::where('ancestor_id', $user->id)->where('distance', '>', 0)->count();
        
        // Total team investment volume
        $team_ids = MLMTree::where('ancestor_id', $user->id)->where('distance', '>', 0)->pluck('descendant_id');
        $team_investment_volume = \App\Models\Investment::whereIn('user_id', $team_ids)->where('status', 'active')->sum('amount');

        // Get downline tree using closure table
        $team = MLMTree::where('ancestor_id', $user->id)
            ->where('distance', '>', 0)
            ->with(['descendant.wallet', 'descendant.investments' => function($q) {
                $q->where('status', 'active');
            }])
            ->orderBy('distance', 'asc')
            ->paginate(20);

        return view('user.network.index', compact('team', 'direct_referrals_count', 'total_team_count', 'team_investment_volume'));
    }
}
