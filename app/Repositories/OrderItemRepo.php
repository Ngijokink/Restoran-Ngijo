<?php

namespace App\Resources;
use App\Interfaces\OrderItemInterface;
use App\Models\Item;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemRepo extends JsonResource implements OrderItemInterface
{
    public function allOrderItem()
    {
        return Item::all();
    }

    public function findOrderItem($id)
    {
        return Item::find($id);
    }

    public function createOrderItem(array $data)
    {
        return Item::create($data);
    }

    public function updateOrderItem($id, array $data)
    {
        $item = Item::find($id);
        if ($item) {
            $item->update($data);
            return $item;
        }
        return null;
    }

    public function deleteOrderItem($id)
    {
        $item = Item::find($id);
        if ($item) {
            $item->delete();
            return true;
        }
        return false;
    }
}