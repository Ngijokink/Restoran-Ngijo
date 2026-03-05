<?php

namespace App\Interfaces;

interface PaymentInterface
{
    public function create(array $data);
    public function findByOrderId(int $idOrder);
    public function updateStatus(int $paymentId, string $status);
}