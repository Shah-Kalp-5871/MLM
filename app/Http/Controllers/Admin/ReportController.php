<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function index(Request $request)
    {
        $range = $request->get('range', 'today'); // today, week, month, all, custom
        $customDate = $request->get('date');

        [$startDate, $endDate] = $this->getDatesFromRange($range, $customDate);

        $reportData = $this->reportService->getConsolidatedReport($startDate, $endDate);

        return view('admin.reports.index', [
            'data' => $reportData,
            'range' => $range,
            'startDate' => $startDate->toDateString(),
            'endDate' => $endDate->toDateString(),
        ]);
    }

    public function exportPdf(Request $request)
    {
        $range = $request->get('range', 'today');
        $customDate = $request->get('date');

        [$startDate, $endDate] = $this->getDatesFromRange($range, $customDate);

        $reportData = $this->reportService->getConsolidatedReport($startDate, $endDate);
        
        $pdf = Pdf::loadView('admin.reports.pdf', [
            'data' => $reportData,
            'range' => $range,
            'startDate' => $startDate->toFormattedDateString(),
            'endDate' => $endDate->toFormattedDateString(),
            'generatedAt' => Carbon::now()->toDateTimeString(),
        ]);

        return $pdf->download("Business-Report-{$range}-" . Carbon::now()->format('Y-m-d') . ".pdf");
    }

    protected function getDatesFromRange($range, $start = null, $end = null)
    {
        $endDate = Carbon::now();
        
        switch ($range) {
            case 'today':
                $startDate = Carbon::today();
                break;
            case 'week':
                $startDate = Carbon::now()->subWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->subMonth();
                break;
            case 'custom':
                $startDate = $start ? Carbon::parse($start)->startOfDay() : Carbon::today();
                $endDate = $start ? Carbon::parse($start)->endOfDay() : Carbon::now();
                break;
            case 'all':
            default:
                $startDate = Carbon::create(2020, 1, 1);
                break;
        }

        return [$startDate, $endDate];
    }

    public function voucherReport()
    {
        $vouchers = \App\Models\Voucher::with(['owner', 'redeemer'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $stats = [
            'total_generated' => \App\Models\Voucher::count(),
            'total_value' => \App\Models\Voucher::sum('amount'),
            'total_used' => \App\Models\Voucher::where('status', 'used')->count(),
            'unused_value' => \App\Models\Voucher::where('status', 'unused')->sum('amount'),
        ];

        return view('admin.reports.vouchers', compact('vouchers', 'stats'));
    }

    public function triggerDaily()
    {
        try {
            \Illuminate\Support\Facades\Artisan::call('report:daily');
            return redirect()->back()->with('success', 'Daily report has been generated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to generate daily report: ' . $e->getMessage());
        }
    }
}
