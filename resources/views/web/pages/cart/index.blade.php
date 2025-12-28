<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Order List') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Procurement List') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    <span class="text-slate-900 font-bold">{{ $cartItems->count() }} {{ __('Items') }}</span> {{ __('ready for checkout processing.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <section class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            @if($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start" 
                     x-data="cartPage()">
                    
                    {{-- LEFT: CART ITEMS --}}
                    <div class="lg:col-span-8">
                        <div class="hidden md:grid grid-cols-12 gap-6 text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-4 px-6">
                            <div class="col-span-6">{{ __('Product Specification') }}</div>
                            <div class="col-span-3 text-center">{{ __('Unit Qty') }}</div>
                            <div class="col-span-3 text-right">{{ __('Subtotal') }}</div>
                        </div>

                        <div class="space-y-4">
                            @foreach($cartItems as $item)
                                @php
                                    $image = asset('assets/web/images/placeholder.png');
                                    if ($item->product->images->where('is_primary', true)->first()) {
                                        $image = asset('storage/' . $item->product->images->where('is_primary', true)->first()->image_path);
                                    } elseif ($item->product->images->first()) {
                                        $image = asset('storage/' . $item->product->images->first()->image_path);
                                    }
                                @endphp

                                <div class="group bg-white rounded-[2rem] p-6 border border-gray-200/60 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden" 
                                     id="cart-item-{{ $item->id }}">
                                    
                                    {{-- Accent Strip --}}
                                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-brand-primary opacity-0 group-hover:opacity-100 transition duration-300"></div>

                                    <div class="flex flex-col md:grid md:grid-cols-12 gap-6 items-center">
                                        
                                        {{-- Product Info --}}
                                        <div class="md:col-span-6 w-full flex items-center gap-6">
                                            <div class="w-24 h-24 bg-gray-50 rounded-2xl p-4 flex-shrink-0 border border-gray-100 relative">
                                                <img src="{{ $image }}" class="w-full h-full object-contain mix-blend-multiply">
                                            </div>
                                            <div>
                                                <h3 class="font-bold text-lg text-slate-900 leading-tight mb-1">
                                                    <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-brand-primary transition">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h3>
                                                @if($item->variant)
                                                    <div class="inline-flex items-center px-2 py-1 rounded bg-gray-100 text-[10px] font-bold text-slate-500 uppercase tracking-wide mb-3">
                                                        {{ $item->variant->name }}
                                                    </div>
                                                @endif
                                                
                                                <div class="block md:hidden mb-2">
                                                    <span class="text-xs text-slate-400">{{ __('Price') }}:</span>
                                                    <span class="font-bold text-slate-700">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                                </div>

                                                <button @click="removeItem({{ $item->id }})" 
                                                        class="text-xs font-bold text-red-500 hover:text-red-700 flex items-center gap-1.5 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition group/btn">
                                                    <i data-lucide="trash-2" class="w-3.5 h-3.5 group-hover/btn:scale-110 transition"></i> {{ __('Remove') }}
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Quantity --}}
                                        <div class="md:col-span-3 w-full flex justify-center" x-data="{ localQty: {{ $item->qty }}, isLoading: false }">
                                            <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl p-1 shadow-inner"
                                                 :class="isLoading ? 'opacity-50 pointer-events-none' : ''">
                                                
                                                <button @click="if(localQty > 1) { localQty--; updateQty({{ $item->id }}, localQty, $data); }" 
                                                        class="w-8 h-8 flex items-center justify-center bg-white text-slate-400 hover:text-brand-primary rounded-lg shadow-sm border border-gray-100 transition active:scale-95 disabled:opacity-50"
                                                        :disabled="localQty <= 1">
                                                    <i data-lucide="minus" class="w-3.5 h-3.5"></i>
                                                </button>
                                                
                                                <input type="text" x-model="localQty" class="w-12 text-center bg-transparent border-none focus:ring-0 p-0 text-sm font-black text-slate-900" readonly>
                                                
                                                <button @click="localQty++; updateQty({{ $item->id }}, localQty, $data);" 
                                                        class="w-8 h-8 flex items-center justify-center bg-white text-slate-400 hover:text-brand-primary rounded-lg shadow-sm border border-gray-100 transition active:scale-95">
                                                    <i data-lucide="plus" class="w-3.5 h-3.5"></i>
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Subtotal --}}
                                        <div class="md:col-span-3 w-full flex justify-between md:justify-end items-center border-t md:border-t-0 border-gray-100 pt-4 md:pt-0 mt-4 md:mt-0">
                                            <span class="md:hidden text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('Total') }}</span>
                                            <span class="font-black text-lg text-slate-900" id="item-subtotal-{{ $item->id }}">
                                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-400 hover:text-brand-primary transition group">
                                <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i>
                                {{ __('Continue Procurement') }}
                            </a>
                        </div>
                    </div>

                    {{-- RIGHT: SUMMARY CARD --}}
                    <div class="lg:col-span-4 sticky top-32">
                        
                        {{-- REVISI: Background Hijau Polos (Tanpa Grid) --}}
                        <div class="bg-brand-primary text-white rounded-[2rem] shadow-2xl p-8 relative overflow-hidden group">
                            
                            {{-- Content --}}
                            <div class="relative z-10">
                                <h3 class="font-black text-xl mb-8 uppercase tracking-wide border-b border-white/20 pb-4">{{ __('Order Summary') }}</h3>
                                
                                <div class="space-y-4 text-sm text-white/90 mb-8 font-medium">
                                    <div class="flex justify-between">
                                        <span>{{ __('Subtotal') }}</span>
                                        <span class="font-bold text-white" id="summary-subtotal">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>{{ __('Tax (11%)') }}</span>
                                        <span class="font-bold text-white" id="summary-tax">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>{{ __('Shipping (Flat Rate)') }}</span>
                                        <span class="font-bold text-white">Rp {{ number_format($shippingFee, 0, ',', '.') }}</span>
                                    </div>
                                </div>

                                <div class="flex justify-between items-end mb-10 pt-6 border-t border-white/20">
                                    <span class="font-bold text-lg text-white uppercase tracking-wider">{{ __('Total') }}</span>
                                    <span class="text-3xl font-black text-white tracking-tight" id="summary-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>

                                {{-- REVISI: Tombol Checkout Putih Solid --}}
                                <a href="{{ route('cart.checkout') }}" class="block w-full bg-white text-brand-dark py-4 rounded-xl font-bold uppercase tracking-widest text-sm text-center hover:bg-brand-dark hover:text-white transition-all duration-300 shadow-lg transform hover:-translate-y-1">
                                    {{ __('Proceed to Checkout') }}
                                </a>

                                <div class="mt-8 flex justify-center gap-3 opacity-60 grayscale hover:grayscale-0 transition duration-500">
                                    <div class="h-6 px-2 bg-white/20 rounded flex items-center justify-center text-[10px] font-bold text-white backdrop-blur-sm">VISA</div>
                                    <div class="h-6 px-2 bg-white/20 rounded flex items-center justify-center text-[10px] font-bold text-white backdrop-blur-sm">MC</div>
                                    <div class="h-6 px-2 bg-white/20 rounded flex items-center justify-center text-[10px] font-bold text-white backdrop-blur-sm">BCA</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            @else
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mb-6 shadow-sm border border-gray-100">
                        <i data-lucide="shopping-cart" class="w-10 h-10 text-slate-300"></i>
                    </div>
                    <h2 class="text-2xl font-black text-slate-900 mb-2">{{ __('Your List is Empty') }}</h2>
                    <p class="text-slate-500 mb-10 max-w-md">{{ __('Start adding industrial pumps and parts to your procurement list.') }}</p>
                    <a href="{{ route('products.index') }}" class="bg-brand-dark text-white px-8 py-4 rounded-xl font-bold uppercase tracking-widest hover:bg-brand-primary transition shadow-lg text-sm">
                        {{ __('Browse Catalog') }}
                    </a>
                </div>
            @endif
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('cartPage', () => ({
                    
                    timeout: null,

                    async updateQty(itemId, newQty, itemScope) {
                        itemScope.isLoading = true;

                        try {
                            const response = await fetch(`/cart/update/${itemId}`, { 
                                method: 'PATCH',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    qty: newQty
                                })
                            });
                            
                            const data = await response.json();

                            if(data.success) {
                                itemScope.localQty = data.current_qty; 
                                document.getElementById(`item-subtotal-${itemId}`).innerText = data.item_subtotal;
                                document.getElementById('summary-subtotal').innerText = data.cart_subtotal;
                                document.getElementById('summary-tax').innerText = data.cart_tax;
                                document.getElementById('summary-total').innerText = data.cart_total;

                                if(Alpine.store('cart')) {
                                    Alpine.store('cart').updateCount(data.cart_count);
                                }

                                if (data.message.includes('disesuaikan')) {
                                    alert(data.message);
                                }
                            } else {
                                alert(data.message);
                                window.location.reload();
                            }

                        } catch (e) {
                            console.error(e);
                            alert("{{ __('Failed to update cart') }}");
                            window.location.reload();
                        } finally {
                            itemScope.isLoading = false;
                        }
                    },

                    async removeItem(itemId) {
                        if(!confirm("{{ __('Remove this item?') }}")) return;

                        try {
                            const response = await fetch(`/cart/remove/${itemId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Content-Type': 'application/json'
                                }
                            });

                            const data = await response.json();

                            if (data.success) {
                                if(Alpine.store('cart')) {
                                    Alpine.store('cart').fetchCart(true); // Force fetch
                                }
                                window.location.reload();
                            }
                        } catch (error) {
                            console.error('Error removing item:', error);
                        }
                    }
                }));
            });
        </script>
    @endpush

</x-web.main-layout>