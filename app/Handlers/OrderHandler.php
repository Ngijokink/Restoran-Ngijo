<?php

namespace App\Handlers;

use App\Repositories\MenuRepo;
use App\Repositories\OrderRepo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderHandler
{
    protected $orderRepo;
    protected $MenuRepo;

    public function __construct(OrderRepo $orderRepo, MenuRepo $MenuRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->MenuRepo = $MenuRepo;
    }

    public function index()
    {
        return $this->orderRepo->allOrder();
    }

    public function show($id)
    {
        return $this->orderRepo->findOrder($id);
    }

    public function store(Request $request)
    {
        $data = $request->only(['field1', 'field2', 'field3']);
        return $this->orderRepo->createOrder($data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['field1', 'field2', 'field3']);
        return $this->orderRepo->updateOrder($id, $data);
    }

    public function destroy($id)
    {
        return $this->orderRepo->deleteOrder($id);
    }


public function createOrder($request)
{
    $menus = $request->menus;

    if (!$menus) {
        throw new \Exception("Menu tidak boleh kosong");
    }

    $orderCode = "ORD-" . now()->format('Ymd') . "-" . rand(1000,9999);

    $order = $this->orderRepo->createOrder([
        'user_id' => auth()->id(),
        'table_id' => $request->table_id,
        'order_code' => $orderCode,
        'status' => 'pending'
    ]);

    $cart = $order->cart()->create([
        'user_id' => auth()->id(),
        'total_price' => 0
    ]);

    $total = 0;

    foreach ($menus as $item) {

        $menu = $this->MenuRepo->findMenu($item['id_menu']);

        if (!$menu) {
            throw new \Exception("Menu tidak ditemukan");
        }

        $subtotal = $menu->price * $item['qty'];

        $cart->cartItems()->create([
            'id_menu' => $menu->id_menu,
            'qty' => $item['qty'],
            'price' => $menu->price,
            'subtotal' => $subtotal
        ]);

        $total += $subtotal;
    }

    $cart->update([
        'total_price' => $total
    ]);

    return $order->load('cart.cartItems.menu');
}
}
