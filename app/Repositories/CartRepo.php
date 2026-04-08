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
        $cart = Cart::with('items.menu')
            ->where('id_cart', $cartId)
            ->first();

        if (!$cart) {
            return null;
        }

        // Always provide total_price based on current cart item subtotals.
        $cart->total_price = (float) $cart->items->sum('subtotal');
        $cart->save();

        return $cart;
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

            $cart->total_price = CartItem::where('id_cart', $cart->id_cart)
                ->sum('subtotal');
            $cart->save();

            return $existingItem;
        }

        $item = CartItem::create([
            'id_cart' => $cart->id_cart,
            'id_menu' => $menu->id_menu,
            'qty' => $qty,
            'price' => $price,
            'subtotal' => $subtotal
        ]);

        $cart->total_price = CartItem::where('id_cart', $cart->id_cart)
            ->sum('subtotal');
        $cart->save();

        return $item;
    }

    public function updateQty($cartItemId, $data)
    {
        $item = CartItem::findOrFail($cartItemId);

        $qty = $data['qty'];

        $item->qty = $qty;
        $item->subtotal = $item->price * $qty;

        $item->save();

        $cart = Cart::findOrFail($item->id_cart);
        $cart->total_price = CartItem::where('id_cart', $item->id_cart)
            ->sum('subtotal');
        $cart->save();

        return $item;
    }

    public function deleteItem($cartItemId)
    {
        $item = CartItem::findOrFail($cartItemId);
        $item->delete();

        $cart = Cart::findOrFail($item->id_cart);
        $cart->total_price = CartItem::where('id_cart', $item->id_cart)
            ->sum('subtotal');
        $cart->save();

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

        // Link the cart to the created order so payment can update the correct order.
        $cart->id_order = $order->id_order;
        $cart->save();

       

        CartItem::where('id_cart', $cart->id_cart)->delete();

        return $order;
    }
}