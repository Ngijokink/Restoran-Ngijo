<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_menu'       => $this->id_menu,
            'nama_menu'     => $this->name, // Sesuaikan dengan kolom 'name' di tabel_menus
            'harga'         => (int) $this->price,
            'stok_saat_ini' => (int) $this->stock,
            'tersedia'      => (bool) $this->is_available,
            
            // Ini kunci agar data kategori muncul lengkap (id & nama kategori)
            'kategori'      => new CategoryResource($this->whenLoaded('category')),
            
            // Format URL gambar yang rapi
            'image_url'     => $this->image 
                ? asset('storage/' . $this->image) 
                : null,
        ];
    }
}