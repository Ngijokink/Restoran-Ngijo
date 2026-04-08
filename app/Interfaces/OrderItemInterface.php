<?php

namespace App\Interfaces;

interface OrderItemInterface
{
    public function allOrderItem();
    public function findOrderItem($id);
    public function createOrderItem(array $data);
    public function updateOrderItem($id, array $data);
    public function deleteOrderItem($id);
}
