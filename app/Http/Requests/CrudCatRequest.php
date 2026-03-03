<?php
namespace App\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator;
class CrudCatRequest extends FormRequest
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
    

    
    
}