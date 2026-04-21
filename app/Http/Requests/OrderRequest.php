<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            // 'user_id' => 'required|exists:users,id_user',
            'table_id' => 'required|exists:table_meja,id_table',
            // 'total_price' => 'required|numeric|min:0',
            // 'status' => 'required|string|in:pending,paid,cancelled',
        ];
    }

    public function messages()
    {
        return [
            // 'user_id.required' => 'User ID diperlukan.',
            // 'user_id.exists' => 'User tidak ditemukan.',
            'table_id.required' => 'Table ID diperlukan.',
            'table_id.exists' => 'Table tidak ditemukan.',
            // 'total_price.required' => 'Total price diperlukan.',
            // 'total_price.numeric' => 'Total price harus berupa angka.',
            // 'total_price.min' => 'Total price tidak boleh negatif.',
            // 'status.required' => 'Status diperlukan.',
            // 'status.string' => 'Status harus berupa teks.',
            // 'status.in' => 'Status harus salah satu dari: pending, paid, cancelled.',
        ];
    }
}
