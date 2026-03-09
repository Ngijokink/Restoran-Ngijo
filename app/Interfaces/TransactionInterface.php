<?php

namespace App\Interfaces;

interface TransactionInterface
{
    public function allTransaction();
    public function findTransaction($id);
    public function createTransaction(array $data);
}