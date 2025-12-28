<x-web.main-layout>

    <div class="pt-14 pb-12 flex flex-col items-center justify-center bg-brand-gray min-h-screen px-4">
        
        {{-- SUCCESS CARD --}}
        <div class="w-full max-w-2xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-200/60 relative">
            
            {{-- Header Hijau --}}
            <div class="bg-brand-primary p-10 text-center relative overflow-hidden">
                {{-- Pattern --}}
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                
                <div class="relative z-10">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner ring-4 ring-white/10 animate-bounce-slow">
                        <i data-lucide="check" class="w-10 h-10 text-white"></i>
                    </div>
                    <h1 class="text-3xl font-black text-white uppercase tracking-tight mb-2">{{ __('Order Created!') }}</h1>
                    <p class="text-white/90 text-sm font-medium">{{ __('Thank you for your order. We have received your request.') }}</p>
                </div>
            </div>

            <div class="p-8 md:p-12 text-center">
                
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">{{ __('Your Order ID') }}</p>
                <div class="inline-block bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl px-8 py-4 mb-8">
                    <span class="text-3xl md:text-4xl font-black text-slate-900 tracking-wider">{{ $order->order_number }}</span>
                </div>

                {{-- Order Info Summary --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left mb-8">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">{{ __('Recipient') }}</span>
                        <span class="text-sm font-bold text-slate-900 block truncate">{{ $order->first_name }} {{ $order->last_name }}</span>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">{{ __('Total Payment') }}</span>
                        <span class="text-sm font-black text-brand-primary block">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

                {{-- Pay Button --}}
                <button id="pay-button" class="w-full bg-brand-dark text-white py-4 rounded-xl font-bold uppercase tracking-widest hover:bg-brand-primary transition-all shadow-lg transform hover:-translate-y-1 flex items-center justify-center gap-2 mb-8 group">
                    <i data-lucide="credit-card" class="w-5 h-5 group-hover:scale-110 transition"></i>
                    {{ __('Pay Now') }}
                </button>

                {{-- Collapsible Details --}}
                <div x-data="{ open: false }" class="border-t border-gray-100 pt-6">
                    <button @click="open = !open" class="flex items-center justify-center gap-2 w-full text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-brand-primary transition focus:outline-none group">
                        <span x-text="open ? '{{ __('Hide Order Details') }}' : '{{ __('Show Order Details') }}'"></span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-300" :class="open ? 'rotate-180 text-brand-primary' : 'text-slate-300 group-hover:text-brand-primary'"></i>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 -translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-cloak
                         class="mt-6 text-left space-y-4 bg-white rounded-xl border border-gray-100 p-4 shadow-sm">
                        
                        <div class="space-y-4 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($order->items as $item)
                                <div class="flex gap-4 items-start">
                                    <div class="w-12 h-12 bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0 flex items-center justify-center overflow-hidden p-1">
                                        @if($item->product && $item->product->images->first())
                                             <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" class="w-full h-full object-contain mix-blend-multiply">
                                        @else
                                             <i data-lucide="image" class="w-4 h-4 text-gray-300"></i>
                                        @endif
                                    </div>

                                    <div class="flex-1">
                                        <p class="text-sm font-bold text-slate-900 line-clamp-2 leading-tight">{{ $item->product_name }}</p>
                                        @if($item->variant_name)
                                            <p class="text-[10px] text-slate-500 uppercase font-bold mt-1 bg-gray-100 inline-block px-1.5 rounded">{{ $item->variant_name }}</p>
                                        @endif
                                        <p class="text-xs text-slate-400 mt-1 font-medium">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3 text-xs space-y-2 border border-gray-100">
                            <div class="flex justify-between text-slate-500 font-medium">
                                <span>{{ __('Shipping Fee') }}</span>
                                <span>Rp {{ number_format($order->shipping_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-slate-500 font-medium">
                                <span>{{ __('Tax') }}</span>
                                <span>Rp {{ number_format($order->tax_price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-400 hover:text-brand-primary transition uppercase tracking-widest group">
                        <i data-lucide="arrow-left" class="w-3 h-3 group-hover:-translate-x-1 transition-transform"></i> {{ __('Back to Home') }}
                    </a>
                </div>

            </div>

        </div>
    </div>

    @push('scripts')
        {{-- Tentukan URL Snap berdasarkan Environment --}}
        @php
            $snapUrl = config('midtrans.is_production') 
                ? 'https://app.midtrans.com/snap/snap.js' 
                : 'https://app.sandbox.midtrans.com/snap/snap.js';
        @endphp
        
        {{-- Load Script Midtrans --}}
        <script src="{{ $snapUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>

        <script type="text/javascript">
            const payButton = document.getElementById('pay-button');
            const snapToken = '{{ $order->snap_token }}';
            
            // Flag untuk mencegah double-call
            let isSnapOpen = false;

            payButton.addEventListener('click', function(e) {
                e.preventDefault();

                // 1. Cek apakah popup sudah terbuka? Jika ya, hentikan proses.
                if (isSnapOpen) {
                    console.log('Snap popup is already open.');
                    return;
                }

                if(snapToken) {
                    // 2. Set flag menjadi true dan disable tombol (opsional visual)
                    isSnapOpen = true;
                    payButton.innerHTML = '<span class="flex items-center gap-2"><svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> {{ __("Loading Payment...") }}</span>';
                    payButton.classList.add('opacity-70', 'cursor-not-allowed');

                    window.snap.pay(snapToken, {
                        onSuccess: function(result){
                            // Redirect ke halaman history/home
                            window.location.href = '{{ URL::signedRoute("payment.success", ["orderNumber" => $order->order_number]) }}';
                        },
                        onPending: function(result){
                            // Transaksi pending (misal belum bayar VA)
                            alert("{{ __('Waiting for your payment!') }}"); 
                            resetButton();
                        },
                        onError: function(result){
                            alert("{{ __('Payment failed!') }}"); 
                            resetButton();
                        },
                        onClose: function(){
                            // 3. User menutup popup tanpa bayar. PENTING: Reset flag di sini.
                            alert("{{ __('You closed the payment popup without completing the transaction.') }}");
                            resetButton();
                        }
                    });
                } else {
                    alert("{{ __('Payment token not found.') }}");
                }
            });

            // Fungsi Helper untuk mengembalikan tombol ke kondisi semula
            function resetButton() {
                isSnapOpen = false;
                payButton.innerHTML = '<i data-lucide="credit-card" class="w-5 h-5 group-hover:scale-110 transition"></i> {{ __("Pay Now") }}';
                payButton.classList.remove('opacity-70', 'cursor-not-allowed');
                
                // Re-init icon lucide jika hilang karena innerHTML diubah
                if(window.lucide) {
                    lucide.createIcons();
                }
            }
        </script>
    @endpush

</x-web.main-layout>