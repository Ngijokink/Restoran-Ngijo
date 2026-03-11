<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        'id_cart' => 'required|integer|exists:carts,id_cart',
        'amount' => 'required|numeric|min:0',
        'method' => ['required', Rule::in(['cash', 'qris', 'transfer'])],
        'proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'paid_at' => 'nullable|date',
        ];

    }
    public function UpdateStatusRules()
    {
        return [
            'status' => ['required', Rule::in(['pending', 'paid', 'failed'])],
        ];
    }   

    public function messages()  
    {
        return [
        'id_cart.required' => 'silahkan masukkan id_cart',
        'id_cart_integer'=> 'id harus berupa angka',
        'id_cart.exist'=> 'id tidak ditemukan',
        'amount.required'=> 'silahkan masukkan nominal',
        'amount.numeric'=> 'harus berupa angka',
        'method.required'=> 'anda mau qris,tf atau cash',
        ''=> '',

        ];
    }
}