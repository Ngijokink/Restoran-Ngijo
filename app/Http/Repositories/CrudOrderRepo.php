<?php

namespace App\Repositories;

use App\Models\Order;
use App\Interfaces\CrudOrderInterface;
use Illuminate\Database\Eloquent\Model;
class CrudOrderRepo implements CrudOrderInterface
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function allOrder()
    {
        return $this->model->all();
    }

    public function findOrder($id)
    {
        return $this->model->find($id);
    }

    public function createOrder($data)
    {
        return $this->model->create($data);
    }

    public function updateOrder($id, $data)
    {
        $order = $this->model->find($id);
        if ($order) {
            $order->update($data);
            return $order;
        }
        return null;
    }

    public function deleteOrder($id)
    {
        $order = $this->model->find($id);
        if ($order) {
            return $order->delete();
        }
        return false;
    }
}