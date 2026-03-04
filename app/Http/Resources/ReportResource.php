<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        Carbon::setLocale('id'); // Set locale ke Indonesia untuk format tanggal
        return [
            'ringkasan' => [
                'total_pendapatan' => (int) $this['total_revenue'],
                'total_pesanan'    => $this['total_orders'],
                'pesanan_sukses'   => $this['success_orders'],
            ],
            'statistik_status' => $this['status_counts'],
            'menu_terlaris'    => $this['top_menus'],
            'generated_at'     => $this->created_at 
    ? Carbon::parse($this->created_at)
        ->timezone('Asia/Jakarta') // Menambah 7 jam secara otomatis ke WIB
        ->format('d-m-Y H:i:s') . ' WIB' 
    : '-',
        ];
    }
}