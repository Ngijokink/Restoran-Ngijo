<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'order_id'       => $this->order_id,
            'total_bayar'    => (float) $this->total,  // Sesuai kolom 'total' di migration
            'metode'         => strtoupper($this->method), // Sesuai kolom 'method'
            'status_pembayaran' => strtoupper($this->status), // Sesuai kolom 'status'
            'waktu_bayar'    => $this->paid_at ? $this->paid_at->format('Y-m-d H:i:s') : null,
            'dibuat_pada'    => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}