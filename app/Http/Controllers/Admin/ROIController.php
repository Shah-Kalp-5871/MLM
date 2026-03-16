<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ROIIncome;
use App\Services\ROIEngine;
use Illuminate\Http\Request;

class ROIController extends Controller
{
    public function __construct(protected ROIEngine $roiEngine) {}

    public function index()
    {
        $roi_history = ROIIncome::with('investment.user')->orderBy('created_at', 'desc')->paginate(20);
        
        // Dynamic Metrics for Engine Control Cards
        $next_payout = \Carbon\Carbon::now()->next(\Carbon\Carbon::MONDAY)->format('D, d M');
        $days_left = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::now()->next(\Carbon\Carbon::MONDAY));
        $eligible_amount = \App\Models\Investment::where('status', 'active')->sum('amount') * 0.03;
        $total_investments = \App\Models\Investment::where('status', 'active')->count();

        return view('admin.roi.index', compact('roi_history', 'next_payout', 'days_left', 'eligible_amount', 'total_investments'));
    }

    public function run()
    {
        try {
            $count = $this->roiEngine->distributeROI();
            return back()->with('success', "ROI distributed successfully.");
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function settings()
    {
        return view('admin.settings.index');
    }
}
