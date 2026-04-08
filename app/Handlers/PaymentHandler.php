<?php
namespace App\Handlers;
use App\Interfaces\PaymentInterface;
use App\Interfaces\CartInterface;
use App\Helpers\UploadHelper;
use App\Models\Orders;

class PaymentHandler
{
    protected $paymentRepository;
    protected $cartRepository;
    protected $uploadHelper;

    public function __construct(
        PaymentInterface $paymentRepository,
        CartInterface $cartRepository,
        UploadHelper $uploadHelper
    ) {
        $this->paymentRepository = $paymentRepository;
        $this->cartRepository = $cartRepository;
        $this->uploadHelper = $uploadHelper;
    }

    public function createPayment(array $data)
    {
        // Backward compatibility: accept either `id_cart` or `cart_id`.
        if (!isset($data['id_cart']) && isset($data['cart_id'])) {
            $data['id_cart'] = $data['cart_id'];
        }

        $now = now();
        if (!empty($data['paid_at'])) {
            $data['status'] = 'paid';
        } elseif (in_array($data['method'] ?? null, ['cash', 'qris'], true)) {
            $data['status'] = 'paid';
            $data['paid_at'] = $data['paid_at'] ?? $now;
        } elseif (($data['method'] ?? null) === 'transfer' && !empty($data['proof'])) {
            $data['status'] = 'paid';
            $data['paid_at'] = $data['paid_at'] ?? $now;
        } else {
            $data['status'] = 'pending';
        }

        $payment = $this->paymentRepository->create($data);

        if ($payment && $payment->status === 'paid') {
            $cart = $this->cartRepository->getCartById((int) $payment->id_cart);

            if ($cart && $cart->id_order) {
                Orders::where('id_order', $cart->id_order)->update([
                    'status' => 'confirmed',
                ]);
            } elseif ($cart && $cart->user_id) {
                Orders::where('user_id', $cart->user_id)
                    ->orderBy('created_at', 'desc')
                    ->first()?->update(['status' => 'confirmed']);
            }
        }

        return $payment;
    }
   
}

