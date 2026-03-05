<?php

namespace App\Interfaces;

interface ReportInterface
{
   public function allReport(?string $from = null, ?string $to = null);
   public function findReport($id);
   public function createReport(array $data);
   public function updateReport($id, array $data);
   public function deleteReport($id);
}