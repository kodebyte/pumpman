<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $categories = Category::active()->get();
        $products = Product::where('is_active', true)->latest()->take(10)->get();
        $careers = Career::where('is_active', true)->get();

        return view('web.pages.sitemap.index', compact('categories', 'products', 'careers'));
    }
}
