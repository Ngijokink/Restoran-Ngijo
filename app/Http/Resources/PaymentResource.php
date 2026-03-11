<?php

namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class PaymentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        Carbon::setLocale('id'); // Set locale ke Indonesia untuk format tanggal
        return [
            'id' => $this->id_payment,
            'cart_id' => $this->id_cart,
            'pembayaran' => [
                'nominal' => (float) $this->amount,
                'metode' => strtoupper($this->method),
                'status' => $this->status,
            ],
            'bukti_pembayaran' => $this->proof ? asset('storage/' . $this->proof) : null,
            'dibayar_pada' => $this->paid_at ? Carbon::parse($this->paid_at)->format('Y-m-d H:i:s') : null,
            'dibuat_pada' => $this->created_at 
    ? Carbon::parse($this->created_at)
        ->timezone('Asia/Jakarta') // Menambah 7 jam secara otomatis ke WIB
        ->format('d-m-Y H:i:s') . ' WIB'
        : null,
        ];
    }
}