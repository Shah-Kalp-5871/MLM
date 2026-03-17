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
        $next_payout_raw = $activeInvestments->min('next_payout_at');
        $next_payout_date = $next_payout_raw ? \Carbon\Carbon::parse($next_payout_raw) : null;
        
        $next_payout = $next_payout_date ? $next_payout_date->format('d M Y') : 'N/A';
        $days_left = $next_payout_date ? (int)now()->diffInDays($next_payout_date, false) : 0;
        
        $eligible_investments = \App\Models\Investment::where('status', 'active')
            ->where('next_payout_at', '<=', now())
            ->get();
            
        $eligible_amount = 0;
        foreach ($eligible_investments as $inv) {
            $eligible_amount += $inv->amount * ($inv->weekly_roi_percentage / 100);
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
