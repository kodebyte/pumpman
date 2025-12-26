<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SetLocale::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {
            
            // 1. Cek apakah URL yang diakses adalah halaman Admin/Internal
            if ($request->is('internal/*') || $request->is('internal')) {
                return route('admin.login');
            }

            // 2. Default redirect ke login Customer
            return route('login');
        });

        $middleware->validateCsrfTokens(except: [
            'payment/notification', // URL yang akan kita buat nanti
        ]);

        // $middleware->trustProxies(at: '*');
    })
    ->withSchedule(function (Schedule $schedule) {
        // --- DAFTARKAN SCHEDULE DI SINI ---
        // Jalankan perintah generate sitemap setiap hari
        $schedule->command('sitemap:generate')->daily();
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
