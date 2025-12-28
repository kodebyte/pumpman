<x-web.main-layout>

    {{-- HEADER / BREADCRUMB --}}
    <div class="pt-14 pb-10 bg-brand-gray relative z-0">
         <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <a href="{{ route('products.index') }}" class="hover:text-brand-primary transition">{{ __('Products') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Detail') }}</span>
                    </div>
                    
                    {{-- REVISI: Gunakan Nama Kategori sebagai Judul Header (Agar tidak redundan dengan nama produk di bawah) --}}
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ $product->category ? $product->category->getTranslation('name') : __('Industrial Catalog') }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    {{-- MAIN PRODUCT CARD --}}
    <section class="bg-brand-gray pb-20 relative z-0" 
        x-data="productDetail({
            product: {{ $product->toJson() }},
            initialImage: '{{ $product->images->where('is_primary', true)->first() ? asset('storage/' . $product->images->where('is_primary', true)->first()->image_path) : ($product->images->first() ? asset('storage/' . $product->images->first()->image_path) : asset('assets/web/images/placeholder.png')) }}',
            variants: {{ $product->variants->count() > 0 ? $product->variants->toJson() : '[]' }},
            hasVariants: {{ $product->has_variants ? 'true' : 'false' }},
            defaultStock: {{ $product->stock ?? 0 }},
            defaultSku: '{{ $product->sku ?? '-' }}',
            defaultPrice: {{ $product->final_price ?? $product->price }},
            csrfToken: '{{ csrf_token() }}',
            addToCartUrl: '{{ route('cart.add') }}'
        })"
    >
        <div class="container mx-auto px-4 md:px-6">
            <div class="bg-white rounded-[2rem] p-6 md:p-10 shadow-sm border border-gray-100">
                
                {{-- PART 1: TOP GRID --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-16 mb-16">
                    
                    {{-- LEFT: IMAGE GALLERY (Sticky) --}}
                    <div class="lg:col-span-6 xl:col-span-5">
                        <div class="sticky top-32">
                            {{-- Main Image --}}
                            <div class="bg-gray-50 rounded-2xl aspect-square flex items-center justify-center mb-4 border border-gray-100 relative overflow-hidden group cursor-zoom-in"
                                @mouseenter="zoom = true"
                                @mouseleave="zoom = false"
                                @mousemove="
                                    const rect = $el.getBoundingClientRect();
                                    zoomX = ((($event.clientX - rect.left) / rect.width) * 100);
                                    zoomY = ((($event.clientY - rect.top) / rect.height) * 100);
                                ">
                                
                                {{-- Badges --}}
                                <div class="absolute top-4 left-4 z-10 flex flex-col gap-2 pointer-events-none">
                                    @if($product->is_featured)
                                        <div class="bg-brand-primary text-white text-[10px] font-bold px-3 py-1 rounded uppercase tracking-widest shadow-sm">
                                            {{ __('Best Seller') }}
                                        </div>
                                    @endif
                                    @if($product->has_discount)
                                        <div class="bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded uppercase tracking-widest shadow-sm">
                                            {{ $product->discount_type == 'percent' ? '-' . (int)$product->discount_value . '%' : __('Promo') }}
                                        </div>
                                    @endif
                                </div>
                                
                                <img :src="activeImage" 
                                    id="main-product-image" 
                                    class="w-3/4 h-3/4 object-contain mix-blend-multiply transition-transform duration-200 ease-out"
                                    :class="zoom ? 'scale-[2]' : 'group-hover:scale-105'"
                                    :style="`transform-origin: ${zoomX}% ${zoomY}%;`"
                                    alt="{{ $product->name }}">
                            </div>

                            {{-- Thumbnails --}}
                            <div class="grid grid-cols-5 gap-3">
                                @foreach($product->images->sortBy('order') as $image)
                                    <button @click="activeImage = '{{ asset('storage/' . $image->image_path) }}'" 
                                            class="bg-gray-50 rounded-xl aspect-square border-2 p-1.5 transition overflow-hidden relative"
                                            :class="activeImage === '{{ asset('storage/' . $image->image_path) }}' ? 'border-brand-primary ring-1 ring-brand-primary' : 'border-transparent hover:border-gray-300'">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-contain mix-blend-multiply">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT: PRODUCT INFO & ACTIONS --}}
                    <div class="lg:col-span-6 xl:col-span-7">
                        
                        {{-- Title & Price --}}
                        <div class="border-b border-gray-100 pb-6 mb-6">
                            <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">
                                {{ __('SKU') }}: {{ $product->sku ?? '-' }}
                            </span>
                            
                            {{-- REVISI: Ubah h2 menjadi h1 karena ini adalah Judul Utama Halaman ini sekarang --}}
                            <h1 class="text-3xl md:text-4xl font-display font-bold text-slate-900 mb-4 leading-tight">
                                {{ $product->name }}
                            </h1>
                            
                            <div class="flex items-end gap-4">
                                <span class="text-3xl font-bold text-brand-primary" x-text="formatRupiah(getCurrentPrice())">
                                    Rp {{ number_format($product->final_price ?? $product->price, 0, ',', '.') }}
                                </span>
                                
                                @if($product->has_discount)
                                    <span class="text-lg text-gray-400 line-through mb-1">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Short Desc --}}
                        <div class="prose prose-sm text-slate-500 mb-6 max-w-none leading-relaxed">
                            <p>{{ $product->getTranslation('short_description') ?? $product->short_description }}</p>
                        </div>

                        {{-- Variants Selection --}}
                        @if($product->has_variants && $product->variants->count() > 0)
                            <div class="mb-6 bg-gray-50 p-5 rounded-xl border border-gray-100">
                                <span class="text-xs font-bold uppercase text-slate-400 tracking-widest block mb-3">{{ __('Select Model / Variant') }}</span>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($product->variants as $variant)
                                        <button @click="selectVariant({{ $variant }})"
                                                :class="selectedVariant && selectedVariant.id === {{ $variant->id }} 
                                                        ? 'border-brand-primary bg-white text-brand-primary ring-1 ring-brand-primary shadow-sm' 
                                                        : 'border-gray-200 hover:border-brand-primary text-slate-600 bg-white'"
                                                class="px-5 py-3 rounded-lg border text-sm font-bold transition-all focus:outline-none">
                                            {{ $variant->name }}
                                        </button>
                                    @endforeach
                                </div>
                                
                                <div x-show="selectedVariant" class="mt-3 text-xs font-bold flex items-center gap-2" 
                                    :class="selectedVariant && selectedVariant.stock > 0 ? 'text-brand-primary' : 'text-red-500'">
                                    <i x-show="selectedVariant && selectedVariant.stock > 0" data-lucide="check-circle" class="w-3.5 h-3.5"></i>
                                    <i x-show="!selectedVariant || selectedVariant.stock <= 0" data-lucide="x-circle" class="w-3.5 h-3.5"></i>
                                    <span x-text="selectedVariant && selectedVariant.stock > 0 ? '{{ __('Ready Stock') }} ' : '{{ __('Out of Stock') }}'"></span>
                                </div>
                            </div>
                        @endif

                        {{-- Add to Cart Action --}}
                        <div class="mb-8">
                            <form @submit.prevent="addToCartAction()" class="flex flex-col md:flex-row gap-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="variant_id" :value="selectedVariant ? selectedVariant.id : ''">
                                <input type="hidden" name="qty" :value="qty">

                                {{-- Qty Input --}}
                                <div class="flex items-center bg-gray-50 border border-gray-200 rounded-xl h-14 w-full md:w-40 px-2"
                                    :class="checkStock() <= 0 ? 'opacity-50 cursor-not-allowed' : ''">
                                    <button type="button" @click="qty > 1 ? qty-- : null" :disabled="checkStock() <= 0 || qty <= 1"
                                            class="w-10 h-full flex items-center justify-center text-slate-400 hover:text-brand-primary font-bold text-xl transition-colors disabled:opacity-30">-</button>
                                    <input type="text" x-model="qty" class="w-full text-center font-bold bg-transparent border-none focus:ring-0 p-0 text-slate-900 cursor-default select-none text-lg" readonly>
                                    <button type="button" @click="qty < checkStock() ? qty++ : null" :disabled="checkStock() <= 0 || qty >= checkStock()"
                                            class="w-10 h-full flex items-center justify-center text-slate-400 hover:text-brand-primary font-bold text-xl transition-colors disabled:opacity-30">+</button>
                                </div>
                                
                                {{-- Submit Button --}}
                                <button type="submit" 
                                    :disabled="checkStock() <= 0 || isLoading"
                                    :class="checkStock() <= 0 ? 'bg-gray-400 cursor-not-allowed' : 'bg-brand-dark hover:bg-brand-primary'"
                                    class="flex-1 text-white rounded-xl h-14 font-bold uppercase tracking-widest transition shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group relative overflow-hidden text-sm">
                                    <div x-show="!isLoading" class="flex items-center gap-2">
                                        <i data-lucide="shopping-cart" class="w-5 h-5 group-hover:-translate-y-1 transition-transform"></i>
                                        <span x-text="checkStock() <= 0 ? '{{ __('Sold Out') }}' : '{{ __('Add to Cart') }}'"></span>
                                    </div>
                                    <div x-show="isLoading" style="display: none;" class="flex items-center gap-2">
                                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <span>{{ __('Processing...') }}</span>
                                    </div>
                                </button>
                            </form>
                        </div>

                        {{-- Meta Info --}}
                        <div class="pt-6 border-t border-gray-100 flex flex-wrap gap-y-3 gap-x-8 text-xs text-slate-500 font-medium">
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 uppercase tracking-wide">{{ __('SKU') }}:</span>
                                <span x-text="hasVariants && selectedVariant ? selectedVariant.sku : defaultSku" class="text-slate-900 font-bold">
                                    {{ $product->has_variants && $product->variants->first() ? $product->variants->first()->sku : ($product->sku ?? '-') }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-slate-400 uppercase tracking-wide">{{ __('Weight') }}:</span>
                                <span class="text-slate-900 font-bold">{{ $product->weight }} gr</span>
                            </div>
                            @if($product->marketplaces->count() > 0)
                                <div class="w-full pt-4 mt-2 border-t border-gray-50">
                                    <span class="text-xs font-bold uppercase text-slate-400 tracking-widest block mb-2">{{ __('Also Available At') }}</span>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($product->marketplaces as $mp)
                                            @if(!empty($mp->pivot->link))
                                                <a href="{{ $mp->pivot->link }}" target="_blank" class="flex items-center gap-2 px-3 py-1.5 border border-gray-200 rounded-lg hover:border-brand-primary hover:bg-brand-soft transition group bg-gray-50 text-xs">
                                                    @if($mp->icon) <img src="{{ asset('storage/' . $mp->icon) }}" class="w-4 h-4 object-contain grayscale group-hover:grayscale-0 transition"> @else <i data-lucide="shopping-bag" class="w-4 h-4 text-gray-400 group-hover:text-brand-primary"></i> @endif
                                                    <span class="font-bold text-slate-600 group-hover:text-brand-primary transition-colors">{{ $mp->name }}</span>
                                                </a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- PART 2: TABS (Centered Layout) --}}
                <div class="border-t border-gray-100 pt-10 mt-10" x-data="{ tab: 'desc' }">
                    
                    {{-- Tab Nav (Centered) --}}
                    <div class="flex flex-wrap items-center justify-center gap-8 mb-10 border-b border-gray-100 pb-1">
                        <button @click="tab = 'desc'" 
                                class="pb-4 text-sm font-bold uppercase tracking-widest transition relative"
                                :class="tab === 'desc' ? 'text-brand-primary border-b-2 border-brand-primary' : 'text-slate-400 hover:text-slate-600'">
                            {{ __('Description') }}
                        </button>
                        <button @click="tab = 'specs'" 
                                class="pb-4 text-sm font-bold uppercase tracking-widest transition relative"
                                :class="tab === 'specs' ? 'text-brand-primary border-b-2 border-brand-primary' : 'text-slate-400 hover:text-slate-600'">
                            {{ __('Specifications') }}
                        </button>
                        @if($product->downloads->count() > 0)
                            <button @click="tab = 'downloads'" 
                                    class="pb-4 text-sm font-bold uppercase tracking-widest transition relative"
                                    :class="tab === 'downloads' ? 'text-brand-primary border-b-2 border-brand-primary' : 'text-slate-400 hover:text-slate-600'">
                                {{ __('Downloads') }}
                            </button>
                        @endif
                    </div>

                    {{-- Tab Contents (Centered Column) --}}
                    <div>
                        
                        {{-- Content: Description --}}
                        <div x-show="tab === 'desc'" class="space-y-6 animate-fade-in-up">
                            <div class="prose prose-slate max-w-none prose-a:text-brand-primary hover:prose-a:text-brand-dark mx-auto">
                                {!! $product->getTranslation('description') ?? $product->description !!}
                            </div>
                        </div>

                        {{-- Content: Specs --}}
                        <div x-show="tab === 'specs'" class="animate-fade-in-up" style="display: none;">
                            <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100">
                                <h3 class="text-lg font-bold mb-6 text-slate-900 flex items-center gap-2">
                                    <i data-lucide="settings" class="w-5 h-5 text-brand-primary"></i> {{ __('Technical Specifications') }}
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-12">
                                    <div class="flex justify-between py-3 border-b border-gray-200 border-dashed">
                                        <span class="text-sm font-medium text-slate-500">{{ __('Product Name') }}</span>
                                        <span class="text-sm font-bold text-slate-900 text-right">{{ $product->name }}</span>
                                    </div>
                                    <div class="flex justify-between py-3 border-b border-gray-200 border-dashed">
                                        <span class="text-sm font-medium text-slate-500">{{ __('Weight') }}</span>
                                        <span class="text-sm font-bold text-slate-900 text-right">{{ $product->weight }} {{ __('Grams') }}</span>
                                    </div>
                                    <div class="flex justify-between py-3 border-b border-gray-200 border-dashed">
                                        <span class="text-sm font-medium text-slate-500">{{ __('Category') }}</span>
                                        <span class="text-sm font-bold text-slate-900 text-right">{{ $product->category->getTranslation('name') ?? '-' }}</span>
                                    </div>
                                    @if($product->has_variants)
                                        <div class="flex justify-between py-3 border-b border-gray-200 border-dashed">
                                            <span class="text-sm font-medium text-slate-500">{{ __('Available Variants') }}</span>
                                            <span class="text-sm font-bold text-slate-900 text-right">
                                                {{ $product->variants->pluck('name')->join(', ') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Content: Downloads --}}
                        @if($product->downloads->count() > 0)
                            <div x-show="tab === 'downloads'" class="animate-fade-in-up" style="display: none;">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($product->downloads as $download)
                                        <a href="{{ asset('storage/' . $download->file_path) }}" target="_blank" class="flex items-center justify-between p-5 border border-gray-200 rounded-xl hover:border-brand-primary hover:bg-brand-soft transition group bg-white shadow-sm">
                                            <div class="flex items-center gap-4">
                                                <div class="bg-brand-primary/10 text-brand-primary p-3 rounded-lg">
                                                    <i data-lucide="{{ $download->type == 'manual' ? 'book-open' : 'file-text' }}" class="w-6 h-6"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-slate-900 group-hover:text-brand-primary">{{ $download->title }}</h4>
                                                    <p class="text-xs text-slate-500 uppercase font-medium">{{ $download->type }}</p>
                                                </div>
                                            </div>
                                            <i data-lucide="download" class="w-5 h-5 text-gray-400 group-hover:text-brand-primary"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- RELATED PRODUCTS --}}
    <section class="py-24 bg-brand-gray border-t border-gray-200/50">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">{{ __('Recommendation') }}</span>
                    <h2 class="text-2xl md:text-3xl font-display font-bold text-slate-900">{{ __('You Might Also Like') }}</h2>
                </div>
                <a href="{{ route('products.index') }}" class="group flex items-center gap-2 text-slate-500 hover:text-brand-primary transition font-medium pb-1 border-b border-transparent hover:border-brand-primary">
                    {{ __('View All') }} <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($relatedProducts as $related)
                    <x-web.product-card :product="$related" />
                @empty
                    <div class="col-span-4 text-center py-10 text-gray-400 border border-dashed rounded-xl">
                        {{ __('No related products found.') }}
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('productDetail', (config) => ({
                    productId: config.product.id,
                    activeImage: config.initialImage,
                    qty: 1,
                    activeTab: 'desc',

                    zoom: false,
                    zoomX: 50,
                    zoomY: 50,
                    
                    hasVariants: config.hasVariants,
                    productStock: config.defaultStock,
                    defaultSku: config.defaultSku,
                    defaultPrice: config.defaultPrice,
                    
                    variants: config.variants,
                    selectedVariant: null,
                    
                    isLoading: false,

                    init() {
                        if (this.variants.length > 0) {
                            this.selectedVariant = this.variants[0];
                        }
                    },

                    checkStock() {
                        if (this.hasVariants) {
                            return this.selectedVariant ? this.selectedVariant.stock : 0;
                        } else {
                            return this.productStock;
                        }
                    },

                    async addToCartAction() {
                        if (this.hasVariants && !this.selectedVariant) {
                            alert("{{ __('Please select a variant first!') }}");
                            return;
                        }

                        if (this.qty > this.checkStock()) {
                            alert("{{ __('Quantity exceeds available stock!') }}");
                            return;
                        }

                        this.isLoading = true;

                        try {
                            await window.addToCart(
                                this.productId, 
                                this.qty, 
                                this.selectedVariant ? this.selectedVariant.id : null, 
                                'main-product-image'
                            );
                        } catch (error) {
                            console.error('Add to cart failed:', error);
                        } finally {
                            this.isLoading = false;
                        }
                    },

                    getCurrentPrice() {
                        if (this.selectedVariant && this.selectedVariant.price) {
                            return parseInt(this.selectedVariant.price);
                        }
                        return this.defaultPrice;
                    },

                    formatRupiah(number) {
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
                    },

                    selectVariant(variant) {
                        this.selectedVariant = variant;
                    },
                }));
            });
        </script>
    @endpush

</x-web.main-layout>