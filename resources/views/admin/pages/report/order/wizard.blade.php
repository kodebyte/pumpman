<x-admin.app-layout pageTitle="Order Report">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Order Report
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Orders' => route('admin.orders.index'),
                        'Report' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            {{-- Menggunakan Grid yang sama dengan Create Category (2:1) --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- SISI KIRI: HASIL LAPORAN (Main Content) --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden">
                        {{-- Header Card dengan Icon --}}
                        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-9 10H4a2 2 0 01-2-2V4a2 2 0 012-2h16a2 2 0 012 2v12a2 2 0 01-2 2h-4m-7 0a2 2 0 01-2-2v-4a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2z"/>
                                </svg>
                                <h3 class="font-bold text-gray-700">Report Preview</h3>
                            </div>
                            @if(request('start_date') && $orders->count() > 0)
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full border border-indigo-100">
                                    {{ $orders->count() }} Orders Found
                                </span>
                            @endif
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 font-bold text-gray-600 uppercase tracking-wider text-xs">Order ID</th>
                                        <th class="px-6 py-4 font-bold text-gray-600 uppercase tracking-wider text-xs">Customer</th>
                                        <th class="px-6 py-4 font-bold text-gray-600 uppercase tracking-wider text-xs">Total</th>
                                        <th class="px-6 py-4 font-bold text-gray-600 uppercase tracking-wider text-xs">Status</th>
                                        <th class="px-6 py-4 font-bold text-gray-600 uppercase tracking-wider text-xs text-right">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @if(request('start_date'))
                                        @forelse($orders as $order)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4 font-mono font-bold text-indigo-600">#{{ $order->order_number }}</td>
                                                <td class="px-6 py-4">
                                                    <div class="font-bold text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $order->email }}</div>
                                                </td>
                                                <td class="px-6 py-4 font-bold text-gray-900">
                                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    @php
                                                        $statusClass = match($order->payment_status) {
                                                            'paid' => 'bg-green-100 text-green-700',
                                                            'unpaid' => 'bg-yellow-100 text-yellow-700',
                                                            default => 'bg-red-100 text-red-700'
                                                        };
                                                    @endphp
                                                    <span class="px-2 py-1 rounded text-[10px] font-black uppercase {{ $statusClass }}">
                                                        {{ $order->payment_status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-right text-gray-500">
                                                    {{ $order->created_at->format('d M Y') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="p-12 text-center">
                                                    <div class="flex flex-col items-center">
                                                        <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                                        <span class="text-gray-400 font-medium">No orders found for the selected period.</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="5" class="p-12 text-center text-gray-400">
                                                Please select a date range and click "Filter" to generate report.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- SISI KANAN: FILTER & SETTINGS (Sidebar Control) --}}
                <div class="space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                        <div class="flex items-center gap-2 mb-4 border-b pb-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                            </svg>
                            <h3 class="font-bold text-gray-700">Report Settings</h3>
                        </div>

                        <form action="{{ route('admin.orders.report.index') }}" method="GET" class="space-y-4">
                            <div>
                                <x-admin.input-label value="Start Date" />
                                <x-admin.text-input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full mt-1" required />
                            </div>

                            <div>
                                <x-admin.input-label value="End Date" />
                                <x-admin.text-input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full mt-1" required />
                            </div>

                            <div>
                                <x-admin.input-label value="Status Filter" />
                                <select name="status" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                    <option value="">All Status</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                </select>
                            </div>

                            <div class="pt-4 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-indigo-600 hover:bg-indigo-700 w-full">
                                    Generate Report
                                </x-admin.primary-button>
                                
                                {{-- Tombol Export Muncul jika hasil filter ada --}}
                                @if(request('start_date') && $orders->count() > 0)
                                    <a href="{{ route('admin.orders.report.export', request()->all()) }}" 
                                       class="inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Export to Excel
                                    </a>
                                @endif

                                <a href="{{ route('admin.orders.report.index') }}" class="text-center text-xs text-gray-500 hover:text-gray-900 underline">Reset Filter</a>
                            </div>
                        </form>
                    </div>

                    {{-- Informasi Tambahan (Opsional) --}}
                    <div class="bg-indigo-600 rounded-xl p-6 text-white shadow-lg shadow-indigo-200">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-indigo-500 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <h4 class="font-bold">Tips Laporan</h4>
                        </div>
                        <p class="text-xs text-indigo-100 leading-relaxed">
                            Gunakan rentang tanggal yang spesifik untuk mendapatkan data yang lebih akurat. Laporan ini mencakup semua detail pembayaran dan status pengiriman.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</x-admin.app-layout>