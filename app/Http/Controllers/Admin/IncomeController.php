<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ROIIncome;
use App\Models\LevelCommission;
use Illuminate\Http\Request;

class IncomeController extends Controller
{
    public function __construct(protected \App\Services\ROIEngine $roiEngine) {}

    public function roiIndex()
    {
        $incomes = ROIIncome::with(['user', 'investment'])->orderBy('distributed_at', 'desc')->paginate(20);
        return view('admin.roi.index', compact('incomes'));
    }

    public function runROI()
    {
        try {
            $results = $this->roiEngine->distributeROI();
            return back()->with('success', "ROI distributed to {$results['processed']} accounts. Total: ₹" . number_format($results['total_amount'], 2));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function levelIndex()
    {
        $commissions = LevelCommission::with(['user', 'fromUser', 'investment'])->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.level-income.index', compact('commissions'));
    }
}
