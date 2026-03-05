<?php

namespace App\Repositories;

use App\Models\Report;
use Illuminate\Support\Collection;
use App\Interfaces\ReportInterface;


class ReportRepo implements ReportInterface
{
   public function allReport(?string $from = null, ?string $to = null): Collection
   {
       $query = Report::query();

       if ($from) {
           $query->whereDate('created_at', '>=', $from);
       }

       if ($to) {
           $query->whereDate('created_at', '<=', $to);
       }

       return $query->get();
   }

   public function findReport($id): ?Report
   {
       return Report::find($id);
   }

   public function createReport(array $data): Report
   {
       return Report::create($data);
   }

   public function updateReport($id, array $data): bool
   {
       $report = Report::find($id);
       return $report ? $report->update($data) : false;
   }

   public function deleteReport($id): bool
   {
       $report = Report::find($id);
       return $report ? $report->delete() : false;
   }
}  
