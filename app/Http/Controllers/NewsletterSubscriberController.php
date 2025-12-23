<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Newsletter\StoreNewsletterRequest;
use App\Mail\WelcomeNewsletter;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Mail;

class NewsletterSubscriberController extends Controller
{
    public function subscribe(
        StoreNewsletterRequest $request
    )
    {
        NewsletterSubscriber::create([
            'email' => $request->email,
            'is_active' => true, // Default aktif sesuai migrasi
        ]);

        try {
            Mail::to($request->email)->send(new WelcomeNewsletter());
        } catch (\Exception $e) {
            \Log::error('Gagal kirim email newsletter: ' . $e->getMessage());
        }

        // 3. Redirect Balik dengan Pesan & Anchor
        return to_route('home')
                ->with('newsletter_success', 'Thank you! You have successfully subscribed.')
                ->withFragment('newsletter'); // Scroll otomatis ke bagian bawah
    }
}