<?php

namespace App\Repositories;

use App\Models\Report;
use Illuminate\Support\Collection;
use App\Interfaces\ReportInterface;


class ReportRepo implements ReportInterface
{
    public function getByDate(string $date): ?Report
    {
        return Report::where('report_date', $date)->first();
    }

    public function save(array $data): Report
    {
        $report = Report::firstOrNew([
            'report_date' => $data['report_date']
        ]);

        $report->total_orders = $data['total_orders'] ?? 0;
        $report->total_order_revenue = $data['total_order_revenue'] ?? 0;
        $report->order_status_breakdown = $data['order_status_breakdown'] ?? null;
        $report->total_transactions = $data['total_transactions'] ?? 0;
        $report->total_success_amount = $data['total_success_amount'] ?? 0;
        $report->total_per_method = $data['total_per_method'] ?? null;

        $report->save();

        return $report;
    }

    public function getAll(?string $from = null, ?string $to = null): Collection
    {
        $query = Report::query();

        if ($from) $query->where('report_date', '>=', $from);
        if ($to) $query->where('report_date', '<=', $to);

        return $query->orderBy('report_date', 'desc')->get();
    }

    public function generateDailyReport($date): ?Report
    {
        return $this->getByDate($date);
    }

    public function generateMonthlyReport($month, $year): Collection
    {
        return Report::whereYear('report_date', $year)
            ->whereMonth('report_date', $month)
            ->orderBy('report_date', 'desc')
            ->get();
    }

    public function generateYearlyReport($year): Collection
    {
        return Report::whereYear('report_date', $year)
            ->orderBy('report_date', 'desc')
            ->get();
    }
}