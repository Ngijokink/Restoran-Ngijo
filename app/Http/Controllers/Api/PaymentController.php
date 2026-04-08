<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\PaymentInterface;
use App\Http\Requests\PaymentRequest;
use App\Helpers\UploadHelper;
use App\Helpers\ResponseHelpers;
use App\Models\Cart;
use App\Models\Orders;

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

            // Validate amount against order total (for correct payment UI).
            // Payment table links to cart; cart is linked to order via `carts.id_order`.
            $cart = Cart::select(['id_order'])
                ->where('id_cart', $data['id_cart'])
                ->first();

            if (!$cart || !$cart->id_order) {
                return ResponseHelpers::error(
                    null,
                    'Cart belum checkout / order belum dibuat'
                );
            }

            $order = Orders::find($cart->id_order);
            if (!$order) {
                return ResponseHelpers::error(
                    null,
                    'Order tidak ditemukan untuk cart tersebut'
                );
            }

            $orderTotal = (int) $order->total_price;
            $requestedAmount = (int) $data['amount'];
            $change = null;

            if ($data['method'] === 'cash') {
                if ($requestedAmount < $orderTotal) {
                    return ResponseHelpers::error(
                        null,
                        'Nominal cash kurang dari total order'
                    );
                }
                $change = $requestedAmount - $orderTotal;
            } elseif ($data['method'] === 'qris') {
                if ($requestedAmount !== $orderTotal) {
                    return ResponseHelpers::error(
                        null,
                        'Nominal QRIS harus sama dengan total order'
                    );
                }
                $change = 0;
            } elseif ($data['method'] === 'transfer') {
                // Enforce "money is right" only when the transfer proof is provided
                // (because then payment will become `paid`).
                if (!empty($data['proof']) && $requestedAmount !== $orderTotal) {
                    return ResponseHelpers::error(
                        null,
                        'Nominal transfer harus sama dengan total order'
                    );
                }
            }

            // PaymentRequest doesn't provide `status`, so we infer it.
            // - cash/qris is paid immediately
            // - transfer is paid if `paid_at` OR `proof` is provided
            $now = now();
            if (!empty($data['paid_at'])) {
                $data['status'] = 'paid';
            } elseif (in_array($data['method'], ['cash', 'qris'], true)) {
                $data['status'] = 'paid';
                $data['paid_at'] = $data['paid_at'] ?? $now;
            } elseif (($data['method'] ?? null) === 'transfer' && !empty($data['proof'])) {
                $data['status'] = 'paid';
                $data['paid_at'] = $data['paid_at'] ?? $now;
            } else {
                $data['status'] = 'pending';
            }

            $payment = $this->repository->create($data);

            $payment->proof_url = $payment->proof
                ? asset('storage/' . $payment->proof)
                : null;

            // When payment is paid, mark the related order as confirmed.
            if ($payment && $payment->status === 'paid') {
                $order->update(['status' => 'confirmed']);
            }

            // Extra response fields for frontend.
            $payment->order_total = $orderTotal;
            if ($data['method'] === 'cash' || $data['method'] === 'qris') {
                $payment->kembalian = $change;
            }

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