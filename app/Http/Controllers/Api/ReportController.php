<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use App\Interfaces\ReportInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\ResponseHelpers;

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
        try {

            $date = $request->date;
            $reports = $this->repository->allReports($date);

            return ResponseHelpers::success(
                ReportResource::collection($reports),
                'Data Report'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal mengambil report : '.$e->getMessage());

        }
    }

    // ambil report berdasarkan tanggal
    public function show($date)
    {
        try {

            $report = $this->repository->findByDate($date);

            return ResponseHelpers::success(
                new ReportResource($report),
                'Detail Report'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal menampilkan report : '.$e->getMessage());

        }
    }

    // membuat report
    public function store(Request $request)
    {
        try {

            $date = $request->report_date ?? now()->format('Y-m-d');

            $report = $this->repository->createReport([
                'report_date' => $date
            ]);

            return ResponseHelpers::success($report, 'Report berhasil dibuat');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal membuat report : '.$e->getMessage());

        }
    }

    // statistik order harian
    public function orderStats($date)
    {
        try {

            $stats = $this->repository->getDailyOrderStats($date);

            return ResponseHelpers::success($stats, 'Statistik order harian');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal mengambil statistik : '.$e->getMessage());

        }
    }

    // export report ke PDF
    public function exportPdf($date)
    {
        try {

            $report = $this->repository->createReport([
                'report_date' => $date
            ]);

            $pdf = Pdf::loadView(
                'reports.combined-stats-pdf',
                ['report' => $report]
            );

            return $pdf->download('report-'.$date.'.pdf');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal export PDF : '.$e->getMessage());

        }
    }
}