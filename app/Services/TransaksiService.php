<?php 

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Exception;
class TransaksiService
{
    public function createTransaction($orderId, $total, $method)
    {
        return DB::transaction(function () use ($orderId, $total, $method) {
            $order = Order::findOrFail($orderId);
            if ($order->status !== 'pending') {
                throw new Exception("Order tidak dalam status pending");
            }
            $order->update(['status' => 'paid']);
            $transaction = Transaction::create([
                'order_id' => $orderId,
                'total' => $total,
                'method' => $method,
                'status' => 'paid',
                'paid_at' => now()
            ]);
            return $transaction;
        });
    }
    public function cancelTransaction($transactionId)
    {
       
        return DB::transaction(function () use ($transactionId) {
            $transaction = Transaction::findOrFail($transactionId);
            $order = $transaction->order;

            if ($order->status !== 'paid') {
                throw new Exception('Hanya transaksi paid yang bisa dibatalkan');
            }

            // Update status order
            $order->update(['status' => 'pending']);

            $transaction->update(['status' => 'cancelled']);

            return true;
        });
    }
}
