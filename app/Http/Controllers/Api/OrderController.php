<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Interfaces\OrderInterface;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    protected $repository;

    public function __construct(OrderInterface $repository)
    {
        $this->repository = $repository;
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
        $data = $request->all();
        return response()->json($this->repository->createOrder($data));
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
}