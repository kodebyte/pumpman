<?php

namespace App\Providers;

use App\Contracts\ContactMessageRepositoryInterface;
use App\Models\Category;
use App\Models\Marketplace;
use App\Models\Order;
use App\Models\Product;
use App\Models\WarrantyClaim;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('categories')) {
            View::composer('web.layouts.partials.navbar', function ($view) {
                $categories = Category::active()
                                ->take(8)
                                ->get();

                $view->with('menuCategories',  $categories);
            });
        }

        if (Schema::hasTable('products')) {
            $newArrivalProduct = Product::where('is_active', true)
                                    ->latest() // Order by created_at desc
                                    ->first();

            View::share('newArrivalProduct', $newArrivalProduct);

            // 3. Share BEST SELLER (Ambil 1 produk aktif secara acak atau berdasarkan flag is_featured)
            // Opsi A: Acak
            $bestSellerProduct = Product::where('is_active', true)
                                    ->inRandomOrder()
                                    ->first();
                                    
            View::share('bestSellerProduct', $bestSellerProduct);
        }

        if (Schema::hasTable('marketplaces')) {
            $footerMarketplaces = Marketplace::where('is_active', true)
                                    ->orderBy('order', 'asc')
                                    ->get();
                                    
            View::share('footerMarketplaces', $footerMarketplaces);
        }

        View::composer([
            'admin.partials.sidebar',   // Jika pakai @include('admin.partials.sidebar')
            'components.admin.sidebar', // Jika pakai component <x-admin.sidebar>
            'layouts.admin',            // Jika sidebar ada langsung di layout
            'admin.layouts.*'           // Wildcard untuk layout admin
        ], function ($view) {
            // 1. Hitung Order Baru
            // Hapus filter 'paid' agar order COD atau Transfer (Unpaid) tetap muncul notifikasinya
            $newOrdersCount = Cache::remember('new_orders_count', 600, function () {
                if (!Schema::hasTable('orders')) return 0;

                return Order::whereIn('status', ['pending', 'processing'])
                            // Opsi A: Tampilkan semua order aktif (Hapus where payment_status)
                            // Opsi B: Tampilkan Unpaid & Paid
                            ->whereIn('payment_status', ['unpaid', 'pending', 'paid', 'settlement']) 
                            ->count();
            });

            // 2. Hitung Klaim Garansi
            $pendingWarrantyCount = Cache::remember('pending_warranty_count', 600, function () {
                return Schema::hasTable('warranty_claims') 
                    ? WarrantyClaim::where('status', 'pending')->count() 
                    : 0;
            });

            $view->with([
                'newOrdersCount' => $newOrdersCount,
                'pendingWarrantyCount' => $pendingWarrantyCount
            ]);
        });

        if (Schema::hasTable('contact_messages')) {
            view()->composer('components.admin.sidebar', function ($view) {
                $view->with('unreadMessagesCount', app(ContactMessageRepositoryInterface::class)->getUnreadCount());
            });
        }
        
        
        // $proxyHost = Request::header('X-Forwarded-Host') ?? Request::header('X-Original-Host');
        // if ($proxyHost && str_contains($proxyHost, 'ngrok')) {
        //     URL::forceRootUrl("https://{$proxyHost}");
        //     URL::forceScheme('https');
        // }
    }
}
