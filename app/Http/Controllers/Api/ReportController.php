<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Interfaces\ReportInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    protected $repository;

    public function __construct(ReportInterface $repository)
    {
        $this->repository = $repository;
    }

    // ambil semua report
    public function index(Request $request)
    {
        $date = $request->date;

        $reports = $this->repository->allReports($date);

        return ReportResource::collection($reports);
    }

    // ambil report berdasarkan tanggal
    public function show($date)
    {
        $report = $this->repository->findByDate($date);

        return new ReportResource($report);
    }

    // membuat report
    public function store(Request $request)
{
  
    $date = $request->report_date ?? now()->format('Y-m-d');

    $reportData = $this->repository->createReport(['report_date' => $date]);

    return response()->json($reportData);
}

    public function orderStats($date)
    {
        return response()->json(
            $this->repository->getDailyOrderStats($date)
        );
    }

   public function exportPdf($date)
{
    $report = $this->repository->createReport(['report_date' => $date]);
    $pdf = Pdf::loadView('reports.combined-stats-pdf', ['report' => $report]);
    return $pdf->download('report-'.$date.'.pdf');
}
}