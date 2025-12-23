<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NewsletterSubscriberController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StoreLocatorController;
use App\Http\Controllers\WarrantyController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

Route::get('/locale/{lang}', function ($lang) {
    if (in_array($lang, ['en', 'id'])) {
        Session::put('locale', $lang);
    }
    
    return back(); // Kembali ke halaman sebelumnya
})->name('set-locale');

// jangan dipindahkan, ini digunakan untuk push notification oleh midtrans jika pembayaran berhasil di settle
Route::post('/payment/notification', [CheckoutController::class, 'callback']);

Route::get('/order/invoice/{order}', [OrderController::class, 'invoice'])
    ->name('order.invoice');

Route::get('/order-tracking', [OrderController::class, 'tracking'])
    ->name('order-tracking');

Route::get('/', HomeController::class)->name('home');
Route::get('/faqs', FaqController::class)->name('faqs.index');
Route::get('/careers', CareerController::class)->name('careers.index');
Route::get('/sitemap', SitemapController::class)->name('sitemap');
Route::get('/stores', [StoreLocatorController::class, 'index'])->name('stores.index');
Route::get('/search/recommendations', [ProductController::class, 'recommendations'])->name('search.recommendations');
Route::post('/newsletter/subscribe', [NewsletterSubscriberController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/checkout/login', function () {
    session()->put('url.intended', route('cart.checkout')); 
    return redirect()->route('login');
})->name('checkout.login');

Route::controller(LocationController::class)->group(function () {
    Route::get('/api/cities/{provinceId}', 'getCities')->name('api.cities');
    Route::get('/api/districts/{cityId}', 'getDistricts')->name('api.districts');
});

// Warranty
Route::controller(WarrantyController::class)->group(function () {
    Route::get('/warranty-claim/check', 'status')->name('warranty-claim.check'); 
    Route::get('/warranty-claim', 'claim')->name('warranty-claim'); 
    Route::get('/warranty-claim/success', 'success')->name('warranty-claim.success');
    Route::post('/warranty-claim/store', 'store')->name('warranty-claim.store'); 
});

// posts
Route::controller(PostController::class)->group(function () {
    Route::get('/posts/{postType:slug?}', 'index')->name('posts.index');
    Route::get('/post/{post:slug}', 'show')->name('posts.show');
});

// cart
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add', 'addToCart')->name('cart.add');
    
    Route::get('/cart/data', 'getCartData')->name('cart.data'); 
    Route::patch('/cart/update/{id}', 'updateQty')->name('cart.data'); 
    Route::delete('/cart/remove/{id}', 'remove')->name('cart.remove'); 

    Route::get('/checkout', 'checkout')->name('cart.checkout');
});

Route::controller(CheckoutController::class)->group(function () {
    Route::post('/checkout/process', 'process')
        ->name('checkout.process')
        ->middleware(['throttle:5,1', ProtectAgainstSpam::class]);

    Route::get('/checkout/success/{orderNumber}', 'success')
        ->middleware('signed')
        ->name('checkout.success');

    Route::get('/payment/success-final/{orderNumber}', 'paymentSuccess')
        ->name('payment.success')
        ->middleware('signed');
});

// product
Route::controller(ProductController::class)->group(function () {
    Route::get('/products/category/{category:slug}', 'index')
        ->name('products.category');

    Route::get('/products', 'index')
        ->name('products.index');

    Route::get('/products/{product:slug}', 'show')
        ->name('products.show');
});

//page
Route::controller(PageController::class)->group(function () {
    Route::get('/about-us', 'about')->name('pages.about');
    Route::get('/contact-us', 'contact')->name('pages.contact');
    Route::post('/contact-us', 'storeContact')->name('contact.store');
});

// only access for user
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::controller(OrderController::class)->group(function() {
        Route::get('/orders', 'index')->name('orders.index');
        Route::get('/order/{order}', 'show')->name('orders.show');
        Route::get('/order/{order}/invoice', 'invoice')->name('orders.invoice');
    });

    Route::controller(ProfileController::class)->group(function() {
        Route::get('/my-account', 'index')->name('account.index');
        Route::put('/my-account/profile', 'updateProfile')->name('account.update.profile');
        Route::put('/my-account/address', 'updateAddress')->name('account.update.address');
    });
});

require __DIR__.'/admin.php';

require __DIR__.'/auth.php';
