<?php

namespace App\Handlers;

use App\Repositories\OrderRepo;
use Illuminate\Http\Request;

class OrderHandler
{
    protected $orderRepo;

    public function __construct(OrderRepo $orderRepo)
    {
        $this->orderRepo = $orderRepo;
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
}
