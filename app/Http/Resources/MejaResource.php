<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MejaResource extends JsonResource
{
    public function toArray($request)
{
    return [
        'id_table' => $this->id_table,
        'table_number' => $this->table_number,
        'qr_code' => $this->qr_code ? asset('storage/'.$this->qr_code) : null,
        'status' => $this->status,
        'created_at' => $this->created_at
    ];
}
}