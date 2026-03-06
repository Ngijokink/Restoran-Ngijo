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

    public function generateCode($categoryId, $menuId)
{
    $date = Carbon::now()->format('Ymd');

    return "ORD-{$categoryId}-{$menuId}-{$date}";
}

public function createOrder($request)
{
    $menu = $this->MenuRepo->findMenu($request->menu_id);

    if (!$menu) {
    throw new \Exception("Menu tidak ditemukan");
    }

    $orderCode = $this->generateCode(
        $menu->category_id,
        $menu->id_menu
    );

    $data = [
        'user_id' => auth()->id(),
        'order_code' => $orderCode,
        'total_price' => $request->total_price,
        'status' => 'pending'
    ];

    return $this->orderRepo->createOrder($data);
}
}
