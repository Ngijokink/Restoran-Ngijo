<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use App\Interfaces\TransactionInterface;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelpers;

class TransactionController extends Controller
{
    protected $repository;

    public function __construct(TransactionInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        try {

            $transactions = $this->repository->allTransaction();

            return ResponseHelpers::success(
                $transactions,
                'Data Transaction'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(
                null,
                'Gagal mengambil data transaction : '.$e->getMessage()
            );

        }
    }

    public function show($id)
    {
        try {

            $transaction = $this->repository->findTransaction($id);

            return ResponseHelpers::success(
                $transaction,
                'Detail Transaction'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(
                null,
                'Gagal menampilkan transaction : '.$e->getMessage()
            );

        }
    }

    public function store(TransactionRequest $request)
    {
        try {

            $data = $request->validated();

            $transaction = $this->repository->createTransaction($data);

            return ResponseHelpers::success(
                $transaction,
                'Transaction berhasil dibuat'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(
                null,
                'Gagal membuat transaction : '.$e->getMessage()
            );

        }
    }
}