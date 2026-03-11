<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class MenuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:table_categories,id_category',
            'price'        => 'required|integer|min:0',
            'stock'        => 'required|integer|min:0',
            'is_available' => 'required|boolean',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function Messages()
    {
        return [
            'name.required'         => 'Nama menu wajib diisi.',
            'name.string'           => 'Nama menu harus berupa teks.',
            'name.max'              => 'Nama menu maksimal 255 karakter.',

            'category_id.required'  => 'Kategori wajib dipilih.',
            'category_id.exists'    => 'Kategori yang dipilih tidak valid.',

            'price.required'        => 'Harga wajib diisi.',
            'price.integer'         => 'Harga harus berupa angka.',
            'price.min'             => 'Harga tidak boleh kurang dari 0.',

            'stock.required'        => 'Stok wajib diisi.',
            'stock.integer'         => 'Stok harus berupa angka.',
            'stock.min'             => 'Stok tidak boleh kurang dari 0.',

            'is_available.required' => 'Status ketersediaan wajib diisi.',
            'is_available.boolean'  => 'Status ketersediaan harus bernilai true atau false.',

            'image.image'           => 'File yang diupload harus berupa gambar.',
            'image.mimes'           => 'Format gambar yang diizinkan: jpeg, png, jpg.',
            'image.max'             => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}