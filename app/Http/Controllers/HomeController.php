<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        // 1. Ambil Produk Unggulan (Featured)
        // Pastikan Anda sudah membuat scope atau filter di model, atau query manual seperti ini:
        $featuredProducts = Product::where('is_active', true)
                            ->where('is_featured', true)
                            ->latest()
                            ->take(4)
                            ->get();

        // 2. Ambil data lain jika perlu (misal: Banner slider dari DB)
        // $banners = Banner::active()->get();

        return view('web.pages.main.home', compact('featuredProducts'));
    }
}