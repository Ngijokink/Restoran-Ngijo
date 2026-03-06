<?php
namespace App\Repositories;

use App\Interfaces\CartInterface;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Menu;
use App\Models\Orders;
use App\Models\Item;

class CartRepo implements CartInterface
{

    public function getCartByUser($userId)
    {
        return Cart::with('items.menu')
            ->where('user_id', $userId)
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

        return CartItem::create([
            'cart_id' => $cart->id_cart,
            'menu_id' => $menu->id_menu,
            'qty' => $qty,
            'price' => $price,
            'subtotal' => $subtotal
        ]);
    }

    public function updateQty($cartItemId, $qty)
    {
        $item = CartItem::findOrFail($cartItemId);

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

        if (!$cart) {
            return null;
        }

        $total = $cart->items->sum('subtotal');

        $order = Orders::create([
            'user_id' => $userId,
            'total_price' => $total,
            'status' => 'pending',
            'order_code' => 'ORD-' . rand(10000,99999)
        ]);

        foreach ($cart->items as $item) {

            Item::create([
                'order_id' => $order->id_order,
                'menu_id' => $item->menu_id,
                'qty' => $item->qty,
                'price' => $item->price,
                'subtotal' => $item->subtotal
            ]);
        }

        CartItem::where('cart_id', $cart->id_cart)->delete();

        return $order;
    }
}