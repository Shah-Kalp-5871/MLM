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
        return view('admin.roi.index', compact('roi_history'));
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
