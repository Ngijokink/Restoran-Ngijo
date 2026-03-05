<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Interfaces\ReportInterface;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    protected $repository;

    public function __construct(ReportInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json(ReportResource::collection($this->repository->allReport()));
    }

    public function show($id)
    {
        $report = $this->repository->findReport($id);
        if (!$report) {
    return response()->json( $this->repository->findReport($id) , 404);
        }
        return response()->json(new ReportResource($report));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json(new ReportResource($this->repository->createReport($data)));
    }

    public function update(Request $request, $id)
    {
        $report = $this->repository->findReport($id);
        if (!$report) {
            return response()->json($this->repository->findReport($id), 404);
        }
        $data = $request->all();
        $this->repository->updateReport($id, $data);
        return response()->json(new ReportResource($this->repository->findReport($id)));
    }

    public function destroy($id)
    {
        return response()->json($this->repository->deleteReport($id));
    }

    public function exportPdf()
    {
        // Mengambil semua data laporan
        $reports = $this->repository->allReport();

        // Load view dan masukkan datanya
        $pdf = Pdf::loadView('pdf.report', compact('reports'));

        // Download file PDF
        return $pdf->download('laporan-report.pdf');
    }
}

