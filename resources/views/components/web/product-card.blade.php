@props(['product'])

<div class="group bg-white rounded-[2rem] p-5 border border-gray-200/60 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full relative overflow-hidden"
     x-data="{ isLoading: false }">
    
    {{-- Badges (New, Hot, Discount) --}}
    <div class="absolute top-5 left-5 z-20 flex flex-col gap-2">
        @if($product->created_at->diffInDays(now()) < 30)
            <span class="bg-brand-dark text-white text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider shadow-sm">
                {{ __('New') }}
            </span>
        @endif
        
        @if($product->is_featured)
            <span class="bg-red-500 text-white text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider shadow-sm">
                {{ __('Hot') }}
            </span>
        @endif

        @if($product->has_discount)
            <span class="bg-brand-primary text-white text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider shadow-sm">
                {{ $product->discount_type == 'percent' ? '-' . (int)$product->discount_value . '%' : 'Sale' }}
            </span>
        @endif
    </div>

    {{-- Product Image --}}
    <a href="{{ route('products.show', $product->slug) }}" class="flex-1 w-full flex items-center justify-center mb-6 relative p-4 group-hover:scale-105 transition duration-500">
        {{-- Background Circle Decor --}}
        <div class="absolute inset-0 bg-gray-50 rounded-[1.5rem] transform rotate-3 scale-90 group-hover:rotate-0 transition-transform duration-500 -z-10"></div>
        
        <img src="{{ $product->thumbnail ? asset($product->thumbnail) : asset('assets/images/placeholder-pump.png') }}" 
             id="p-img-{{ $product->id }}"
             alt="{{ $product->name }}"
             class="w-full h-40 object-contain mix-blend-multiply drop-shadow-sm transition-all">
    </a>

    <div class="mt-auto">
        <div class="mb-4">
            {{-- Category --}}
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-1.5 flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-brand-primary"></span>
                {{ $product->category ? $product->category->getTranslation('name') : __('Industrial') }}
            </p>
            
            {{-- Title --}}
            <h3 class="font-black text-slate-900 text-lg leading-tight group-hover:text-brand-primary transition line-clamp-2 min-h-[3rem]">
                <a href="{{ route('products.show', $product->slug) }}">
                    {{ $product->name }}
                </a>
            </h3>
        </div>

        {{-- Footer: Price & Action --}}
        <div class="flex items-end justify-between border-t border-gray-100 pt-4">
            
            {{-- Price --}}
            <div class="flex flex-col">
                @if($product->has_discount)
                    <span class="text-[10px] text-slate-400 line-through font-bold">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <span class="text-brand-dark font-black text-lg">
                        {!! $product->price_label_html !!}
                    </span>
                @else
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ __('Price') }}</span>
                    <span class="text-brand-dark font-black text-lg">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                @endif
            </div>

            {{-- Action Button --}}
            <div>
                {{-- KOREKSI: Tulisan "Detail" dihapus. Tombol disesuaikan. --}}
                
                @if($product->has_variants)
                    {{-- Tombol Select Option (Ke Detail Page) --}}
                    <a href="{{ route('products.show', $product->slug) }}" 
                       class="bg-gray-100 text-slate-600 px-4 py-2.5 rounded-xl font-bold text-xs hover:bg-brand-dark hover:text-white transition-all shadow-sm flex items-center gap-2 group/btn">
                        {{ __('Select Option') }}
                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover/btn:translate-x-0.5 transition-transform"></i>
                    </a>
                @else
                    {{-- Tombol Direct Buy --}}
                    @if($product->stock > 0)
                        <button @click.prevent="addToCart({{ $product->id }}, 1, null, 'p-img-{{ $product->id }}')" 
                                :disabled="isLoading"
                                class="bg-brand-primary text-white px-4 py-2.5 rounded-xl font-bold text-xs hover:bg-brand-dark transition-all shadow-lg shadow-green-900/20 flex items-center gap-2 transform active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed group/btn">
                            
                            {{-- Loading --}}
                            <svg x-show="isLoading" class="animate-spin h-3.5 w-3.5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            
                            {{-- Icon --}}
                            <i x-show="!isLoading" data-lucide="shopping-cart" class="w-3.5 h-3.5 group-hover/btn:scale-110 transition-transform"></i>
                            
                            {{ __('Add to Cart') }}
                        </button>
                    @else
                        <button disabled class="bg-gray-100 text-gray-400 px-4 py-2.5 rounded-xl font-bold text-xs cursor-not-allowed flex items-center gap-1.5 border border-gray-200">
                            <i data-lucide="x-circle" class="w-3.5 h-3.5"></i>
                            {{ __('Sold Out') }}
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>