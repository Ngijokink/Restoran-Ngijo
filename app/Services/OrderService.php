<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    public function createOrder($user, array $items)
    {
        return DB::transaction(function () use ($user, $items) {
            $total = 0;
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'pending'
            ]);

            foreach ($items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);

                if ($menu->stock < $item['quantity']) {
                    throw new Exception("Tidak cukup stok untuk menu: " . $menu->name);
                }

                $subtotal = $menu->price * $item['quantity'];
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $item['menu_id'],
                    'quantity' => $item['quantity'],
                    'price' => $menu->price,
                    'subtotal' => $subtotal
                ]);

                $menu->decrement('stock', $item['quantity']);
            }

            $order->update(['total' => $total]);

            return $order;
        });
    }
}

