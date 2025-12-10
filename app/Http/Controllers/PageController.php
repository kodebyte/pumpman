<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Store; // Asumsi kita akan pakai ini untuk 'Find Store'
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('front.pages.about');
    }

    public function contact()
    {
        return view('front.pages.contact');
    }

    public function support()
    {
        // Bisa diarahkan ke FAQ atau halaman support umum
        return view('front.pages.support');
    }

    public function warranty()
    {
        // Halaman penjelasan E-Warranty
        return view('front.pages.warranty');
    }

    public function storeLocator()
    {
        // Contoh jika nanti mau ambil data toko dari DB
        // $stores = Store::all();
        return view('front.pages.store-locator');
    }
}