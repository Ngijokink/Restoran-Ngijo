<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\PaymentInterface;
use App\Http\Requests\PaymentRequest;
use App\Helpers\UploadHelper;
use App\Helpers\ResponseHelpers;

class PaymentController extends Controller
{
    protected $repository;

    public function __construct(PaymentInterface $repository)
    {
        $this->repository = $repository;
    }

    public function store(PaymentRequest $request)
    {
        try {

            $data = $request->validated();

            if ($request->hasFile('image')) {
                $data['proof'] = UploadHelper::UploadImage($request->file('image'));
            } else {
                $data['proof'] = null;
            }

            $payment = $this->repository->create($data);

            $payment->image_url = $payment->proof
                ? asset('storage/' . $payment->proof)
                : null;

            return ResponseHelpers::success($payment, 'Terimakasih, pembayaran berhasil dikirim');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal melakukan pembayaran : ' . $e->getMessage());

        }
    }

    public function showByOrderId($id)
    {
        try {

            $payment = $this->repository->findByOrderId($id);

            return ResponseHelpers::success($payment, 'Data pembayaran');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal mengambil data pembayaran : ' . $e->getMessage());

        }
    }

    public function updateStatus($paymentId, $status)
    {
        try {

            $payment = $this->repository->updateStatus($paymentId, $status);

            return ResponseHelpers::success($payment, 'Status pembayaran berhasil diupdate');

        } catch (\Exception $e) {

            return ResponseHelpers::error(null, 'Gagal update status pembayaran : ' . $e->getMessage());

        }
    }
}