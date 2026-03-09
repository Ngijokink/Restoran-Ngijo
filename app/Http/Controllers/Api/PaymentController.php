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
    if ($request->hasFile('image')) {
    $image = UploadHelper::UploadImage($request->file('image'));
} else {
    $image = null;
}

    $data = $request->all();
    $data['proof'] = $image;

    $payment = $this->repository->create($data);
    $payment->image_url = $payment  ->image
        ? asset('storage/'.$payment->image)
        : null;

    return ResponseHelpers::success($payment, 'Terimakasih');
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
