<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Interfaces\ReportInterface;
use App\Http\Controllers\Controller;
class ReportController extends Controller
{
    protected $repository;

    public function __construct(ReportInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        return response()->json($this->repository->generateDailyReport($request));
    }
}