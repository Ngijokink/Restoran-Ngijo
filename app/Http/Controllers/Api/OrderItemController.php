<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelpers;
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
        try {

            $data = $this->repository->allOrderItem();

            return ResponseHelpers::success($data, 'Data Order Item');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal mengambil order item : ' . $e->getMessage());

        }
    }

    public function show($id)
    {
        try {

            $data = $this->repository->findOrderItem($id);

            return ResponseHelpers::success($data, 'Detail Order Item');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal menampilkan order item : ' . $e->getMessage());

        }
    }

    public function store(Request $request)
    {
        try {

            $data = $request->all();
            $orderItem = $this->repository->createOrderItem($data);

            return ResponseHelpers::success($orderItem, 'Berhasil membuat order item');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal membuat order item : ' . $e->getMessage());

        }
    }

    public function update(Request $request, $id)
    {
        try {

            $data = $request->all();
            $orderItem = $this->repository->updateOrderItem($id, $data);

            return ResponseHelpers::success($orderItem, 'Berhasil mengupdate order item');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal update order item : ' . $e->getMessage());

        }
    }

    public function destroy($id)
    {
        try {

            $data = $this->repository->deleteOrderItem($id);

            return ResponseHelpers::success($data, 'Berhasil menghapus order item');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal menghapus order item : ' . $e->getMessage());

        }
    }
}