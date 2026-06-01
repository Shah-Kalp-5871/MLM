<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ROIIncome;
use App\Models\LevelCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class IncomeController extends Controller
{
    public function roiIndex()
    {
        $activeInvestments = \App\Models\Investment::where('status', 'active');
        
        $total_investments = $activeInvestments->count();

        // Always point to the next upcoming Monday (ROI is distributed every Monday manually)
        $nextMonday = \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY);
        if ($nextMonday->isToday() || $nextMonday->isPast()) {
            $nextMonday->addWeek();
        }

        $next_payout = $nextMonday->format('D, d M Y'); // e.g. "Mon, 09 Jun 2026"
        $days_left   = max(0, (int) now()->diffInDays($nextMonday, false));

        // Eligible = investments whose next_payout_at is on or before this coming Monday
        $eligible_investments = \App\Models\Investment::where('status', 'active')
            ->where('next_payout_at', '<=', $nextMonday)
            ->get();

        $eligible_amount = 0;
        foreach ($eligible_investments as $inv) {
            $isFirstPayout = ($inv->total_roi_earned == 0);
            if ($isFirstPayout) {
                $activatedDay  = $inv->created_at->startOfDay();
                $daysActive    = $activatedDay->diffInDays($nextMonday->startOfDay());
                $dailyRoi      = $inv->amount * ($inv->weekly_roi_percentage / 7 / 100);
                $eligible_amount += round($dailyRoi * $daysActive, 2);
            } else {
                $eligible_amount += $inv->amount * ($inv->weekly_roi_percentage / 100);
            }
        }

        $roi_history = ROIIncome::with(['user', 'investment'])->orderBy('distributed_at', 'desc')->paginate(20);
        
        $settings = [
            'platform_currency_symbol' => \App\Models\Setting::get('platform_currency_symbol', '$'),
        ];

        return view('admin.roi.index', compact(
            'roi_history', 
            'total_investments', 
            'next_payout', 
            'days_left', 
            'eligible_amount',
            'settings'
        ));
    }

    public function levelIndex()
    {
        $commissions = LevelCommission::with(['receiver', 'fromUser', 'roiIncome'])->orderBy('created_at', 'desc')->paginate(20);
        return view('admin.level-income.index', compact('commissions'));
    }

    public function triggerROI()
    {
        try {
            Artisan::call('roi:distribute');
            return redirect()->back()->with('success', 'ROI distribution process has been triggered successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to trigger ROI distribution: ' . $e->getMessage());
        }
    }
}
