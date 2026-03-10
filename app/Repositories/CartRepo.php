<?php

namespace App\Repositories;

use App\Interfaces\CartInterface;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Menu;
use App\Models\Orders;
use App\Models\OrderItem;

class CartRepo implements CartInterface
{

    public function getCartById($cartId)
    {
        return Cart::with('items.menu')
            ->where('id_cart', $cartId)
            ->first();
    }

    public function addToCart(array $data)
    {

        $cart = Cart::firstOrCreate([
            'user_id' => $data['user_id']
        ]);

        $menu = Menu::findOrFail($data['menu_id']);

        $qty = $data['qty'];

        $price = $menu->price;

        $subtotal = $price * $qty;

        $existingItem = CartItem::where('id_cart', $cart->id_cart)
            ->where('id_menu', $menu->id_menu)
            ->first();

        if ($existingItem) {

            $existingItem->qty += $qty;
            $existingItem->subtotal = $existingItem->qty * $existingItem->price;
            $existingItem->save();

            return $existingItem;
        }

        return CartItem::create([
            'id_cart' => $cart->id_cart,
            'id_menu' => $menu->id_menu,
            'qty' => $qty,
            'price' => $price,
            'subtotal' => $subtotal
        ]);
    }

    public function updateQty($cartItemId, $data)
    {
        $item = CartItem::findOrFail($cartItemId);

        $qty = $data['qty'];

        $item->qty = $qty;
        $item->subtotal = $item->price * $qty;

        $item->save();

        return $item;
    }

    public function deleteItem($cartItemId)
    {
        $item = CartItem::findOrFail($cartItemId);
        $item->delete();

        return true;
    }

    public function checkout($userId)
    {

        $cart = Cart::with('items')->where('user_id', $userId)->first();

        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception("Cart kosong");
        }

        $total = $cart->items->sum('subtotal');

        $order = Orders::create([
            'user_id' => $userId,
            'total_price' => $total,
            'status' => 'pending',
            'order_code' => 'ORD-' . rand(10000, 99999),
            
        ]);

       

        CartItem::where('id_cart', $cart->id_cart)->delete();

        return $order;
    }
}