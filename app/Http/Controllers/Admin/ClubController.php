<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        // This is a simplified version, in a real MLM it might involve complex qualification logic
        // For now we list users and their business volumes as a proxy for club qualification
        $users = User::with(['wallet', 'referrals', 'clubQualification.milestone'])->paginate(20);
        
        foreach ($users as $user) {
            // Direct Business: Sum of investments from direct referrals
            $user->direct_business = \App\Models\Investment::whereIn('user_id', $user->referrals->pluck('id'))
                ->where('status', 'active')
                ->sum('amount');
                
            // Total Business: Simplified for now
            $user->total_business = \App\Models\Investment::where('status', 'active')->sum('amount'); // Placeholder
        }
        
        return view('admin.club.index', compact('users'));
    }
}
