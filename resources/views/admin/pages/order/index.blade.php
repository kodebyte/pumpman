<x-admin.app-layout pageTitle="Orders">

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Orders
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Orders' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                {{-- Filter & Search Section --}}
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.orders.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">

                        {{-- Search --}}
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                   placeholder="Search Order ID, Name, or Email...">
                        </div>

                        {{-- Filter Status --}}
                        <div class="w-full md:w-40">
                            <select name="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>

                        {{-- Filter Payment --}}
                        <div class="w-full md:w-40">
                            <select name="payment_status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Payment</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>

                        @if(request()->hasAny(['search', 'status', 'payment_status', 'sort']))
                            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <x-admin.th-sortable name="order_number" label="Order ID" />
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                                <x-admin.th-sortable name="total_price" label="Total" />
                                <x-admin.th-sortable name="payment_status" label="Payment" />
                                <x-admin.th-sortable name="status" label="Status" />
                                <x-admin.th-sortable name="created_at" label="Date" />
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($orders as $order)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">
                                            #{{ $order->order_number }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $order->first_name }} {{ $order->last_name }}
                                        </div>
                                        <div class="text-xs text-gray-500">{{ $order->email }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            {{-- Status Badge --}}
                                            @php
                                                $payColor = match($order->payment_status) {
                                                    'paid', 'settlement' => 'bg-green-100 text-green-800 border-green-200',
                                                    'unpaid', 'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                    'failed', 'expire', 'deny' => 'bg-red-100 text-red-800 border-red-200',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $payColor }} w-max mb-1">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>

                                            {{-- Tampilkan Jenis Pembayaran --}}
                                            @if($order->payment_type)
                                                <span class="text-xs text-gray-500 font-mono">
                                                    {{-- Ubah format "bank_transfer" jadi "Bank Transfer" --}}
                                                    {{ ucwords(str_replace('_', ' ', $order->payment_type)) }}
                                                    
                                                    {{-- Tampilkan Nama Bank jika ada --}}
                                                    @if(isset($order->payment_info['bank']))
                                                        <span class="font-bold text-gray-700">- {{ strtoupper($order->payment_info['bank']) }}</span>
                                                    @endif
                                                    
                                                    @if(isset($order->payment_info['store']))
                                                        <span class="font-bold text-gray-700">- {{ strtoupper($order->payment_info['store']) }}</span>
                                                    @endif
                                                </span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $statusColor = match($order->status) {
                                                'completed' => 'text-green-600',
                                                'processing' => 'text-blue-600',
                                                'pending' => 'text-yellow-600',
                                                'cancelled' => 'text-red-600',
                                                default => 'text-gray-500'
                                            };
                                        @endphp
                                        <span class="text-sm font-bold {{ $statusColor }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $order->created_at->format('d M Y, H:i') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            {{-- Tombol Detail --}}
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="p-2 text-gray-500 hover:text-indigo-600 bg-gray-50 hover:bg-indigo-50 rounded-lg transition" title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="7" message="No orders found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($orders->hasPages() || $orders->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex-1 flex justify-start">
                            {{ $orders->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</x-admin.app-layout>