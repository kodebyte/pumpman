<x-admin.app-layout pageTitle="Dashboard">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- 1. Total Revenue --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-50 text-indigo-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Revenue This Month</p>
                            <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                {{-- 2. Pending Orders --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-50 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Pending Orders</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $pendingOrdersCount }}</p>
                        </div>
                    </div>
                </div>

                {{-- 3. Pending Warranty Claims --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        {{-- Menggunakan warna merah (rose) untuk urgensi purnajual --}}
                        <div class="p-3 rounded-full bg-rose-50 text-rose-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Pending Warranty</p>
                            <div class="flex items-baseline gap-2">
                                <p class="text-2xl font-bold text-gray-900">{{ $pendingWarrantyClaimsCount }}</p>
                                @if($pendingWarrantyClaimsCount > 0)
                                    <span class="text-[10px] font-bold text-rose-500 animate-pulse uppercase tracking-widest">Needs Action</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. Total Customers --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-50 text-emerald-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Customers</p>
                            <p class="text-2xl font-bold text-gray-900">{{ number_format($totalCustomers) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sales Chart Section --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Monthly Revenue</h3>
                        <p class="text-xs text-gray-500">Sales performance in {{ date('Y') }}</p>
                    </div>
                    <div class="p-2 bg-gray-50 rounded-lg text-xs font-bold text-gray-600 border border-gray-100">
                        Yearly View
                    </div>
                </div>

                {{-- Canvas untuk Chart --}}
                <div class="h-80 w-full">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            {{-- Recent Transactions Table --}}
            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Recent Transactions</h3>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View All Transactions &rarr;</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-600">
                        <thead class="bg-gray-50 text-xs uppercase font-semibold text-gray-500">
                            <tr>
                                <th class="px-6 py-4">Order ID</th>
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Amount</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 font-medium text-gray-900">#{{ $order->order_number }}</td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</span>
                                        <div class="text-[10px] text-gray-400">{{ $order->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-gray-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs font-bold 
                                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ ucfirst($order->payment_status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $order->created_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">No recent transactions.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Gradien Warna untuk Line Chart agar terlihat premium
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.2)'); // Indigo-600
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Revenue (Rp)',
                        data: @json(array_values($monthlyRevenue)),
                        borderColor: '#4f46e5', // Indigo-600
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4, // Membuat garis melengkung halus
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#4f46e5',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + value.toLocaleString('id-ID');
                                },
                                font: { size: 10 }
                            },
                            grid: { borderDash: [5, 5] }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10 } }
                        }
                    }
                }
            });
        </script>
    @endpush

</x-admin.app-layout>