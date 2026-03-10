<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
}