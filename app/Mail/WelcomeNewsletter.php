<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Welcome to Aiwa Inner Circle',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.web.welcome-newsletter', // Arahkan ke file blade tadi
        );
    }
}