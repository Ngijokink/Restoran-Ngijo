<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CartRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id_user',
            'menu_id' => 'required|exists:table_menus,id_menu',
            'qty' => 'required|integer|min:1',
        ];
    }
}