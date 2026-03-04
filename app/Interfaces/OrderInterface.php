<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function allOrder();
    public function findOrder($id);
    public function createOrder(array $data);
    public function updateOrder($id, array $data);
    public function deleteOrder($id);
}