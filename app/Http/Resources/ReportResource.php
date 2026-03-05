<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        Carbon::setLocale('id');

        return [
            'id' => $this->id,
            'report_date' => $this->report_date ? Carbon::parse($this->report_date)->timezone('Asia/Jakarta')->format('d-m-Y') : '-',
            'total_orders' => (int) $this->total_orders,
            'total_order_revenue' => (float) $this->total_order_revenue,
            'order_status_breakdown' => $this->order_status_breakdown,
            'total_transactions' => (int) $this->total_transactions,
            'total_success_amount' => (float) $this->total_success_amount,
            'total_per_method' => $this->total_per_method,
            'created_at' => $this->created_at ? Carbon::parse($this->created_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') . ' WIB' : '-',
            'updated_at' => $this->updated_at ? Carbon::parse($this->updated_at)->timezone('Asia/Jakarta')->format('d-m-Y H:i:s') . ' WIB' : '-',
        ];
    }
}