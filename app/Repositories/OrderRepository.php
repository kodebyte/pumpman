<?php

namespace App\Repositories;

use App\Contracts\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct(
        protected Order $order
    ) {}

    public function getAll(array $params = [], int $perPage = 10)
    {
        $query = $this->order->newQuery();

        // Search: Order Number, Customer Name, Email
        if (!empty($params['search'])) {
            $search = $params['search'];
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhere('first_name', 'like', '%' . $search . '%')
                  ->orWhere('last_name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filter by Status (Pending, Processing, etc)
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        // Filter by Payment Status (Paid, Unpaid)
        if (!empty($params['payment_status'])) {
            $query->where('payment_status', $params['payment_status']);
        }

        // Sorting
        $sortColumn = $params['sort'] ?? 'created_at';
        $sortDirection = $params['direction'] ?? 'desc';
        
        // Whitelist kolom yang boleh disort agar aman dari SQL Injection
        $allowedSorts = [
            'order_number', 
            'created_at', 
            'total_price', 
            'status', 
            'payment_status'
        ];

        if (in_array($sortColumn, $allowedSorts)) {
            $query->orderBy($sortColumn, $sortDirection);
        } else {
            $query->latest();
        }

        return $query->cursorPaginate($perPage)->withQueryString();
    }

    public function findById(int $id)
    {
        // Eager load items agar efisien di halaman detail
        return $this->order->with(['items', 'user'])->findOrFail($id);
    }

    public function delete(int $id)
    {
        $order = $this->findById($id);
        return $order->delete();
    }

    // app/Repositories/OrderRepository.php
    public function getReportData(array $params)
    {
        $query = $this->order->newQuery();

        // Filter Rentang Tanggal (Wajib)
        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $query->whereBetween('created_at', [
                $params['start_date'] . ' 00:00:00',
                $params['end_date'] . ' 23:59:59'
            ]);
        }

        // Filter Status (Opsional)
        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (!empty($params['payment_status'])) {
            $query->where('payment_status', $params['payment_status']);
        }

        return $query->with(['items'])->latest()->get();
    }
}