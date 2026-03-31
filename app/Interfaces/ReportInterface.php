<?php

namespace App\Interfaces;

interface ReportInterface
{
    
    public function allReports(string $date);


    public function findByDate(string $date);


    public function createReport(array $data);


    public function getDailyOrderStats(string $date);

   
    public function getDailyTransactionStats(string $date);
}