<x-admin.app-layout pageTitle="Order Details">
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Order Details: #{{ $order->order_number }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Orders' => route('admin.orders.index'),
                        'Details' => '#'
                    ]" />
                </div>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('admin.orders.print.label', $order->id) }}" target="_blank" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-50 hover:text-black transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    Print Label
                </a>

                {{-- TOMBOL PRINT INVOICE --}}
                <a href="{{ route('admin.orders.print.invoice', $order->id) }}" target="_blank" class="px-4 py-2 bg-gray-800 text-white rounded-lg text-sm font-bold hover:bg-gray-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Print Invoice
                </a>
                
                 {{-- Tombol Delete di halaman detail --}}
                 <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this order?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg text-sm font-bold hover:bg-red-100 transition">
                        Delete Order
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Kiri: Detail Items --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Order Items</h3>
                            <span class="text-sm text-gray-500">{{ $order->items->count() }} Items</span>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 font-semibold text-gray-600">Product</th>
                                        <th class="px-6 py-3 font-semibold text-gray-600 text-center">Qty</th>
                                        <th class="px-6 py-3 font-semibold text-gray-600 text-right">Price</th>
                                        <th class="px-6 py-3 font-semibold text-gray-600 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-gray-900">{{ $item->product_name }}</div>
                                                @if($item->variant_name)
                                                    <div class="text-xs text-gray-500">Variant: {{ $item->variant_name }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center text-gray-600">{{ $item->qty }}</td>
                                            <td class="px-6 py-4 text-right text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 text-right font-bold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="bg-gray-50 p-6">
                            <div class="flex flex-col gap-2 md:w-1/2 ml-auto">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    <span class="font-medium">Rp {{ number_format($order->total_price - $order->tax_price - $order->shipping_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Shipping</span>
                                    <span class="font-medium">Rp {{ number_format($order->shipping_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Tax</span>
                                    <span class="font-medium">Rp {{ number_format($order->tax_price, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t border-gray-200 mt-2 pt-2 flex justify-between text-base font-black text-gray-900">
                                    <span>Grand Total</span>
                                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Order History Timeline --}}
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-6 border-b pb-2 text-sm uppercase">Order Journey</h3>
                        <div class="relative pl-8 space-y-6 before:absolute before:left-3 before:top-2 before:bottom-2 before:w-0.5 before:bg-gray-100">
                            @foreach($order->histories()->latest()->get() as $history)
                                <div class="relative">
                                    <div class="absolute -left-8 top-1 w-4 h-4 rounded-full border-2 border-white {{ $loop->first ? 'bg-indigo-600' : 'bg-gray-300' }}"></div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black uppercase tracking-tighter {{ $loop->first ? 'text-indigo-600' : 'text-gray-500' }}">
                                            {{ ucfirst($history->status) }}
                                        </span>
                                        <p class="text-sm text-gray-700">{{ $history->notes }}</p>
                                        <span class="text-[10px] text-gray-400 font-medium">
                                            {{ $history->created_at->format('d M Y, H:i') }} • By {{ $history->employee->name ?? 'System' }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Kanan: Customer Info & Status --}}
                <div class="space-y-6">
                    
                    {{-- Status Card --}}
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Order Status</h3>

                        <div class="space-y-4">
                            {{-- TRACKING NUMBER CARD --}}
                           @if($order->tracking_number)
                                <div x-data="initTrackingCard('{{ $order->tracking_number }}')" 
                                    class="bg-white rounded-xl border border-indigo-100 shadow-sm overflow-hidden mb-6 group hover:shadow-md transition-all duration-300">
                                    
                                    {{-- Header: Logo & Nama Kurir --}}
                                    <div class="px-5 pt-4 flex justify-between items-center">
                                        <div class="flex items-center gap-3">
                                            @if($order->courier && $order->courier->logo)
                                                <div class="w-10 h-10 rounded-lg overflow-hidden border border-gray-100 bg-white p-1">
                                                    <img src="{{ Storage::url($order->courier->logo) }}" alt="{{ $order->courier->name }}" class="w-full h-full object-contain">
                                                </div>
                                            @else
                                                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                                                    <i data-lucide="truck" class="w-5 h-5"></i>
                                                </div>
                                            @endif
                                            
                                            <div>
                                                <span class="text-[10px] font-black text-indigo-400 uppercase tracking-widest block">
                                                    {{ $order->courier->name ?? 'Shipping Info' }}
                                                </span>
                                                <span class="text-[10px] font-medium text-gray-400">
                                                    Updated {{ $order->updated_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Body: Nomor Resi --}}
                                    <div class="px-5 py-3">
                                        <div class="text-2xl font-mono font-black text-gray-900 tracking-wider break-all leading-tight">
                                            {{ $order->tracking_number }}
                                        </div>
                                    </div>

                                    {{-- Footer: Tombol Aksi --}}
                                    <div class="px-5 pb-5 pt-2 flex flex-col sm:flex-row gap-3">
                                        <button @click="copyResi()" 
                                                class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border transition-all duration-200 text-xs font-bold uppercase tracking-wide cursor-pointer"
                                                :class="copied 
                                                    ? 'bg-green-50 border-green-200 text-green-700' 
                                                    : 'bg-white border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600'">
                                            <i :data-lucide="copied ? 'check' : 'copy'" class="w-4 h-4"></i>
                                            <span x-text="copied ? 'Tersalin!' : 'Salin'"></span>
                                        </button>

                                        @php
                                            $trackingLink = $order->courier 
                                                ? $order->courier->getTrackingLink($order->tracking_number)
                                                : 'https://www.google.com/search?q=cek+resi+' . $order->tracking_number;
                                        @endphp

                                        <a href="{{ $trackingLink }}" target="_blank"
                                        class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-gray-50 border border-transparent text-gray-600 hover:bg-indigo-600 hover:text-white transition-all duration-200 text-xs font-bold uppercase tracking-wide">
                                            <i data-lucide="external-link" class="w-4 h-4"></i>
                                            <span>Lacak</span>
                                        </a>
                                    </div>
                                    <div class="h-1 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 opacity-80"></div>
                                </div>
                            @else
                                {{-- Empty State Resi --}}
                                <div class="bg-gray-50 rounded-xl border border-dashed border-gray-300 p-6 mb-6 text-center">
                                    <div class="inline-flex p-3 bg-white rounded-full shadow-sm mb-3">
                                        <i data-lucide="package-search" class="w-5 h-5 text-gray-400"></i>
                                    </div>
                                    <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wide">Resi Belum Tersedia</h4>
                                    <p class="text-[10px] text-gray-500 mt-1">
                                        Silakan update status pesanan untuk memasukkan resi dan memilih kurir.
                                    </p>
                                </div>
                            @endif

                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Payment Status</label>
                                <div class="mt-1">
                                    @php
                                        $payClass = match($order->payment_status) {
                                            'paid', 'settlement' => 'bg-green-100 text-green-700',
                                            'pending', 'unpaid' => 'bg-yellow-100 text-yellow-700',
                                            default => 'bg-red-100 text-red-700'
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-md text-sm font-bold {{ $payClass }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Payment Method</label>
                                <div class="mt-1">
                                    @if($order->payment_type)
                                        {{-- Tipe Utama (e.g., Bank Transfer) --}}
                                        <div class="text-sm font-bold text-gray-900 mb-1">
                                            {{ ucwords(str_replace('_', ' ', $order->payment_type)) }}
                                        </div>
                                        
                                        {{-- Detail Teknis (VA, Bank, Store) --}}
                                        @if(!empty($order->payment_info))
                                            <div class="text-xs text-gray-600 font-mono bg-gray-50 p-2 rounded border border-gray-200 inline-block w-full">
                                                
                                                {{-- Bank / E-Wallet --}}
                                                @if(isset($order->payment_info['bank']))
                                                    <div class="flex justify-between">
                                                        <span>Bank:</span> 
                                                        <span class="font-bold uppercase">{{ $order->payment_info['bank'] }}</span>
                                                    </div>
                                                @endif
                                                
                                                {{-- Virtual Account Number --}}
                                                @if(isset($order->payment_info['va_number']))
                                                    <div class="flex justify-between">
                                                        <span>VA No:</span> 
                                                        <span class="font-bold select-all">{{ $order->payment_info['va_number'] }}</span>
                                                    </div>
                                                @endif
                                                
                                                {{-- Mandiri Bill --}}
                                                @if(isset($order->payment_info['biller_code']))
                                                    <div class="flex justify-between">
                                                        <span>Biller Code:</span> 
                                                        <span class="font-bold">{{ $order->payment_info['biller_code'] }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span>Bill Key:</span> 
                                                        <span class="font-bold">{{ $order->payment_info['bill_key'] }}</span>
                                                    </div>
                                                @endif

                                                {{-- Alfamart / Indomaret --}}
                                                @if(isset($order->payment_info['store']))
                                                    <div class="flex justify-between">
                                                        <span>Store:</span> 
                                                        <span class="font-bold uppercase">{{ $order->payment_info['store'] }}</span>
                                                    </div>
                                                    @if(isset($order->payment_info['payment_code']))
                                                        <div class="flex justify-between">
                                                            <span>Pay Code:</span> 
                                                            <span class="font-bold">{{ $order->payment_info['payment_code'] }}</span>
                                                        </div>
                                                    @endif
                                                @endif

                                                {{-- Kartu Kredit --}}
                                                @if(isset($order->payment_info['masked_card']))
                                                    <div class="flex justify-between">
                                                        <span>Card:</span> 
                                                        <span class="font-bold">{{ $order->payment_info['masked_card'] }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span>Type:</span> 
                                                        <span class="uppercase">{{ $order->payment_info['card_type'] ?? '' }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-400 italic">No payment details available</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Order Status</label>
                                <div class="mt-1">
                                    <span class="font-medium text-gray-900 capitalize">{{ $order->status }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Order Date</label>
                                <div class="mt-1 text-sm text-gray-700">
                                    {{ $order->created_at->format('d F Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- 2. MANAGE ORDER FORM --}}
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Manage Order</h3>
                        
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PATCH')
                            
                            {{-- Change Status --}}
                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Change Status</label>
                                <select name="status" class="mt-1 block w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>

                            {{-- Select Courier (BARU) --}}
                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Shipping Courier</label>
                                <select name="courier_id" class="mt-1 block w-full rounded-lg border-gray-300 text-sm focus:ring-indigo-500">
                                    <option value="">-- Pilih Kurir --</option>
                                    @foreach(\App\Models\Courier::where('is_active', true)->get() as $courier)
                                        <option value="{{ $courier->id }}" {{ $order->courier_id == $courier->id ? 'selected' : '' }}>
                                            {{ $courier->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Input Resi --}}
                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Tracking Number (Resi)</label>
                                <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" 
                                    class="mt-1 block w-full rounded-lg border-gray-300 text-sm font-mono" 
                                    placeholder="e.g. JB0012345678">
                            </div>

                            {{-- Notes --}}
                            <div>
                                <label class="text-xs font-bold text-gray-500 uppercase">Notes (Internal)</label>
                                <textarea name="notes" rows="2" class="mt-1 block w-full rounded-lg border-gray-300 text-sm" placeholder="Catatan untuk history..."></textarea>
                            </div>

                            <button type="submit" class="w-full py-2 bg-indigo-600 text-white rounded-lg text-xs font-black uppercase tracking-widest hover:bg-indigo-700 transition flex justify-center items-center gap-2">
                                <i data-lucide="save" class="w-4 h-4"></i> Update Order
                            </button>
                        </form>
                    </div>

                    {{-- Customer Info --}}
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Customer Details</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="bg-gray-100 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">{{ $order->first_name }} {{ $order->last_name }}</p>
                                    <p class="text-xs text-gray-500">Customer</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="bg-gray-100 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $order->email }}</p>
                                    <p class="text-xs text-gray-500">Email</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-3">
                                <div class="bg-gray-100 p-2 rounded-full">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $order->phone }}</p>
                                    <p class="text-xs text-gray-500">Phone</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Shipping Address --}}
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Shipping Address</h3>
                        
                        <p class="text-sm text-gray-700 leading-relaxed">
                            {{ $order->address }}<br>
                            {{ $order->city_name }}, {{ $order->province_name }}<br>
                            {{ $order->postal_code }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // 1. Inisialisasi Data Alpine untuk Kartu Resi
            function initTrackingCard(resiNumber) {
                return {
                    copied: false,
                    
                    copyResi() {
                        // Cek ketersediaan Clipboard API (Secure Context / HTTPS)
                        if (navigator.clipboard && window.isSecureContext) {
                            navigator.clipboard.writeText(resiNumber).then(() => {
                                this.triggerFeedback();
                            });
                        } else {
                            // Fallback untuk HTTP (Non-Secure) agar tidak error "undefined"
                            this.fallbackCopyText(resiNumber);
                        }
                    },

                    fallbackCopyText(text) {
                        let textArea = document.createElement("textarea");
                        textArea.value = text;
                        
                        // Sembunyikan textarea agar tidak merusak tampilan
                        textArea.style.top = "0";
                        textArea.style.left = "0";
                        textArea.style.position = "fixed";

                        document.body.appendChild(textArea);
                        textArea.focus();
                        textArea.select();

                        try {
                            let successful = document.execCommand('copy');
                            if(successful) this.triggerFeedback();
                        } catch (err) {
                            console.error('Gagal menyalin teks', err);
                        }

                        document.body.removeChild(textArea);
                    },

                    triggerFeedback() {
                        this.copied = true;
                        
                        // Refresh ikon Lucide agar ikon 'check' muncul
                        this.$nextTick(() => {
                            lucide.createIcons();
                        });

                        setTimeout(() => {
                            this.copied = false;
                            // Refresh ikon Lucide agar ikon 'copy' kembali
                            this.$nextTick(() => {
                                lucide.createIcons();
                            });
                        }, 2000);
                    }
                }
            }
        </script>
    @endpush

</x-admin.app-layout>