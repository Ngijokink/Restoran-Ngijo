<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Interfaces\TransactionInterface;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    protected $repository;

    public function __construct(TransactionInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return response()->json($this->repository->allTransaction());
    }

    public function show($id)
    {
        return response()->json($this->repository->findTransaction($id));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        return response()->json($this->repository->createTransaction($data));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        return response()->json($this->repository->updateTransaction($id, $data));
    }

    public function destroy($id)
    {
        return response()->json($this->repository->deleteTransaction($id));
    }
}