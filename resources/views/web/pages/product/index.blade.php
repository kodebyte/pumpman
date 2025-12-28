<x-web.main-layout>

    {{-- State Management --}}
    <div x-data="{ mobileFilterOpen: false, sortOpen: false }" class="bg-brand-gray">
        
        {{-- 1. PAGE HEADER (Minimalist & Blended) --}}
        <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
            {{-- Background Decor --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-brand-soft/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            
            <div class="container mx-auto px-4 md:px-6 relative z-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div>
                        {{-- Breadcrumbs --}}
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                            <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                            <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                            <span class="text-brand-primary">{{ __('Products') }}</span>
                        </div>
                        {{-- STANDARDIZED TITLE --}}
                        <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                            {{ __('Industrial Catalog') }}
                        </h1>
                    </div>
                    
                    {{-- Description --}}
                    <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                        {{ __('Browse our complete range of high-performance pumps and spare parts designed for heavy-duty industrial applications.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 md:px-6 pb-24">
            
            {{-- 2. TOP BAR (FULL WIDTH) --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4 pb-6 pt-4 border-b border-gray-200/60">
                {{-- Showing Count --}}
                <p class="text-sm text-slate-500 font-medium">
                    {{ __('Showing') }} <span class="font-bold text-slate-900">{{ $products->count() }}</span> {{ __('products from total') }} <span class="font-bold text-slate-900">{{ $totalProducts }}</span>
                </p>
                
                {{-- Controls (Mobile Filter & Sort) --}}
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    {{-- Mobile Filter Trigger --}}
                    <button @click="mobileFilterOpen = true" class="lg:hidden flex items-center justify-center gap-2 border border-gray-200 bg-white px-4 py-2.5 rounded-lg text-sm font-bold text-slate-700 hover:border-brand-primary hover:text-brand-primary transition w-1/2 shadow-sm">
                        <i data-lucide="sliders-horizontal" class="w-4 h-4"></i> {{ __('Filter') }}
                    </button>

                    {{-- Sort Dropdown --}}
                    <div class="relative w-1/2 sm:w-auto">
                        <button @click="sortOpen = !sortOpen" @click.away="sortOpen = false" class="flex items-center justify-between gap-3 border border-gray-200 bg-white px-4 py-2.5 rounded-lg text-sm font-bold text-slate-700 hover:border-brand-primary transition w-full sm:min-w-[200px] shadow-sm">
                            <span class="flex items-center gap-2">
                                <i data-lucide="arrow-up-down" class="w-3.5 h-3.5 text-gray-400"></i>
                                @if(request('sort') == 'price_low') {{ __('Price: Low to High') }}
                                @elseif(request('sort') == 'price_high') {{ __('Price: High to Low') }}
                                @else {{ __('Latest Arrivals') }}
                                @endif
                            </span>
                            <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="sortOpen ? 'rotate-180' : ''"></i>
                        </button>
                        
                        <div x-show="sortOpen" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 top-full mt-2 w-full bg-white border border-gray-100 shadow-xl rounded-xl z-20 py-1 overflow-hidden" 
                             style="display: none;">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" class="block px-4 py-3 text-sm hover:bg-brand-soft {{ request('sort') == 'latest' || !request('sort') ? 'text-brand-primary font-bold bg-gray-50' : 'text-slate-600' }}">{{ __('Latest Arrivals') }}</a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" class="block px-4 py-3 text-sm hover:bg-brand-soft {{ request('sort') == 'price_low' ? 'text-brand-primary font-bold bg-gray-50' : 'text-slate-600' }}">{{ __('Price: Low to High') }}</a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" class="block px-4 py-3 text-sm hover:bg-brand-soft {{ request('sort') == 'price_high' ? 'text-brand-primary font-bold bg-gray-50' : 'text-slate-600' }}">{{ __('Price: High to Low') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. MAIN CONTENT (Split Sidebar & Grid) --}}
            <div class="flex flex-col lg:flex-row gap-10">
                
                {{-- SIDEBAR FILTER (Desktop) --}}
                <aside class="hidden lg:block w-64 flex-shrink-0">
                    <form action="{{ route('products.index') }}" method="GET" class="sticky top-32">
                        @if(request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif
                        @if(request('sort'))
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                        @endif

                        <div class="space-y-8 pr-4">
                            <div class="bg-white/50 backdrop-blur-sm p-6 rounded-2xl shadow-sm border border-gray-200/60">
                                <h3 class="font-bold text-slate-900 text-xs uppercase tracking-widest mb-6 flex items-center gap-2">
                                    <i data-lucide="filter" class="w-4 h-4 text-brand-primary"></i> {{ __('Filter by Category') }}
                                </h3>
                                
                                <ul class="space-y-4">
                                    <li>
                                        <a href="{{ route('products.index') }}" class="flex items-center gap-3 cursor-pointer group">
                                            @php
                                                $isAllActive = !isset($category) && empty(request('categories'));
                                            @endphp
                                            
                                            <div class="w-5 h-5 rounded border flex items-center justify-center transition-all duration-300 {{ $isAllActive ? 'bg-brand-primary border-brand-primary' : 'border-gray-300 bg-white group-hover:border-brand-primary' }}">
                                                @if($isAllActive)
                                                    <i data-lucide="check" class="w-3 h-3 text-white"></i>
                                                @endif
                                            </div>
                                            <span class="text-sm font-medium {{ $isAllActive ? 'text-brand-primary font-bold' : 'text-slate-600' }} group-hover:text-brand-primary transition">
                                                {{ __('All Products') }}
                                            </span>
                                        </a>
                                    </li>

                                    @php
                                        $selectedIds = request()->input('categories', []);
                                        if (!is_array($selectedIds)) $selectedIds = [];
                                        if (isset($category) && $category) {
                                            $selectedIds[] = (string) $category->id;
                                        }
                                        $selectedIds = array_unique($selectedIds);
                                    @endphp

                                    @foreach($categories as $cat)
                                        @php
                                            $isChecked = in_array((string)$cat->id, $selectedIds);
                                        @endphp
                                        <li>
                                            <label class="flex items-center gap-3 cursor-pointer group relative">
                                                <input type="checkbox" 
                                                    name="categories[]" 
                                                    value="{{ $cat->id }}" 
                                                    onchange="this.form.submit()"
                                                    class="peer sr-only" 
                                                    {{ $isChecked ? 'checked' : '' }}>
                                                
                                                <div class="w-5 h-5 rounded border border-gray-300 bg-white flex items-center justify-center transition-all duration-200 peer-checked:bg-brand-primary peer-checked:border-brand-primary peer-checked:[&>svg]:opacity-100 group-hover:border-brand-primary">
                                                    <i data-lucide="check" class="w-3 h-3 text-white opacity-0 transition-opacity duration-200"></i>
                                                </div>
                                                
                                                <span class="text-sm font-medium text-slate-600 peer-checked:font-bold peer-checked:text-brand-primary group-hover:text-brand-primary transition select-none flex-1">
                                                    {{ $cat->getTranslation('name') }} 
                                                </span>
                                                <span class="text-xs text-slate-400 bg-white border border-gray-100 px-2 py-0.5 rounded-full">{{ $cat->products_count }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </form>
                </aside>

                {{-- PRODUCT GRID AREA --}}
                <div class="flex-1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($products as $product)
                            <x-web.product-card :product="$product" />
                        @empty
                            <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 text-center py-24 bg-white/50 backdrop-blur-sm rounded-2xl border border-dashed border-gray-300">
                                <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm border border-gray-100">
                                    <i data-lucide="search-x" class="w-8 h-8 text-slate-400"></i>
                                </div>
                                <h3 class="text-slate-900 font-bold text-lg mb-2">{{ __('No products found') }}</h3>
                                <p class="text-sm text-slate-500">{{ __('Try adjusting your filters or search keyword.') }}</p>
                                <a href="{{ route('products.index') }}" class="inline-block mt-6 px-6 py-2 bg-slate-900 text-white text-sm font-bold rounded-full hover:bg-brand-primary transition shadow-lg">
                                    {{ __('Clear All Filters') }}
                                </a>
                            </div>
                        @endforelse
                    </div>

                    {{-- PAGINATION --}}
                    <div class="mt-16 flex justify-center border-t border-gray-200/60 pt-8">
                        <nav class="flex items-center gap-4">
                            @if($products->previousPageUrl())
                                <a href="{{ $products->previousPageUrl() }}" class="flex items-center gap-2 px-6 py-3 rounded-full border border-gray-300 bg-white text-sm font-bold text-slate-700 hover:border-brand-primary hover:bg-brand-primary hover:text-white transition group shadow-sm">
                                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> {{ __('Previous') }}
                                </a>
                            @else
                                <button disabled class="flex items-center gap-2 px-6 py-3 rounded-full border border-gray-200 bg-gray-50 text-sm font-bold text-gray-300 cursor-not-allowed">
                                    <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Previous') }}
                                </button>
                            @endif

                            @if($products->nextPageUrl())
                                <a href="{{ $products->nextPageUrl() }}" class="flex items-center gap-2 px-6 py-3 rounded-full border border-gray-300 bg-white text-sm font-bold text-slate-700 hover:border-brand-primary hover:bg-brand-primary hover:text-white transition group shadow-sm">
                                    {{ __('Next Page') }} <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            @else
                                <button disabled class="flex items-center gap-2 px-6 py-3 rounded-full border border-gray-200 bg-gray-50 text-sm font-bold text-gray-300 cursor-not-allowed">
                                    {{ __('Next Page') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </button>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- 4. MOBILE FILTER OVERLAY (Alpine.js) --}}
        <div x-show="mobileFilterOpen" class="relative z-[100] lg:hidden" style="display: none;">
            <div x-show="mobileFilterOpen" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100]" 
                @click="mobileFilterOpen = false">
            </div>

            <form action="{{ route('products.index') }}" method="GET" x-show="mobileFilterOpen" 
                x-transition:enter="transition transform ease-[cubic-bezier(0.25,1,0.5,1)] duration-500"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition transform ease-[cubic-bezier(0.25,1,0.5,1)] duration-500"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="fixed inset-y-0 right-0 max-w-xs w-full bg-white shadow-2xl flex flex-col z-[110]">
                
                <div class="flex items-center justify-between p-6 border-b border-gray-100 bg-brand-gray">
                    <h2 class="text-lg font-bold uppercase tracking-wider text-slate-900 flex items-center gap-2">
                        <i data-lucide="sliders-horizontal" class="w-5 h-5"></i> {{ __('Filter Products') }}
                    </h2>
                    <button type="button" @click="mobileFilterOpen = false" class="text-gray-400 hover:text-brand-primary transition">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 space-y-8">
                     <div>
                        <h3 class="font-bold text-xs uppercase tracking-widest mb-4 text-slate-900">{{ __('Category') }}</h3>
                        <div class="space-y-3">
                            @php
                                $selectedIds = request()->input('categories', []);
                                if (!is_array($selectedIds)) $selectedIds = [];
                                if (isset($category) && $category) {
                                    $selectedIds[] = (string) $category->id;
                                }
                                $selectedIds = array_unique($selectedIds);
                            @endphp

                            @foreach($categories as $cat)
                                @php
                                    $isChecked = in_array((string)$cat->id, $selectedIds);
                                @endphp
                                <label class="flex items-center gap-3">
                                    <input type="checkbox" name="categories[]" value="{{ $cat->id }}" 
                                        class="w-5 h-5 rounded text-brand-primary focus:ring-brand-primary" 
                                        {{ $isChecked ? 'checked' : '' }}> 
                                    <span class="text-sm font-medium text-slate-700">{{ $cat->getTranslation('name') }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-100 bg-gray-50">
                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-brand-primary transition shadow-lg">
                        {{ __('Show Results') }}
                    </button>
                </div>
            </form>
        </div>
    </div> 
    
</x-web.main-layout>