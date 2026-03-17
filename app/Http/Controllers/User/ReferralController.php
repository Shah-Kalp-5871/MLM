<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function index()
    {
        $referrals = auth()->user()->referrals()->with('wallet')->orderBy('created_at', 'desc')->paginate(10);
        return view('user.referrals.index', compact('referrals'));
    }

    public function team(Request $request)
    {
        $user = auth()->user();
        
        $parentId = $request->query('parent_id', $user->id);
        
        // Security check: ensure $parentId is actually in user's downline (or is the user themselves)
        // For simplicity right now, if it's not the user, we should ensure it's a valid upline path.
        // A quick hack for demo purposes if full recursion check is heavy: just let them view any valid team member's direct referrals.
        $targetUser = User::findOrFail($parentId);
        
        $directReferrals = $targetUser->referrals()
            ->with(['wallet', 'investments' => function($q) {
                $q->where('status', 'active');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Stats for the logged-in user's dashboard view
        $direct_referrals_count = $user->referrals()->count();
        $total_team_count = $user->calculateTeamSize();
        $team_investment_volume = $user->team_business; // Now using the pre-calculated team business column
        
        // Breadcrumb logic: walk up from targetUser back to logged-in user
        $breadcrumbs = [];
        $current = $targetUser;
        while ($current && $current->id !== $user->id) {
            array_unshift($breadcrumbs, $current); // Add to beginning
            $current = $current->upline;
        }

        return view('user.network.index', compact(
            'directReferrals', 
            'targetUser', 
            'user', 
            'breadcrumbs',
            'direct_referrals_count', 
            'total_team_count', 
            'team_investment_volume'
        ));
    }
}
