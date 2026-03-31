<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\CartInterface;
use App\Http\Requests\CartRequest;

class CartController extends Controller
{
    protected $repository;

    public function __construct(CartInterface $repository)
    {
        $this->repository = $repository;
    }

    public function addToCart(CartRequest $request)
    {
        try {

            $data = $request->validated();
            $result = $this->repository->addToCart($data);

            return ResponseHelpers::success($result, 'Data cart berhasil ditambahkan');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal Add To Cart : ' . $e->getMessage());

        }
    }

    public function viewCart($userId)
    {
        try {

            $data = $this->repository->getCartById($userId);

            return ResponseHelpers::success($data, 'Menampilkan data cart');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal menampilkan cart : ' . $e->getMessage());

        }
    }

    public function updateCartItem(CartRequest $request, $itemId)
    {
        try {

            $data = $request->validated();
            $result = $this->repository->updateQty($itemId, $data);

            return ResponseHelpers::success($result, 'Cart berhasil di update');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal update cart : ' . $e->getMessage());

        }
    }

    public function removeCartItem($itemId)
    {
        try {

            $data = $this->repository->deleteItem($itemId);

            return ResponseHelpers::success($data, 'Item berhasil dihapus dari cart');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal hapus item cart : ' . $e->getMessage());

        }
    }

    public function checkout($userId)
    {
        try {

            $data = $this->repository->checkout($userId);

            return ResponseHelpers::success($data, 'Checkout berhasil');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal checkout : ' . $e->getMessage());

        }
    }
}