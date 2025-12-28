<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="pt-14 pb-12 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Dashboard') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('My Dashboard') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Welcome back') }}, <span class="font-bold text-slate-900">{{ auth()->user()->name }}</span>.
                    <br>{{ __('Here is an overview of your recent activities.') }}
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

                {{-- DASHBOARD CONTENT --}}
                <div class="lg:col-span-3 space-y-8">
                    
                    {{-- A. STATS CARDS --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        {{-- Total Orders --}}
                        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-200/60 relative overflow-hidden group hover:border-brand-primary/30 transition-all duration-300">
                            <div class="relative z-10">
                                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-slate-400 mb-4 group-hover:bg-brand-primary group-hover:text-white transition-colors duration-300">
                                    <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                                </div>
                                <h3 class="text-4xl font-black text-slate-900 mb-1">{{ $totalOrders }}</h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('Total Orders') }}</p>
                            </div>
                            {{-- Decor --}}
                            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-gray-50 rounded-full group-hover:scale-150 transition-transform duration-500 z-0"></div>
                        </div>

                        {{-- Waiting Payment --}}
                        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-200/60 relative overflow-hidden group hover:border-brand-primary/30 transition-all duration-300">
                            <div class="relative z-10">
                                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-slate-400 mb-4 group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300">
                                    <i data-lucide="credit-card" class="w-6 h-6"></i>
                                </div>
                                <h3 class="text-4xl font-black text-slate-900 mb-1">
                                    {{ \App\Models\Order::where('user_id', auth()->id())->where('payment_status', 'pending')->count() }}
                                </h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('Unpaid') }}</p>
                            </div>
                        </div>

                         {{-- Completed --}}
                         <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-200/60 relative overflow-hidden group hover:border-brand-primary/30 transition-all duration-300">
                            <div class="relative z-10">
                                <div class="w-12 h-12 bg-gray-50 rounded-xl flex items-center justify-center text-slate-400 mb-4 group-hover:bg-green-500 group-hover:text-white transition-colors duration-300">
                                    <i data-lucide="package-check" class="w-6 h-6"></i>
                                </div>
                                <h3 class="text-4xl font-black text-slate-900 mb-1">
                                    {{ \App\Models\Order::where('user_id', auth()->id())->where('status', 'completed')->count() }}
                                </h3>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('Completed') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- B. RECENT ORDERS TABLE --}}
                    <div class="bg-white rounded-[2rem] shadow-sm border border-gray-200/60 overflow-hidden">
                        <div class="px-8 py-8 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <h3 class="font-black text-xl text-slate-900">{{ __('Recent Orders') }}</h3>
                                <p class="text-slate-500 text-sm mt-1">{{ __('Track your latest procurement status.') }}</p>
                            </div>
                            @if($recentOrders->count() > 0)
                                <a href="{{ route('orders.index') }}" class="text-xs font-bold text-brand-primary hover:text-brand-dark transition uppercase tracking-widest flex items-center gap-2 border border-gray-200 px-4 py-2 rounded-lg hover:bg-gray-50">
                                    {{ __('View All History') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            @endif
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[800px]">
                                <thead>
                                    <tr class="bg-gray-50/50 text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-gray-100">
                                        <th class="px-8 py-5">{{ __('Order ID') }}</th>
                                        <th class="px-8 py-5">{{ __('Date') }}</th>
                                        <th class="px-8 py-5">{{ __('Payment') }}</th>
                                        <th class="px-8 py-5">{{ __('Total Amount') }}</th>
                                        <th class="px-8 py-5 text-right">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 text-sm font-medium text-slate-600">
                                    @forelse($recentOrders as $order)
                                        <tr class="hover:bg-gray-50/80 transition duration-200 group">
                                            <td class="px-8 py-6">
                                                <span class="font-mono font-bold text-brand-dark text-xs bg-gray-100 px-2 py-1 rounded border border-gray-200 group-hover:border-brand-primary/30 group-hover:text-brand-primary transition-colors">
                                                    #{{ $order->order_number }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-6 text-xs font-bold text-slate-500">
                                                {{ $order->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-8 py-6">
                                                @php
                                                    $statusConfig = match($order->payment_status) {
                                                        'paid', 'settlement', 'success' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-100'],
                                                        'pending' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-100'],
                                                        'cancelled', 'expire', 'deny' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-100'],
                                                        default => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'border' => 'border-gray-100']
                                                    };
                                                    $displayStatus = $order->payment_status === 'settlement' ? 'Paid' : ucfirst($order->payment_status);
                                                @endphp
                                                
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} border {{ $statusConfig['border'] }} uppercase tracking-wide">
                                                    {{ $displayStatus }}
                                                </span>
                                            </td>
                                            <td class="px-8 py-6 text-slate-900 font-black">
                                                Rp {{ number_format($order->grand_total, 0, ',', '.') }}
                                            </td>
                                            <td class="px-8 py-6 text-right">
                                                @if(Route::has('order.invoice'))
                                                    <a href="{{ route('order.invoice', $order->id) }}" 
                                                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-white border border-gray-200 text-xs font-bold text-slate-600 hover:bg-brand-dark hover:text-white hover:border-brand-dark transition shadow-sm" 
                                                       title="{{ __('View Details') }}">
                                                        {{ __('Details') }} <i data-lucide="arrow-up-right" class="w-3 h-3"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-24 text-center">
                                                <div class="flex flex-col items-center gap-4">
                                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center border border-gray-100">
                                                        <i data-lucide="shopping-bag" class="w-8 h-8 text-slate-300"></i>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-slate-900 text-lg">{{ __('No orders yet') }}</p>
                                                        <p class="text-sm text-slate-500 mt-1 max-w-xs mx-auto">{{ __('Your order history will appear here once you make a purchase.') }}</p>
                                                    </div>
                                                    <a href="{{ route('products.index') }}" class="mt-4 bg-brand-dark text-white px-8 py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-brand-primary transition shadow-lg">
                                                        {{ __('Start Shopping') }}
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-web.main-layout>