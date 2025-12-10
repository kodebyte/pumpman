<?php

use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

// 2. Static Pages (PageController)
Route::controller(PageController::class)->group(function () {
    Route::get('/about-us', 'about')->name('pages.about');
    Route::get('/contact-us', 'contact')->name('pages.contact');
    Route::get('/support', 'support')->name('pages.support');
    Route::get('/e-warranty-info', 'warranty')->name('pages.warranty'); // Halaman info, bukan form klaim
    Route::get('/find-store', 'storeLocator')->name('pages.store');
});

require __DIR__.'/admin.php';

require __DIR__.'/auth.php';
