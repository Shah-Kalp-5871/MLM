<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ROIIncome;
use Illuminate\Http\Request;

class ROIController extends Controller
{
    public function index()
    {
        $roi_records = ROIIncome::where('user_id', auth()->id())
            ->with('investment.package')
            ->orderBy('distributed_at', 'desc')
            ->paginate(20);
            
        return view('user.roi.index', compact('roi_records'));
    }
}
