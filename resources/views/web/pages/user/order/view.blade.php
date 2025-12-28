<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="py-16 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <a href="{{ route('orders.index') }}" class="hover:text-brand-primary transition">{{ __('My Orders') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">#{{ $order->order_number }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Order Details') }}
                    </h1>
                </div>
                
                {{-- Back Button --}}
                <a href="{{ route('orders.index') }}" class="group inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-brand-dark transition-all bg-white border border-gray-200 px-4 py-3 rounded-xl hover:border-gray-300 shadow-sm">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <section class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            
            {{-- TOP INFO BAR --}}
            <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-200/60 mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-brand-dark text-white rounded-2xl flex items-center justify-center shadow-lg">
                        <i data-lucide="package" class="w-7 h-7"></i>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('Order Number') }}</p>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">#{{ $order->order_number }}</h2>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    @if($order->payment_status == 'unpaid' || $order->payment_status == 'pending')
                        <a href="{{ URL::signedRoute('checkout.success', ['orderNumber' => $order->order_number]) }}" 
                           class="flex items-center gap-2 px-6 py-3 bg-brand-primary text-white rounded-xl text-xs font-bold hover:bg-green-700 transition shadow-lg shadow-green-900/20 uppercase tracking-wider">
                            <i data-lucide="credit-card" class="w-4 h-4"></i> {{ __('Pay Now') }}
                        </a>
                    @endif

                    @if(Route::has('order.invoice') && in_array($order->payment_status, ['paid', 'settlement', 'success']))
                        <a href="{{ route('order.invoice', $order->id) }}" target="_blank" class="flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-xl text-xs font-bold text-slate-700 hover:border-brand-dark hover:text-brand-dark transition shadow-sm uppercase tracking-wider">
                            <i data-lucide="printer" class="w-4 h-4"></i> {{ __('Invoice') }}
                        </a>
                    @endif

                    @if($order->tracking_number)
                        <a href="{{ route('order-tracking', ['order_number' => $order->order_number]) }}" class="flex items-center gap-2 px-6 py-3 bg-brand-dark text-white rounded-xl text-xs font-bold hover:bg-gray-800 transition shadow-md uppercase tracking-wider">
                            <i data-lucide="truck" class="w-4 h-4"></i> {{ __('Track Order') }}
                        </a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- LEFT: ORDER ITEMS & INFO --}}
                <div class="lg:col-span-2 space-y-8">
                    
                    {{-- Status & Date --}}
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-200/60">
                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">{{ __('Order Date') }}</p>
                                <p class="font-bold text-slate-900">{{ $order->created_at->format('d F Y') }} <span class="text-slate-400 text-xs font-normal">at {{ $order->created_at->format('H:i') }}</span></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">{{ __('Current Status') }}</p>
                                @php
                                    $statusConfig = match($order->status) {
                                        'completed' => ['bg' => 'bg-green-100', 'text' => 'text-green-700'],
                                        'processing' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700'],
                                        'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-700'],
                                        default => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700']
                                    };
                                @endphp
                                <span class="inline-block px-3 py-1 rounded-lg text-xs font-black uppercase tracking-wide {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                    {{ __(ucfirst($order->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Items List --}}
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-200/60">
                        <h4 class="font-black text-slate-900 uppercase tracking-wide text-sm mb-6 pb-4 border-b border-gray-100">{{ __('Items Ordered') }}</h4>
                        <div class="space-y-6">
                            @foreach($order->items as $item)
                                <div class="flex flex-col sm:flex-row gap-6 items-start sm:items-center group">
                                    <div class="w-20 h-20 bg-gray-50 rounded-xl border border-gray-100 p-3 flex-shrink-0 flex items-center justify-center relative overflow-hidden">
                                        @if($item->product && $item->product->images->count() > 0)
                                            <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 group-hover:scale-110">
                                        @else
                                            <i data-lucide="package" class="w-8 h-8 text-slate-300"></i>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="font-bold text-slate-900 text-sm mb-1 group-hover:text-brand-primary transition">{{ $item->product_name }}</h5>
                                        @if($item->variant_name)
                                            <div class="inline-flex items-center px-2 py-0.5 rounded bg-gray-100 text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-1">
                                                {{ $item->variant_name }}
                                            </div>
                                        @endif
                                        <p class="text-xs text-slate-500 font-medium">{{ $item->qty }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-black text-slate-900 text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Shipping & Customer Info --}}
                    <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-200/60">
                        <h4 class="font-black text-slate-900 uppercase tracking-wide text-sm mb-6 pb-4 border-b border-gray-100">{{ __('Shipping Information') }}</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">{{ __('Recipient') }}</p>
                                <p class="font-bold text-slate-900 text-sm">{{ $order->first_name }} {{ $order->last_name }}</p>
                                <p class="text-slate-500 text-xs mt-1">{{ $order->phone }}</p>
                                <p class="text-slate-500 text-xs">{{ $order->email }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">{{ __('Delivery Address') }}</p>
                                <p class="text-slate-600 text-sm leading-relaxed">
                                    {{ $order->address }}<br>
                                    <span class="font-semibold">{{ $order->city_name }}, {{ $order->province_name }}</span><br>
                                    {{ $order->postal_code }}
                                </p>
                            </div>
                        </div>
                        
                        {{-- Courier Info --}}
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">{{ __('Courier Service') }}</p>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-brand-soft text-brand-primary flex items-center justify-center">
                                    <i data-lucide="truck" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 text-sm">{{ $order->courier->name ?? __('Standard Delivery') }}</p>
                                    @if($order->tracking_number)
                                        <p class="text-xs text-brand-primary font-mono font-bold mt-0.5">{{ $order->tracking_number }}</p>
                                    @else
                                        <p class="text-[10px] text-slate-400">{{ __('Tracking not available yet') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- RIGHT: PAYMENT SUMMARY --}}
                <div class="lg:col-span-1">
                    <div class="bg-brand-dark text-white rounded-[2rem] p-8 sticky top-32 shadow-2xl relative overflow-hidden group">
                        {{-- Decor --}}
                        <div class="absolute top-0 right-0 w-40 h-40 bg-brand-primary rounded-full blur-[60px] opacity-10 group-hover:opacity-20 transition duration-700"></div>

                        <h4 class="font-black text-white uppercase tracking-wide text-sm mb-8 border-b border-white/10 pb-4">{{ __('Payment Summary') }}</h4>
                        
                        <div class="space-y-4 text-sm text-white/70 mb-8 font-medium">
                            <div class="flex justify-between">
                                <span>{{ __('Subtotal') }}</span>
                                <span class="text-white">Rp {{ number_format($order->total_price - $order->tax_price - $order->shipping_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('Shipping') }}</span>
                                <span class="text-white">Rp {{ number_format($order->shipping_price, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>{{ __('Tax (11%)') }}</span>
                                <span class="text-white">Rp {{ number_format($order->tax_price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-end pt-6 border-t border-white/10 mb-8">
                            <span class="font-bold text-white uppercase tracking-wider">{{ __('Total') }}</span>
                            <span class="text-2xl font-black text-brand-primary">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>

                        <div class="bg-white/10 rounded-xl p-4">
                            <p class="text-[10px] font-bold text-white/50 uppercase tracking-widest mb-1">{{ __('Payment Method') }}</p>
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-white text-sm">{{ strtoupper($order->payment_type ?? 'Midtrans') }}</span>
                                @if(in_array($order->payment_status, ['paid', 'settlement', 'success']))
                                    <i data-lucide="check-circle" class="w-5 h-5 text-brand-primary"></i>
                                @else
                                    <i data-lucide="clock" class="w-5 h-5 text-yellow-500"></i>
                                @endif
                            </div>
                        </div>

                        <div class="mt-8 text-center">
                            <a href="{{ route('pages.contact') }}" class="text-xs font-bold text-white/50 hover:text-white transition border-b border-transparent hover:border-white pb-0.5">
                                {{ __('Need help with this order?') }}
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</x-web.main-layout>