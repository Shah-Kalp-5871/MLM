<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ReportService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GenerateDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and save the daily business analytics report';

    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        parent::__construct();
        $this->reportService = $reportService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating daily report...');

        $startDate = Carbon::yesterday()->startOfDay();
        $endDate = Carbon::yesterday()->endOfDay();

        try {
            $reportData = $this->reportService->getConsolidatedReport($startDate, $endDate);
            
            $pdf = Pdf::loadView('admin.reports.pdf', [
                'data' => $reportData,
                'range' => 'daily',
                'startDate' => $startDate->toFormattedDateString(),
                'endDate' => $endDate->toFormattedDateString(),
                'generatedAt' => Carbon::now()->toDateTimeString(),
            ]);

            $fileName = 'reports/daily/Business-Report-' . $startDate->format('Y-m-d') . '.pdf';
            Storage::disk('public')->put($fileName, $pdf->output());

            $this->info("Daily report generated successfully: storage/app/public/{$fileName}");
            Log::info("Daily report generated: {$fileName}");

            // Note: In a real scenario, you might also email this to the business team here.
            
        } catch (\Exception $e) {
            $this->error('Failed to generate daily report: ' . $e->getMessage());
            Log::error('Daily report generation failed: ' . $e->getMessage());
        }
    }
}
