<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function collection()
    {
        return $this->orders;
    }

    // Header Kolom Excel
    public function headings(): array
    {
        return [
            'Order Number',
            'Date',
            'Customer Name',
            'Email',
            'Payment Status',
            'Order Status',
            'Subtotal',
            'Shipping',
            'Tax',
            'Total Amount',
            'Payment Type'
        ];
    }

    // Map data ke kolom
    public function map($order): array
    {
        return [
            $order->order_number,
            $order->created_at->format('d-m-Y H:i'),
            $order->first_name . ' ' . $order->last_name,
            $order->email,
            strtoupper($order->payment_status),
            strtoupper($order->status),
            $order->total_price - $order->tax_price - $order->shipping_price,
            $order->shipping_price,
            $order->tax_price,
            $order->total_price,
            $order->payment_type ?? '-'
        ];
    }
}