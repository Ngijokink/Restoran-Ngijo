<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransactionRequest extends FormRequest
{
    public function authorize()
    {
        // assuming auth handled by middleware
        return true;
    }

    public function rules()
    {
        return [
            'order_id' => 'required|integer|exists:table_orders,id_order',
            'total'    => 'required|numeric|min:0',
            'method'   => ['required', Rule::in(['cash', 'qris', 'transfer'])],
            'status'   => ['required', Rule::in(['pending', 'paid', 'cancelled', 'failed'])],
            'paid_at'  => 'nullable|date',
        ];
    }
}
