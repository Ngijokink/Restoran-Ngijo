<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelpers;
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
        try {

            $orders = $this->repository->allOrder();

            return ResponseHelpers::success($orders, 'Data Order');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal mengambil data order : '.$e->getMessage());

        }
    }

    public function show($id)
    {
        try {

            $order = $this->repository->findOrder($id);

            return ResponseHelpers::success($order, 'Detail Order');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal menampilkan order : '.$e->getMessage());

        }
    }

    public function store(Request $request)
    {
        try {

            $order = $this->handler->createOrder($request);

            return ResponseHelpers::success($order, 'Berhasil membuat order');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal membuat order : '.$e->getMessage());

        }
    }

    public function update(Request $request, $id)
    {
        try {

            $data = $request->all();
            $order = $this->repository->updateOrder($id, $data);

            return ResponseHelpers::success($order, 'Berhasil mengupdate order');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal update order : '.$e->getMessage());

        }
    }

    public function destroy($id)
    {
        try {

            $order = $this->repository->deleteOrder($id);

            return ResponseHelpers::success($order, 'Berhasil menghapus order');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal menghapus order : '.$e->getMessage());

        }
    }

    public function generateOrderCode($categoryId, $menuId)
    {
        try {

            $date = now()->format('Ymd');
            $code = "ORD-{$categoryId}-{$menuId}-{$date}";

            return ResponseHelpers::success(
                ['order_code' => $code],
                'Generate Order Code'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal generate order code : '.$e->getMessage());

        }
    }
}