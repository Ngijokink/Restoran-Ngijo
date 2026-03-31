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
    public function messages()
    {  
        return[
             'user_id.required'  => 'user id diperlukan',
             'user_id.exist'=> 'user tidak ada',
             

             'menu_id.required' => 'menu id diperlukan',
             'menu_id.exist'=> 'menu tidak ada wir',


             'qty.required'=> 'silahkan masukkan jumlah barang',
             'qty.integer'=> 'masukkan angka',
             'qty.min'=> 'minimal 1 quantity',
    
        ];

        
       
    }
}