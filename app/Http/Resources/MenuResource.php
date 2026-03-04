<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_menu'      => $this->id_menu,
            'nama_menu'    => $this->menu, // Sesuai kolom 'menu' di fillable
            'harga'        => (int) $this->price,
            'stok_saat_ini'=> (int) $this->stock,
            'tersedia'     => (bool) $this->is_available,
            // Menampilkan kategori jika di-load
            'kategori'     => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}