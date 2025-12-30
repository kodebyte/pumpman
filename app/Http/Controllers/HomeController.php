<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\HeroBanner;
use App\Models\Post;
use App\Models\Product;
use App\Models\ProductHighlight;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $banners = HeroBanner::activeAndScheduled()
                    ->orderBy('order', 'asc')
                    ->get();

        $featuredCategories = Category::Active()
                                ->featured()
                                ->sortByOrder()
                                ->take(4) // Kita butuh tepat 4 item untuk grid ini
                                ->get();

        $featuredProducts = Product::with(['category', 'images'])
                                ->where('is_active', true)
                                ->where('is_featured', true)
                                ->latest()
                                ->take(8)
                                ->get();

        $latestPosts = Post::published()
                        ->latest('published_at')
                        ->take(3)
                        ->get();

        $productHighlight = ProductHighlight::isActive()
                                ->latest()
                                ->first();

        $trustedClients = Client::active()
                                ->sortByOrder()
                                ->get();

        return view('web.pages.main.home', compact(
            'banners', 
            'featuredCategories',
            'featuredProducts', 
            'latestPosts',
            'productHighlight',
            'trustedClients'
        ));
    }
}