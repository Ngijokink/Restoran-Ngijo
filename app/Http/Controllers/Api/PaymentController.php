<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Interfaces\PaymentInterface;
use App\Http\Requests\PaymentRequest;


class PaymentController extends Controller
{
    protected $repository;

    public function __construct(PaymentInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(PaymentRequest $request)
    {
        $data = $request->validated();
        return response()->json($this->repository->create($data));
    }

    public function showByOrderId($id)
    {
        return response()->json($this->repository->findByOrderId($id));
    }

    public function updateStatus($paymentId, $status)
    {
        return response()->json($this->repository->updateStatus($paymentId, $status));
    }
}
