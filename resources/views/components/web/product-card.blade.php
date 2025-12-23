@props(['product'])

<div class="group flex flex-col" x-data="{ isLoading: false }"> 
    <div class="relative mb-4 aspect-[5/4] flex items-center justify-center overflow-hidden bg-gray-50 rounded-xl border border-transparent group-hover:border-gray-200 transition-colors">
        <div class="absolute top-3 left-3 flex flex-col gap-2 z-10 pointer-events-none">
            @if($product->is_featured) 
                <div class="bg-black text-white px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">Hot</div>
            @endif
            @if($product->has_discount)
                <div class="bg-aiwaRed text-white px-2 py-1 rounded text-[10px] font-bold uppercase tracking-wider">
                    {{ $product->discount_type == 'percent' ? '-' . (int)$product->discount_value . '%' : 'Sale' }}
                </div>
            @endif
        </div>
        
        <a href="{{ route('products.show', $product->slug) }}" class="block w-full h-full">
            @if($product->thumbnail)
                <img src="{{ $product->thumbnail }}" 
                    id="p-img-{{ $product->id }}"
                    alt="{{ $product->name }}" 
                    class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 ease-out group-hover:scale-110">
            @else
                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                    <i data-lucide="image" class="w-8 h-8 mb-2 opacity-50"></i>
                    <span class="text-xs">No Image</span>
                </div>
            @endif
        </a>
        
        {{-- Ganti bagian pembungkus tombol (Button Wrapper) --}}
        <div class="absolute inset-x-0 bottom-4 flex justify-center 
                    {{-- Mobile: Selalu muncul & posisi normal --}}
                    opacity-100 translate-y-0 px-2
                    {{-- Desktop: Sembunyi & efek hover --}}
                    md:opacity-0 md:translate-y-4 md:group-hover:opacity-100 md:group-hover:translate-y-0 
                    transition-all duration-500 ease-out z-20">
            
            @if($product->has_variants)
                <a href="{{ route('products.show', $product->slug) }}" 
                class="bg-black/90 backdrop-blur-sm text-white font-bold uppercase tracking-widest rounded-full shadow-xl hover:bg-aiwaRed transition-colors flex items-center gap-2 transform hover:scale-105 active:scale-95
                        {{-- Ukuran lebih kecil di mobile agar tidak menutupi gambar --}}
                        text-[9px] px-4 py-2.5 md:text-xs md:px-6 md:py-3">
                    <i data-lucide="eye" class="w-3 h-3"></i> {{ __('Options') }}
                </a>
            @else
                @if($product->stock > 0)
                    <button @click.prevent="addToCart({{ $product->id }}, 1, null, 'p-img-{{ $product->id }}')" 
                            :disabled="isLoading"
                            class="bg-black/90 backdrop-blur-sm text-white font-bold uppercase tracking-widest rounded-full shadow-xl hover:bg-aiwaRed transition-colors flex items-center gap-2 transform hover:scale-105 active:scale-95 disabled:opacity-50
                                {{-- Ukuran lebih kecil di mobile --}}
                                text-[9px] px-4 py-2.5 md:text-xs md:px-6 md:py-3">
                        
                        <svg x-show="isLoading" class="animate-spin -ml-1 mr-1 h-3 w-3 text-white" ...>...</svg>
                        <i x-show="!isLoading" data-lucide="plus" class="w-3 h-3"></i> 
                        {{ __('Add to Cart') }}
                    </button>
                @else
                    <button disabled
                            class="bg-gray-400/90 backdrop-blur-sm text-white font-bold uppercase tracking-widest rounded-full shadow-xl cursor-not-allowed flex items-center gap-2
                                text-[9px] px-4 py-2.5 md:text-xs md:px-6 md:py-3">
                        <i data-lucide="x-circle" class="w-3 h-3"></i> {{ __('Sold Out') }}
                    </button>
                @endif
            @endif
        </div>
    </div>

    <div class="flex flex-col items-center text-center space-y-1.5 px-2">
        @if($product->category)
            <a href="{{ route('products.category', $product->category->slug) }}"
               class="text-[10px] font-bold text-gray-400 uppercase tracking-widest hover:text-aiwaRed transition-colors relative z-10">
                {{ $product->category->getTranslation('name') }}
            </a>
        @else
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Aiwa</span>
        @endif
        
        <a href="{{ route('products.show', $product->slug) }}" class="group/info block w-full">
            <h3 class="text-base font-bold text-black leading-tight group-hover/info:text-aiwaRed transition-colors line-clamp-2 min-h-[2.5rem] flex items-center justify-center">
                {{ $product->name }}
            </h3>
            
            <div class="flex items-center gap-2 justify-center mt-1">
                <span class="text-sm font-bold {{ $product->has_discount ? 'text-aiwaRed' : 'text-black' }} flex items-baseline justify-center">
                    {!! $product->price_label_html !!}
                </span>
                
                @if($product->has_discount && !$product->has_variants)
                    <span class="text-[10px] text-gray-400 line-through decoration-gray-400">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                @endif
            </div>
        </a>
    </div>
</div>