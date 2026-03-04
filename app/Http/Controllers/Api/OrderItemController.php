<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Interfaces\OrderItemInterface;
use App\Http\Controllers\Controller;

class OrderItemController extends Controller
{
    protected $repository;

    public function __construct(OrderItemInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->allOrderItem());
    }

    public function show($id)
    {
        return response()->json($this->repository->findOrderItem($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->repository->createOrderItem($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->repository->updateOrderItem($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->repository->deleteOrderItem($id));
    }
}