<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Interfaces\ReportInterface;
use App\Http\Controllers\Controller;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
class ReportController extends Controller
{
    protected $repository;

    public function __construct(ReportInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $date = $request->input('date') ?? now()->toDateString();
        return response()->json($this->repository->generateDailyReport($date));
    }
    public function generateReport(Request $request)
    {
        $date = $request->input('date') ?? now()->toDateString();
        $reportData = $this->repository->generateDailyReport($date);
        return response()->json($reportData);
    }
    public function generateMonthlyReport(Request $request)
    {
        $month = $request->input('month') ?? now()->month;
        $year = $request->input('year') ?? now()->year;

        $reportData = $this->repository->generateMonthlyReport($month, $year);
        return response()->json($reportData);
    }

    public function generateYearlyReport(Request $request)
    {
        $year = $request->input('year') ?? now()->year;

        $reportData = $this->repository->generateYearlyReport($year);
        return response()->json($reportData);
    }
    
    public function pdfReport(Request $request)
    {
        $date = $request->input('date') ?? now()->toDateString();
        $reportData = $this->repository->generateDailyReport($date);

        $pdf = Pdf::loadView('reports.daily', ['report' => $reportData]);
        return $pdf->download('daily_report_' . $date . '.pdf');
    }
}
    


