<?php

namespace App\Mail\Admin;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentReceivedNotification extends Mailable 
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        // Load relasi items agar bisa ditampilkan di tabel email
        $this->order = $order->load('items');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ [PAID] #' . $this->order->order_number . ' - Pembayaran Diterima',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin.payment-received',
        );
    }
}