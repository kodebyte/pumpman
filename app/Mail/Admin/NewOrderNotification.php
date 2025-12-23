<?php

namespace App\Mail\Admin;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewOrderNotification extends Mailable 
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[NEW ORDER] #' . $this->order->order_number . ' - ' . $this->order->first_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.admin.new-order',
        );
    }
}