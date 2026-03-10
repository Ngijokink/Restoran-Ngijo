<?php

namespace App\Repositories;

use App\Interfaces\ReportInterface;
use App\Models\Orders;
use App\Models\Transaction;

class ReportRepo implements ReportInterface{
    public function allReports(string $date)
    {
        return Orders::whereDate('created_at', $date)->get();
    }

    public function findByDate(string $date)
    {
        return Orders::whereDate('created_at', $date)->first();
    }

    public function createReport(array $data)
    {
        // di sini kita otomatis generate dari DB jika $data kosong
        $date = $data['report_date'] ?? now()->format('Y-m-d');

        // order stats
        $orders = Orders::whereDate('created_at', $date)->get();
        $totalOrders = $orders->count();
        $totalOrderRevenue = $orders->sum('total_amount');
        $orderStatusBreakdown = [
            'PAID' => $orders->where('status', 'PAID')->count(),
            'PENDING' => $orders->where('status', 'PENDING')->count(),
            'CANCELLED' => $orders->where('status', 'CANCELLED')->count(),
        ];

        // transaction stats
        $transactions = Transaction::whereDate('created_at', $date)->get();
        $totalTransactions = $transactions->count();
        $totalSuccessAmount = $transactions->where('status', 'SUCCESS')->sum('amount');
        // ignore transactions without a payment method
        $totalPerMethod = $transactions
            ->whereNotNull('payment_method')
            ->filter(fn($t) => trim($t->payment_method) !== '')
            ->groupBy('payment_method')
            ->map->sum('amount');

        return [
            'report_date' => $date,
            'total_orders' => $totalOrders,
            'total_order_revenue' => $totalOrderRevenue,
            'order_status_breakdown' => $orderStatusBreakdown,
            'total_transactions' => $totalTransactions,
            'total_success_amount' => $totalSuccessAmount,
            'total_per_method' => $totalPerMethod
        ];
    }

    public function getDailyOrderStats(string $date)
    {
        $orders = Orders::whereDate('created_at', $date)->get();
        return $orders->groupBy('menu_id')->map(function ($items) {
            return [
                'menu_name' => $items->first()->menu->name,
                'total_order' => $items->count(),
            ];
        })->values();
    }

    public function getDailyTransactionStats(string $date)
    {
        $transactions = Transaction::whereDate('created_at', $date)->get();
        return $transactions->groupBy('menu_id')->map(function ($items) {
            return [
                'menu_name' => $items->first()->menu->name,
                'total_transaction' => $items->sum('amount'),
            ];
        })->values();
    }
}