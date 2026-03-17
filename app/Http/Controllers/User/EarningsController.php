<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ROIIncome;
use App\Models\LevelCommission;
use Illuminate\Http\Request;

class EarningsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $totalROI = ROIIncome::where('user_id', $user->id)->sum('roi_amount');
        $totalLevelIncome = LevelCommission::where('receiver_id', $user->id)->sum('commission_amount');
        $totalEarnings = $totalROI + $totalLevelIncome;
        
        $roiRecords = ROIIncome::where('user_id', $user->id)
            ->with('investment')
            ->orderBy('distributed_at', 'desc')
            ->paginate(5, ['*'], 'roi_page');
            
        $levelCommissions = LevelCommission::where('receiver_id', $user->id)
            ->with('fromUser')
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'level_page');
            
        return view('user.earnings', compact(
            'totalROI', 
            'totalLevelIncome', 
            'totalEarnings', 
            'roiRecords', 
            'levelCommissions'
        ));
    }
}
