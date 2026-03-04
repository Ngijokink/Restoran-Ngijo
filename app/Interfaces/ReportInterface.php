<?php

namespace App\Interfaces;

interface ReportInterface
{
    public function generateDailyReport($date);
    public function generateMonthlyReport($month, $year);
    public function generateYearlyReport($year);
}