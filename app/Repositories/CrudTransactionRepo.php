<?php

namespace App\Repositories;
use App\Models\Transaction;
use App\Interfaces\CrudTransactionInterface;
use Illuminate\Database\Eloquent\Model;

class CrudTransactionRepo implements CrudTransactionInterface
{
    protected $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function allTransaction()
    {
        return $this->model->all();
    }

    public function findTransaction($id)
    {
        return $this->model->find($id);
    }

    public function createTransaction(array $data)
    {
        return $this->model->create($data);
    }

    public function updateTransaction($id, array $data)
    {
        $record = $this->model->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
        return null;
    }

    public function deleteTransaction($id)
    {
        $record = $this->model->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }
}