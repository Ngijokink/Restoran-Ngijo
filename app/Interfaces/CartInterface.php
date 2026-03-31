<?php
namespace App\Interfaces;

interface CartInterface
{
    public function getCartById($cartId);

    public function addToCart(array $data);

    public function updateQty($cartItemId, $qty);

    public function deleteItem($cartItemId);

    public function checkout($userId);
}