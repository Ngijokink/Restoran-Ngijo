<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; // semua user bisa request, bisa ditambahkan middleware nanti
    }

    public function rules()
    {
        return [
            'report_date' => 'required|date', // wajib ada, format YYYY-MM-DD
            'total_orders' => 'required|integer|min:0',
            'total_order_revenue' => 'required|numeric|min:0',
            'order_status_breakdown' => 'nullable|json', // JSON: {"pending": 3, "paid": 5}
            'total_transactions' => 'required|integer|min:0',
            'total_success_amount' => 'required|numeric|min:0',
            'total_per_method' => 'nullable|json' // JSON: {"cash": 20000, "qris": 50000}
        ];
    }

    public function messages()
    {
        return [
            'report_date.required' => 'Tanggal report wajib diisi',
            'report_date.date' => 'Format tanggal harus YYYY-MM-DD',
            'total_orders.required' => 'Total orders wajib diisi',
            'total_orders.integer' => 'Total orders harus angka bulat',
            'total_order_revenue.required' => 'Total revenue wajib diisi',
            'total_order_revenue.numeric' => 'Total revenue harus angka',
            'order_status_breakdown.json' => 'Order status breakdown harus format JSON',
            'total_transactions.required' => 'Total transaksi wajib diisi',
            'total_transactions.integer' => 'Total transaksi harus angka bulat',
            'total_success_amount.required' => 'Total sukses amount wajib diisi',
            'total_success_amount.numeric' => 'Total sukses amount harus angka',
            'total_per_method.json' => 'Total per method harus format JSON'
        ];
    }
}