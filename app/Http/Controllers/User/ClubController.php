<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $clubLevels = \App\Models\ClubLevel::orderBy('level', 'asc')->get();

        $earnedVouchers = $user->vouchers()->where('type', 'like', 'club_%')->get();
        
        $stats = [
            'direct_business' => $user->direct_business,
            'team_business'   => $user->team_business,
        ];

        return view('user.club.index', compact('user', 'clubLevels', 'earnedVouchers', 'stats'));
    }
}
