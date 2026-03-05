<?php
namespace App\Repositories; 
use App\Models\Payment;
use App\Interfaces\paymentInterface;  


class PaymentRepo implements PaymentInterface
{
    public function create(array $data)
    {
        return Payment::create($data);
    }

    public function findByOrderId(int $idOrder)
    {
        return Payment::where('id_order', $idOrder)->first();
    }

    public function updateStatus(int $paymentId, string $status)
    {
        $payment = Payment::find($paymentId);
        if ($payment) {
            $payment->status = $status;
            $payment->save();
            return $payment;
        }
        return null;
    }
}