<?php
namespace App\Http\Controllers\Api;
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
        $data = $request->validated();
        return response()->json($this->repository->addToCart($data));
    }

    public function viewCart($userId)
    {
        return response()->json($this->repository->getCartByUser($userId));
    }

    public function updateCartItem(CartRequest $request, $itemId)
    {
        $data = $request->validated();
        return response()->json($this->repository->updateQty($itemId, $data));
    }

    public function removeCartItem($itemId)
    {
        return response()->json($this->repository->deleteItem($itemId));
    }

    public function checkout(CartRequest $request, $userId)
    {
        $data = $request->validated();
        return response()->json($this->repository->checkout($userId));
    }
}