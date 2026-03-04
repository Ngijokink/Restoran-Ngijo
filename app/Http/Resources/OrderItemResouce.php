<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        Carbon::setLocale('id'); // Set locale ke Indonesia untuk format tanggal
        return [
            'id' => $this->id_order_item, // Sesuai primary key migration
            'menu' => [
                'id' => $this->menu_id,
                'nama_menu' => $this->menu->nama_menu ?? 'Menu Tidak Ditemukan', 
            ],
            'jumlah' => $this->quantity,
            'harga_satuan' => (int) $this->price,
            'total_harga_item' => (int) $this->subtotal,
            'dibuat_pada' => $this->created_at 
    ? Carbon::parse($this->created_at)
        ->timezone('Asia/Jakarta') // Menambah 7 jam secara otomatis ke WIB
        ->format('d-m-Y H:i:s') . ' WIB' 
    : '-',
        ];
    }
}