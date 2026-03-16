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
        // Get downline tree using closure table
        $team = MLMTree::where('ancestor_id', $user->id)
            ->where('distance', '>', 0)
            ->with('descendant.wallet', 'descendant.investments')
            ->orderBy('distance', 'asc')
            ->paginate(20);

        return view('user.network.index', compact('team'));
    }
}
