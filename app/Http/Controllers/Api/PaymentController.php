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

            if ($request->hasFile('proof')) {

                $data['proof'] = UploadHelper::UploadImage(
                    $request->file('proof')
                );

            }

            $payment = $this->repository->create($data);

            $payment->proof_url = $payment->proof
                ? asset('storage/' . $payment->proof)
                : null;

            return ResponseHelpers::success(
                $payment,
                'Pembayaran berhasil diproses'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(
                null,
                'Gagal melakukan pembayaran : '.$e->getMessage()
            );

        }
    }

    public function showByCartId($cartId)
    {
        try {

            $payment = $this->repository->findByCartId($cartId);

            return ResponseHelpers::success(
                $payment,
                'Data pembayaran'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(
                null,
                'Gagal mengambil data pembayaran : '.$e->getMessage()
            );

        }
    }

    public function updateStatus($paymentId, $status)
    {
        try {

            $payment = $this->repository->updateStatus(
                $paymentId,
                $status
            );

            return ResponseHelpers::success(
                $payment,
                'Status pembayaran berhasil diupdate'
            );

        } catch (\Exception $e) {

            return ResponseHelpers::error(
                null,
                'Gagal update status pembayaran : '.$e->getMessage()
            );

        }
    }
}