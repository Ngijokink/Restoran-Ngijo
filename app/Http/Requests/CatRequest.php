<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
class CatRequest extends FormRequest
{    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category' => 'required|string|max:255|unique:table_categories,category,' . $this->route('id_category') . ',id_category',
            
        ];
    }
    public function messages()
    {
        return [
            'category.required' => 'Nama kategori harus diisi.',
            'category.string' => 'Nama kategori harus berupa teks.',
            'category.max' => 'Nama kategori tidak boleh lebih dari 255 karakter.',
            'category.unique' => 'Nama kategori sudah ada. Silakan gunakan nama lain.',
        ];
    }
    

    
    
}