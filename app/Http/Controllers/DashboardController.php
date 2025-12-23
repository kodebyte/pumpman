<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();

        // 1. Ambil Statistik
        $totalOrders = Order::where('user_id', $user->id)->count();

        // 2. Ambil 5 Order Terakhir
        $recentOrders = Order::where('user_id', $user->id)
                        ->latest()
                        ->take(10)
                        ->get();

        return view('web.pages.user.dashboard', compact('user', 'totalOrders', 'recentOrders'));
    }
}
