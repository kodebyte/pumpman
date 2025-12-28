<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('My Orders') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Order History') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Track and manage your procurement history. Download invoices and track shipment status here.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <section class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                
                {{-- SIDEBAR --}}
                @include('web.pages.user.partials.sidebar')

                {{-- ORDER LIST --}}
                <div class="lg:col-span-3 space-y-6">
                    
                    @forelse($orders as $order)
                        <div class="bg-white rounded-[2rem] shadow-sm border border-gray-200/60 overflow-hidden hover:shadow-md transition-all duration-300 group">
                            
                            {{-- Header Card --}}
                            <div class="bg-gray-50/50 px-8 py-5 border-b border-gray-100 flex flex-wrap gap-4 justify-between items-center">
                                <div class="flex flex-wrap items-center gap-6 text-sm">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('Order ID') }}</p>
                                        <p class="font-bold text-brand-dark font-mono bg-white border border-gray-200 px-2 py-1 rounded text-xs">
                                            #{{ $order->order_number }}
                                        </p>
                                    </div>
                                    <div class="hidden sm:block w-px h-8 bg-gray-200"></div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('Date') }}</p>
                                        <p class="font-bold text-slate-700">{{ $order->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div class="hidden sm:block w-px h-8 bg-gray-200"></div>
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">{{ __('Total Amount') }}</p>
                                        <p class="font-black text-brand-dark">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>
                                </div>

                                {{-- Status Badge --}}
                                @php
                                    $statusConfig = match($order->payment_status) {
                                        'paid', 'settlement', 'success' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'label' => 'Paid'],
                                        'pending' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200', 'label' => 'Pending'],
                                        'cancelled', 'expire', 'deny', 'failure' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'label' => 'Failed'],
                                        default => ['bg' => 'bg-gray-50', 'text' => 'text-slate-600', 'border' => 'border-gray-200', 'label' => ucfirst($order->payment_status)]
                                    };
                                @endphp
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest border {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} {{ $statusConfig['border'] }}">
                                    {{ $statusConfig['label'] }}
                                </span>
                            </div>

                            {{-- Body Card --}}
                            <div class="p-8">
                                <div class="flex flex-col md:flex-row gap-8 items-start md:items-center">
                                    
                                    {{-- Product List Preview --}}
                                    <div class="flex-1 space-y-4 w-full">
                                        @foreach($order->items->take(2) as $item)
                                            <div class="flex gap-5 items-center">
                                                <div class="w-16 h-16 bg-white rounded-xl border border-gray-100 p-2 flex-shrink-0 flex items-center justify-center">
                                                     @if($item->product && $item->product->images->count() > 0)
                                                        <img src="{{ asset('storage/' . $item->product->images->first()->image_path) }}" class="w-full h-full object-contain mix-blend-multiply">
                                                     @else
                                                        <i data-lucide="package" class="w-6 h-6 text-slate-300"></i>
                                                     @endif
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-sm text-slate-900 line-clamp-1">{{ $item->product_name }}</h4>
                                                    <div class="flex items-center gap-2 mt-1">
                                                        @if($item->variant_name)
                                                            <span class="text-[10px] font-bold bg-gray-100 text-slate-500 px-1.5 py-0.5 rounded uppercase tracking-wide">{{ $item->variant_name }}</span>
                                                        @endif
                                                        <span class="text-xs text-slate-400 font-medium">Qty: {{ $item->qty }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        @if($order->items->count() > 2)
                                            <p class="text-[10px] uppercase font-bold text-brand-primary pl-20 tracking-wider flex items-center gap-1">
                                                <i data-lucide="plus" class="w-3 h-3"></i> {{ $order->items->count() - 2 }} {{ __('more items') }}
                                            </p>
                                        @endif
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="w-full md:w-auto flex flex-row md:flex-col gap-3 min-w-[160px]">
                                        
                                        <a href="{{ route('orders.show', $order->id) }}" class="w-full text-center px-6 py-3 bg-white border border-gray-200 text-slate-700 text-xs font-bold uppercase tracking-widest rounded-xl hover:border-brand-dark hover:text-brand-dark transition shadow-sm">
                                            {{ __('View Details') }}
                                        </a>

                                        @if($order->payment_status == 'unpaid' || $order->payment_status == 'pending')
                                            <a href="{{ URL::signedRoute('checkout.success', ['orderNumber' => $order->order_number]) }}" 
                                            class="w-full text-center px-6 py-3 bg-brand-primary text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-green-700 transition shadow-lg shadow-green-900/20">
                                                {{ __('Pay Now') }}
                                            </a>
                                        @endif

                                        @if($order->tracking_number)
                                            <a href="{{ route('order-tracking', ['order_number' => $order->order_number]) }}" class="w-full text-center px-6 py-3 bg-brand-dark text-white text-xs font-bold uppercase tracking-widest rounded-xl hover:bg-gray-800 transition flex justify-center gap-2 items-center">
                                                <i data-lucide="truck" class="w-3 h-3"></i> {{ __('Track') }}
                                            </a>
                                        @endif

                                    </div>
                                </div>
                            </div>

                        </div>
                    @empty
                        {{-- Empty State --}}
                        <div class="bg-white rounded-[2.5rem] p-16 text-center border-2 border-dashed border-gray-200">
                            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i data-lucide="shopping-bag" class="w-10 h-10 text-slate-300"></i>
                            </div>
                            <h3 class="text-xl font-black text-slate-900 mb-2">{{ __('No orders yet') }}</h3>
                            <p class="text-slate-500 text-sm mb-8 max-w-xs mx-auto">{{ __('Looks like you haven\'t made any purchases yet. Start your procurement today.') }}</p>
                            <a href="{{ route('products.index') }}" class="bg-brand-dark text-white px-8 py-4 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-brand-primary transition shadow-lg inline-flex items-center gap-2">
                                {{ __('Browse Catalog') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    @endforelse

                    {{-- Pagination Links --}}
                    @if($orders->hasPages())
                        <div class="pt-6">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

</x-web.main-layout>