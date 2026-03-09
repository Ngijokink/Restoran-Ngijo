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
        'order_id' => 'required|integer|exists:table_orders,id_order',
        'amount' => 'required|numeric|min:0',
        'method' => ['required', Rule::in(['cash', 'qris', 'transfer'])],
        'status' => ['required', Rule::in(['pending', 'paid', 'failed'])],
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
}