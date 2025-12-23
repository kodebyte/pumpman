<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Contact\StoreContactRequest;
use App\Models\ContactMessage;
use App\Models\Setting;

class PageController extends Controller
{
    public function about()
    {
        return view('web.pages.main.about');
    }

    public function contact()
    {
        $contact = Setting::where('key', 'like', 'contact_%')
                        ->pluck('value', 'key');

        return view('web.pages.main.contact', compact('contact'));
    }

    public function storeContact(
        StoreContactRequest $request
    )
    {
        unset($request['g-recaptcha-response']);

        ContactMessage::create($request->validated());

        return back()
                ->with('success', 'Pesan Anda telah terkirim! Tim kami akan segera menghubungi Anda.');
    }

    public function warrantyClaim()
    {
        // Halaman penjelasan E-Warranty
        return view('web.pages.warranty.claim');
    }

    public function checkWarrantyClaimStatus()
    {
        // Halaman penjelasan E-Warranty
        return view('web.pages.warranty.check');
    }
}