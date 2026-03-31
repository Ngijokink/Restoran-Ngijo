<?php

namespace App\Http\Resources;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tanggal' => $this->report_date->format('d M Y', Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y')),
            'statistik_pesanan' => [
                'total_item' => $this->total_orders,
                'total_rupiah' => (float) $this->total_order_revenue,
                'detail_status' => $this->order_status_breakdown, // Berupa Array/JSON
            ],
            'statistik_pembayaran' => [
                'total_sukses' => $this->total_transactions,
                'total_nominal' => (float) $this->total_success_amount,
                'detail_metode' => $this->total_per_method, // Berupa Array/JSON
            ],
            'terakhir_diperbarui' => $this->updated_at->format('H:i:s'),
        ];
    }
}
