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
        Route::get('/report/orders', [Admin\OrderReportController::class, 'index'])->name('orders.report.index');
        Route::get('/report/orders/export', [Admin\OrderReportController::class, 'export'])->name('orders.report.export');

        Route::get('/dashboard', Admin\DashboardController::class)->name('dashboard');

        Route::resource('/newsletter-subscribers', Admin\NewsletterSubscriberController::class)
                ->parameters(['newsletter-subscribers' => 'newsletter_subscriber']); 

        Route::resource('/warranty-claims', Admin\WarrantyClaimController::class)
                ->only(['index', 'show', 'update', 'destroy']);

        Route::get('/orders/{order}/print/invoice', [Admin\OrderController::class, 'printInvoice'])->name('orders.print.invoice');
        Route::get('/orders/{order}/print/label', [Admin\OrderController::class, 'printLabel'])->name('orders.print.label');
        Route::patch('/orders/update-status/{order}', [Admin\OrderController::class, 'updateStatus'])->name('orders.update-status');

        Route::get('/settings', [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');

        Route::post('/media/upload', [Admin\MediaController::class, 'upload'])->name('media.upload');
        Route::post('/logout', [Admin\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::controller(Admin\ProductHighlightController::class)->group(function () {
            Route::get('/product-highlights', 'index')->name('product-highlights.index');
            Route::put('/product-highlights', 'update')->name('product-highlights.update');
        });

        Route::controller(Admin\ContactMessageController::class)->group(function () {
            Route::get('/contacts', 'index')->name('contacts.index');
            Route::get('/contacts/{id}', 'show')->name('contacts.show');
            Route::delete('/contacts/{id}', 'destroy')->name('contacts.destroy');
        });

        Route::controller(Admin\SeoSettingController::class)->group(function () {
            Route::get('/seo', 'index')->name('seo.index');
            Route::get('/seo/{id}/edit', 'edit')->name('seo.edit');
            Route::put('/seo/{id}', 'update')->name('seo.update');
        });

        Route::resources([
            'users' => Admin\UserController::class,
            'employees' => Admin\EmployeeController::class,
            'banners' => Admin\HeroBannerController::class,
            'categories' => Admin\CategoryController::class,
            'marketplaces' => Admin\MarketplaceController::class,
            'products' => Admin\ProductController::class,
            'posts' => Admin\PostController::class,
            'post-types' => Admin\PostTypeController::class,
            'stores' => Admin\StoreController::class,
            'careers' => Admin\CareerController::class,
            'faqs' => Admin\FaqController::class,
            'orders' => Admin\OrderController::class,
            'couriers' => Admin\CourierController::class,
            'clients' => Admin\ClientController::class,
            'whatsapp' => Admin\WhatsappContactController::class,
        ]);
    });
});