<?php

namespace App\Services;


use App\Models\Menu;
use App\Models\CartItem;
use App\Repositories\OrderRepo;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{ 
    protected $orderRepo;
    public function __construct(OrderRepo $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }
    public function createOrder($user, array $items,  )
    {
    
        return DB::transaction(function () use ($user, $items) {
            $total = 0;
            $order = $this->orderRepo->createOrder([
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

                CartItem::create([
                      'id_cart'=> $order->id_cart,
            'id_menu'=> $item['id_menu'],
            'qty'=> $item['quantity'],
            'price'=> $menu->price,
        'subtotal'=> $subtotal
                ]);

                $menu->decrement('stock', $item['quantity']);
            }

            $order->update(['total' => $total]);

            return $order;
        });
    }
    public function generateOrderCode($date , $lastOrder)
    {
        $date = date('Ymd');

        $lastOrder = $this->orderRepo->whereOrder('created_at', date('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->first();
    if ($lastOrder) {
            $number = 1;
        } else {
        $lastOrder = substr($lastOrder->order_code, -4);
        $number = (int)$lastOrder + 1;
        }

        return 'ORD-' . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}

