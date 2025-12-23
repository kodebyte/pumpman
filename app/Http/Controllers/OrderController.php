<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua order milik user yang sedang login, urutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
                    ->latest()
                    ->paginate(10); // 10 Order per halaman

        return view('web.pages.user.order.index', compact('orders'));
    }

    public function show($id)
    {
        /** * 1. Ambil data order beserta relasinya:
         * - items: daftar produk yang dibeli
         * - courier: informasi pengiriman
         * - histories: (jika Anda memiliki tabel history tracking)
         */
        $order = Order::with(['items.product', 'courier', 'histories'])
            ->where('user_id', Auth::id()) // Pastikan user hanya bisa melihat pesanan miliknya sendiri
            ->findOrFail($id);

        /** * 2. Return ke view detail pesanan (view.blade.php)
         * Variabel $order akan berisi informasi lengkap seperti:
         * order_number, status, total_price, city_name, dll
         */
        return view('web.pages.user.order.view', compact('order'));
    }

    public function invoice(
        Request $request, 
        Order $order
    )
    {
        $isOwner = Auth::check() && Auth::id() === $order->user_id;

        // 2. URL memiliki Signature yang valid (Untuk link dari Email Guest)
        $isValidSignature = $request->hasValidSignature();

        // 3. (Opsional) User baru saja checkout (Session masih nyantol)
        // Ini berguna agar Guest bisa langsung lihat invoice setelah bayar tanpa cek email dulu
        $isJustCheckout = session('last_order_id') == $order->id;

        // JIKA TIDAK MEMENUHI SEMUANYA -> TENDANG
        if (! $isOwner && ! $isValidSignature && ! $isJustCheckout) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        // --- Logic Render View (Sama untuk Guest maupun Member) ---
        return view('web.pages.user.order.invoice', compact('order'));
    }

    // app/Http/Controllers/Web/TrackingController.php
    public function tracking(Request $request)
    {
        $orderNumber = $request->query('order_number');
        $order = null;

        if ($orderNumber) {
            // Gunakan eager loading agar timeline history & kurir langsung muncul
            $order = Order::with(['histories.employee', 'courier', 'items'])
                        ->where('order_number', $orderNumber)
                        ->first();

            if (!$order) {
                return back()->with('error', 'Maaf, nomor pesanan tidak ditemukan. Periksa kembali penulisan Anda.');
            }
        }

        return view('web.pages.user.order.tracking', compact('order'));
    }
}
