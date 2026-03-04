<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_order_item, // Sesuai primary key migration
            'menu' => [
                'id' => $this->menu_id,
                'nama_menu' => $this->menu->nama_menu ?? 'Menu Tidak Ditemukan', 
            ],
            'jumlah' => $this->quantity,
            'harga_satuan' => (int) $this->price,
            'total_harga_item' => (int) $this->subtotal,
        ];
    }
}