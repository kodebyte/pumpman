@props(['product'])

{{-- PUMPMAN PRODUCT CARD --}}
{{-- Logika Alpine.js "isLoading" dan "addToCart" diambil dari Aiwa --}}
<div class="group bg-white rounded-[2rem] p-5 border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative"
     x-data="{ isLoading: false }">
    
    {{-- Badges --}}
    <div class="absolute top-5 left-5 z-20 flex flex-col gap-2">
        @if($product->created_at->diffInDays(now()) < 30)
            <span class="bg-brand-accent text-brand-dark text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                {{ __('New') }}
            </span>
        @endif
        
        {{-- Logika Best Seller (Sesuaikan jika ada column is_best_seller) --}}
        @if($product->is_featured)
            <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                {{ __('Hot') }}
            </span>
        @endif

        {{-- Logika Diskon dari Aiwa --}}
        @if($product->has_discount)
            <span class="bg-green-600 text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">
                {{ $product->discount_type == 'percent' ? '-' . (int)$product->discount_value . '%' : 'Sale' }}
            </span>
        @endif
    </div>

    {{-- Product Image --}}
    <a href="{{ route('products.show', $product->slug) }}" class="flex-1 w-full flex items-center justify-center mb-6 relative p-4 group-hover:scale-105 transition duration-500">
        <img src="{{ $product->thumbnail ? asset($product->thumbnail) : asset('assets/images/placeholder-pump.png') }}" 
             id="p-img-{{ $product->id }}"
             alt="{{ $product->name }}"
             class="w-full h-40 object-contain mix-blend-multiply">
    </a>

    <div class="mt-auto">
        <div class="mb-4">
            {{-- Category --}}
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">
                {{ $product->category ? $product->category->getTranslation('name') : __('Uncategorized') }}
            </p>
            
            {{-- Title --}}
            <h3 class="font-bold text-slate-900 text-lg leading-tight group-hover:text-brand-primary transition">
                <a href="{{ route('products.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h3>
        </div>

        <div class="flex items-center justify-between border-t border-gray-50 pt-4 gap-2">
            {{-- Price Logic --}}
            <div class="flex flex-col">
                @if($product->has_discount)
                    <span class="text-[10px] text-gray-400 line-through">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <span class="text-slate-900 font-bold text-sm">
                        {!! $product->price_label_html !!}
                    </span>
                @else
                    <span class="text-slate-900 font-bold text-sm">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-4">
                {{-- Detail Link --}}
                <a href="{{ route('products.show', $product->slug) }}" class="relative text-xs font-bold text-slate-500 hover:text-brand-primary transition-colors py-1 after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-brand-primary hover:after:w-full after:transition-all after:duration-300">
                    {{ __('Detail') }}
                </a>
                
                {{-- Add To Cart Button (Logic from Aiwa) --}}
                @if($product->has_variants)
                    <a href="{{ route('products.show', $product->slug) }}" class="bg-brand-primary text-white px-4 py-2 rounded-full font-bold text-xs hover:bg-brand-dark transition shadow-lg flex items-center gap-1.5 transform active:scale-95">
                        <i data-lucide="eye" class="w-3.5 h-3.5"></i>
                        {{ __('View') }}
                    </a>
                @else
                    @if($product->stock > 0)
                        <button @click.prevent="addToCart({{ $product->id }}, 1, null, 'p-img-{{ $product->id }}')" 
                                :disabled="isLoading"
                                class="bg-brand-primary text-white px-4 py-2 rounded-full font-bold text-xs hover:bg-brand-dark transition shadow-lg flex items-center gap-1.5 transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                            
                            {{-- Loading Icon --}}
                            <svg x-show="isLoading" class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            
                            {{-- Normal Icon --}}
                            <i x-show="!isLoading" data-lucide="shopping-cart" class="w-3.5 h-3.5"></i>
                            
                            {{ __('Buy') }}
                        </button>
                    @else
                        <button disabled class="bg-gray-400 text-white px-4 py-2 rounded-full font-bold text-xs cursor-not-allowed flex items-center gap-1.5">
                            <i data-lucide="x-circle" class="w-3.5 h-3.5"></i>
                            {{ __('Sold') }}
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>