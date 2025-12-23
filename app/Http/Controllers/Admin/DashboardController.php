<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Order;
use App\Models\User;
use App\Models\WarrantyClaim;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $salesData = Order::where('payment_status', 'paid')
                        ->whereYear('created_at', date('Y'))
                        ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get();

        // Siapkan array untuk Chart (Januari - Desember)
        $monthlyRevenue = array_fill(1, 12, 0);
        
        foreach ($salesData as $data) {
            $monthlyRevenue[$data->month] = (float) $data->total;
        }
        
        $totalRevenue = Order::where('payment_status', 'paid')
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->sum('total_price');

        // 2. Pending Orders (Sudah bayar, status masih processing/pending)
        $pendingOrdersCount = Order::where('payment_status', 'paid')
                                ->whereIn('status', ['pending', 'processing'])
                                ->count();

        $pendingWarrantyClaimsCount = WarrantyClaim::where('status', 'pending')->count();

        // 4. Total Customers
        $totalCustomers = User::count();

        // 5. Transaksi Terbaru
        $recentOrders = Order::latest()
                            ->take(5)
                            ->get();

        return view('admin.pages.app.dashboard', compact(
            'totalRevenue', 
            'pendingOrdersCount', 
            'pendingWarrantyClaimsCount',
            'totalCustomers',
            'recentOrders',
            'monthlyRevenue'
        ));
    }
}
