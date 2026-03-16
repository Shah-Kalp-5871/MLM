<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ClubMilestone;
use App\Models\Voucher;
use App\Models\Investment;
use Illuminate\Http\Request;

class ClubRewardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $vouchers = $user->vouchers()->orderBy('created_at', 'desc')->paginate(10);
        
        // Calculate Direct Business (active investments of level 1)
        $directReferralIds = $user->referrals()->pluck('id');
        $directBusiness = Investment::whereIn('user_id', $directReferralIds)->where('status', 'active')->sum('amount');
        
        // Calculate Team Business (active investments of all descendants)
        $teamIds = \App\Models\MLMTree::where('ancestor_id', $user->id)->where('distance', '>', 0)->pluck('descendant_id');
        $teamBusiness = Investment::whereIn('user_id', $teamIds)->where('status', 'active')->sum('amount');
        
        $milestones = ClubMilestone::orderBy('direct_business_target', 'asc')->get();
        
        // Find the next milestone the user hasn't fully achieved yet
        $nextMilestone = ClubMilestone::where(function($q) use ($directBusiness, $teamBusiness) {
                $q->where('direct_business_target', '>', $directBusiness)
                  ->orWhere('team_business_target', '>', $teamBusiness);
            })
            ->orderBy('direct_business_target', 'asc')
            ->first();

        // If all milestones achieved, use the last one for reference
        if (!$nextMilestone) {
            $nextMilestone = ClubMilestone::orderBy('direct_business_target', 'desc')->first();
        }
        
        return view('user.club-rewards.index', compact('milestones', 'vouchers', 'directBusiness', 'teamBusiness', 'nextMilestone'));
    }
}
