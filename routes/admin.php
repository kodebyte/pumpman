<?php

use App\Http\Controllers\Admin as Admin;
use Illuminate\Support\Facades\Route;

Route::prefix('internal')->name('admin.')->group(function () {

    // Guest Area (Login Page)
    Route::middleware('guest:employee')->group(function () {
        Route::get('/', [Admin\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('/', [Admin\Auth\AuthenticatedSessionController::class, 'store']);
    });

    // Authenticated Area (Dashboard)
    Route::middleware('auth:employee')->group(function () {
        
        Route::get('/dashboard', function () {
            return view('admin.pages.app.dashboard'); 
        })->name('dashboard');

        Route::resources([
            'users' => Admin\UserController::class,
            'employees' => Admin\EmployeeController::class,
            'banners' => Admin\HeroBannerController::class,
            'categories' => Admin\CategoryController::class,
            'marketplaces' => Admin\MarketplaceController::class,
            'products' => Admin\ProductController::class,
            'posts' => Admin\PostController::class,
            'stores' => Admin\StoreController::class,
            'careers' => Admin\CareerController::class,
            'faqs' => Admin\FaqController::class,
        ]);

        Route::resource('newsletter-subscribers', Admin\NewsletterSubscriberController::class)
                ->parameters(['newsletter-subscribers' => 'newsletter_subscriber']); 

        Route::resource('warranty-claims', Admin\WarrantyClaimController::class)
                ->only(['index', 'show', 'update', 'destroy']);

        Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        Route::post('/media/upload', [Admin\MediaController::class, 'upload'])->name('media.upload');
        Route::post('logout', [Admin\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});