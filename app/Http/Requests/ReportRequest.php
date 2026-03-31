<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportHistoryRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        /**
         * Kita hanya memvalidasi 'report_date'.
         * Field lain seperti total_orders, total_order_revenue, dll 
         * TIDAK BOLEH dikirim dari Postman/User karena itu dihitung 
         * otomatis oleh Repository agar data akurat.
         */
        return [
            'report_date' => 'nullable|date|before_or_equal:today',
        ];
    }

    public function messages()
    {
        return [
            'report_date.date' => 'Format tanggal harus valid (YYYY-MM-DD)',
            'report_date.before_or_equal' => 'Anda tidak bisa membuat laporan untuk tanggal di masa depan.',
        ];
    }

    /**
     * Jika user tidak mengirim tanggal di Postman, 
     * kita otomatis set ke tanggal hari ini.
     */
    protected function prepareForValidation()
    {
        if (!$this->report_date) {
            $this->merge([
                'report_date' => now()->toDateString(),
            ]);
        }
    }
}