<?php

namespace App\Handlers;

use App\Repositories\CrudTransaction;
use Illuminate\Http\Request;

class TransactionHandler
{
    protected $transactionRepo;

    public function __construct(CrudTransaction $transactionRepo)
    {
        $this->transactionRepo = $transactionRepo;
    }

    public function createTransaction(Request $request)
    {
        $data = $request->only(['order_id', 'total', 'method', 'status', 'paid_at']);
        return $this->transactionRepo->createTransaction($data);
    }

    public function getAllTransactions()
    {
        return $this->transactionRepo->allTransaction();
    }

    public function getTransactionById($id)
    {
        return $this->transactionRepo->findTransaction($id);
    }

    public function updateTransaction(Request $request, $id)
    {
        $data = $request->only(['order_id', 'total', 'method', 'status', 'paid_at']);
        return $this->transactionRepo->updateTransaction($id, $data);
    }

    public function deleteTransaction($id)
    {
        return $this->transactionRepo->deleteTransaction($id);
    }
}