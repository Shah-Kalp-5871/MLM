<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MLMTree;
use Illuminate\Support\Facades\Auth;

class ClubController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $clubLevels = [
            ['id' => 1, 'direct' => 5000,  'team' => 15000,  'reward' => 500,  'title' => 'Club 1'],
            ['id' => 2, 'direct' => 7000,  'team' => 20000,  'reward' => 1000, 'title' => 'Club 2'],
            ['id' => 3, 'direct' => 10000, 'team' => 40000,  'reward' => 2000, 'title' => 'Club 3'],
            ['id' => 4, 'direct' => 15000, 'team' => 100000, 'reward' => 2500, 'title' => 'Club 4'],
            ['id' => 5, 'direct' => 20000, 'team' => 200000, 'reward' => 3000, 'title' => 'Club 5'],
            ['id' => 6, 'direct' => 30000, 'team' => 300000, 'reward' => 3500, 'title' => 'Club 6'],
            ['id' => 7, 'direct' => 50000, 'team' => 700000, 'reward' => 5000, 'title' => 'Club 7'],
        ];

        $earnedVouchers = $user->vouchers()->where('type', 'like', 'club_%')->get();
        
        $stats = [
            'direct_business' => $user->direct_business,
            'team_business'   => $user->team_business,
        ];

        return view('user.club.index', compact('user', 'clubLevels', 'earnedVouchers', 'stats'));
    }
}
