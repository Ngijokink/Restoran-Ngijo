<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        Carbon::setLocale('id'); // Set locale ke Indonesia untuk format tanggal
        return [
            // id_order adalah Primary Key di migration kamu
            'id' => $this->id_order, 
            'order_code' => $this->order_code,
            'status' => strtoupper($this->status),
            'total_harga' => (int) $this->total_price, // integer sesuai migration
            'customer_id' => $this->user_id,
            
            // Relasi Customer (Pastikan relasi 'user' ada di Model Order)
            'customer' => [
                'name' => $this->user->name ?? 'Unknown',
            ],

            // Jika dibayar, tampilkan waktu bayar
            'waktu_bayar' => $this->paid_at ? $this->paid_at->format('Y-m-d H:i:s') : null,
            
            // Relasi ke tabel 'transaksi' dan 'order_items'
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'Payment' => new PaymentResource($this->whenLoaded('transaksi')),
            
            'dibuat_pada' => $this->created_at 
    ? Carbon::parse($this->created_at)
        ->timezone('Asia/Jakarta') // Menambah 7 jam secara otomatis ke WIB
        ->format('d-m-Y H:i:s') . ' WIB' 
    : '-',
        ];
    }
}