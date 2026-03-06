<?php

namespace App\Http\Controllers\Api;

use App\Handlers\OrderHandler;
use Illuminate\Http\Request;
use App\Interfaces\OrderInterface;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OrderController extends Controller
{
    protected $repository;
    protected $handler;

    public function __construct(OrderInterface $repository, OrderHandler $handler)
    {
        $this->repository = $repository;
        $this->handler = $handler;
    }

    public function index()
    {
        return response()->json($this->repository->allOrder());
    }

    public function show($id)
    {
        return response()->json($this->repository->findOrder($id));
    }

    public function store(Request $request)
{
    return response()->json(
        $this->handler->createOrder($request)
    );
}

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->repository->updateOrder($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->repository->deleteOrder($id));
    }
    public function generateOrderCode($categoryId, $menuId)
{
    $date = now()->format('Ymd');
    return "ORD-{$categoryId}-{$menuId}-{$date}";
}

   
}