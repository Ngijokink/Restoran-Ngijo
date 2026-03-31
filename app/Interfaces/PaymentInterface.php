<?php

namespace App\Interfaces;

interface PaymentInterface
{
    public function create(array $data);
    public function findByCartId(int $cartId);
    public function updateStatus(int $paymentId, string $status);
}