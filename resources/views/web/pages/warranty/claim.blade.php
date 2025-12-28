<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-slate-400">{{ __('Support') }}</span>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Claim') }}</span>
                    </div>
                    {{-- STANDARDIZED TITLE --}}
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Warranty Claim') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Official Pumpman after-sales service. Fill out the form below to request a unit repair or replacement.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. MAIN FORM DASHBOARD --}}
    <section class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            
            <div class="flex flex-col lg:flex-row bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-200/60">
                
                {{-- LEFT: REQUIREMENTS SIDEBAR --}}
                <div class="w-full lg:w-[400px] bg-gray-50 border-r border-gray-200 p-8 md:p-10 order-2 lg:order-1">
                    <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm flex items-center gap-2 mb-8">
                        <div class="w-8 h-8 rounded-lg bg-brand-dark text-white flex items-center justify-center">
                            <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                        </div>
                        {{ __('Claim Requirements') }}
                    </h3>
                    
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4 group">
                            <div class="w-6 h-6 rounded-full bg-white border border-gray-200 flex items-center justify-center shadow-sm text-brand-primary mt-0.5 group-hover:border-brand-primary transition">
                                <i data-lucide="check" class="w-3 h-3"></i>
                            </div>
                            <div class="flex-1">
                                <strong class="text-slate-900 text-sm block mb-1">{{ __('Official Warranty Card') }}</strong>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ __('Ensure the physical warranty card exists and matches the unit serial number.') }}</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4 group">
                            <div class="w-6 h-6 rounded-full bg-white border border-gray-200 flex items-center justify-center shadow-sm text-brand-primary mt-0.5 group-hover:border-brand-primary transition">
                                <i data-lucide="check" class="w-3 h-3"></i>
                            </div>
                            <div class="flex-1">
                                <strong class="text-slate-900 text-sm block mb-1">{{ __('Purchase Receipt') }}</strong>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ __('Attach a valid and legible photo/scan of the purchase receipt (Invoice).') }}</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4 group">
                            <div class="w-6 h-6 rounded-full bg-white border border-gray-200 flex items-center justify-center shadow-sm text-brand-primary mt-0.5 group-hover:border-brand-primary transition">
                                <i data-lucide="check" class="w-3 h-3"></i>
                            </div>
                            <div class="flex-1">
                                <strong class="text-slate-900 text-sm block mb-1">{{ __('Within Warranty Period') }}</strong>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ __('Product has not exceeded the warranty limit (1-3 Years depending on model).') }}</p>
                            </div>
                        </li>
                    </ul>

                    <div class="mt-10 pt-8 border-t border-gray-200">
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-wider mb-4">{{ __('Need Help?') }}</p>
                        <a href="{{ route('pages.contact') }}" class="flex items-center gap-3 w-full bg-white border border-gray-300 text-slate-700 font-bold px-4 py-3 rounded-xl hover:border-brand-primary hover:text-brand-primary transition shadow-sm justify-center text-sm">
                            <i data-lucide="message-circle" class="w-4 h-4"></i> {{ __('Contact Support') }}
                        </a>
                    </div>
                </div>

                {{-- RIGHT: FORM AREA --}}
                <div class="flex-1 p-8 md:p-12 lg:p-14 bg-white order-1 lg:order-2">
                    
                    @if(session('error'))
                        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl mb-8 flex items-center gap-3 animate-fade-in-up">
                            <i data-lucide="alert-circle" class="w-5 h-5 flex-shrink-0"></i>
                            <span class="text-sm font-bold">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('warranty-claim.store') }}" 
                            method="POST" 
                            enctype="multipart/form-data" 
                            class="space-y-10"
                            x-data="{ isSubmitting: false }" 
                            @submit="isSubmitting = true">
                        @csrf
                        
                        {{-- SECTION 1 --}}
                        <div>
                            <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3 border-b border-gray-100 pb-4">
                                <span class="bg-brand-dark text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold">1</span>
                                {{ __('Customer Information') }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Full Name') }} <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" 
                                        class="w-full px-4 py-3.5 rounded-xl focus:outline-none focus:ring-1 transition bg-gray-50 focus:bg-white border text-sm font-bold text-slate-900
                                        {{ $errors->has('name') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:border-brand-primary focus:ring-brand-primary' }}" 
                                        placeholder="Ex: Budi Santoso">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Phone / WhatsApp') }} <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" 
                                        class="w-full px-4 py-3.5 rounded-xl focus:outline-none focus:ring-1 transition bg-gray-50 focus:bg-white border text-sm font-bold text-slate-900
                                        {{ $errors->has('phone') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:border-brand-primary focus:ring-brand-primary' }}" 
                                        placeholder="0812...">
                                    @error('phone')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Email Address') }} <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" 
                                        class="w-full px-4 py-3.5 rounded-xl focus:outline-none focus:ring-1 transition bg-gray-50 focus:bg-white border text-sm font-bold text-slate-900
                                        {{ $errors->has('email') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:border-brand-primary focus:ring-brand-primary' }}" 
                                        placeholder="email@company.com">
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Full Address') }} <span class="text-red-500">*</span></label>
                                    <textarea name="address" rows="3" 
                                            class="w-full px-4 py-3.5 rounded-xl focus:outline-none focus:ring-1 transition resize-none bg-gray-50 focus:bg-white border text-sm font-bold text-slate-900
                                            {{ $errors->has('address') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:border-brand-primary focus:ring-brand-primary' }}">{{ old('address') }}</textarea>
                                    <p class="text-[10px] text-gray-400 mt-1">{{ __('Used for return shipping if unit replacement is approved.') }}</p>
                                    @error('address')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 2 --}}
                        <div>
                            <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3 border-b border-gray-100 pb-4">
                                <span class="bg-brand-dark text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold">2</span>
                                {{ __('Product Data') }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                {{-- Product Search Dropdown --}}
                                <div class="md:col-span-2" 
                                    x-data="{ 
                                        open: false,
                                        search: '',
                                        selectedId: '{{ old('product_id') }}',
                                        selectedName: '',
                                        products: {{ Js::from($products) }},
                                        
                                        init() {
                                            if (this.selectedId) {
                                                const found = this.products.find(p => p.id == this.selectedId);
                                                if (found) this.selectedName = found.name + ' (SKU: ' + found.sku + ')';
                                            }
                                        },

                                        get filteredProducts() {
                                            if (this.search === '') return this.products;
                                            return this.products.filter(product => {
                                                return product.name.toLowerCase().includes(this.search.toLowerCase()) || 
                                                    product.sku.toLowerCase().includes(this.search.toLowerCase());
                                            });
                                        },

                                        selectProduct(product) {
                                            this.selectedId = product.id;
                                            this.selectedName = product.name + ' (SKU: ' + product.sku + ')';
                                            this.open = false;
                                            this.search = '';
                                        }
                                    }"
                                    @click.outside="open = false">
                                    
                                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Select Product Model') }} <span class="text-red-500">*</span></label>
                                    
                                    <input type="hidden" name="product_id" :value="selectedId">

                                    <div class="relative">
                                        <button type="button" 
                                                @click="open = !open; $nextTick(() => $refs.searchInput.focus())"
                                                class="w-full text-left px-4 py-3.5 rounded-xl border focus:outline-none focus:ring-1 transition flex justify-between items-center bg-gray-50 focus:bg-white text-sm font-bold text-slate-900"
                                                :class="selectedId ? 'border-gray-200' : 'border-gray-200 text-gray-500', 
                                                        {{ $errors->has('product_id') ? '!border-red-500' : 'border-gray-200 focus:border-brand-primary' }}">
                                            
                                            <span x-text="selectedName ? selectedName : '{{ __('Search Product Type...') }}'"></span>
                                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                                        </button>

                                        <div x-show="open" 
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-cloak
                                            class="absolute z-50 mt-1 w-full bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-hidden flex flex-col">
                                            
                                            <div class="p-3 border-b border-gray-100 bg-gray-50">
                                                <div class="relative">
                                                    <i data-lucide="search" class="absolute left-3 top-2.5 w-4 h-4 text-gray-400"></i>
                                                    <input x-ref="searchInput" 
                                                        x-model="search" 
                                                        type="text" 
                                                        class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary"
                                                        placeholder="{{ __('Type name or SKU...') }}">
                                                </div>
                                            </div>

                                            <ul class="overflow-y-auto p-2 scrollbar-hide">
                                                <template x-for="product in filteredProducts" :key="product.id">
                                                    <li @click="selectProduct(product)"
                                                        class="px-3 py-2.5 text-sm rounded-lg cursor-pointer hover:bg-brand-soft hover:text-brand-primary transition flex justify-between items-center group mb-1"
                                                        :class="selectedId == product.id ? 'bg-brand-soft text-brand-primary font-bold' : 'text-slate-700'">
                                                        
                                                        <div>
                                                            <span x-text="product.name"></span>
                                                            <span class="text-xs text-gray-400 block group-hover:text-brand-primary/70" x-text="'SKU: ' + product.sku"></span>
                                                        </div>
                                                        
                                                        <i x-show="selectedId == product.id" data-lucide="check" class="w-4 h-4 text-brand-primary"></i>
                                                    </li>
                                                </template>

                                                <li x-show="filteredProducts.length === 0" class="px-4 py-3 text-sm text-gray-500 text-center">
                                                    {{ __('Product not found.') }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    @error('product_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Serial Number (SN)') }} <span class="text-red-500">*</span></label>
                                    <input type="text" name="serial_number" value="{{ old('serial_number') }}" 
                                        class="w-full px-4 py-3.5 rounded-xl focus:outline-none focus:ring-1 transition bg-gray-50 focus:bg-white border text-sm font-bold text-slate-900
                                        {{ $errors->has('serial_number') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:border-brand-primary focus:ring-brand-primary' }}" 
                                        placeholder="{{ __('Check the product label') }}">
                                    @error('serial_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Purchase Date') }} <span class="text-red-500">*</span></label>
                                    <input type="date" name="purchase_date" value="{{ old('purchase_date') }}" 
                                        class="w-full px-4 py-3.5 rounded-xl focus:outline-none focus:ring-1 transition bg-gray-50 focus:bg-white border text-sm font-bold text-slate-900
                                        {{ $errors->has('purchase_date') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:border-brand-primary focus:ring-brand-primary' }}">
                                    @error('purchase_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Damage / Issue Details') }} <span class="text-red-500">*</span></label>
                                    <textarea name="issue" rows="4" 
                                            class="w-full px-4 py-3.5 rounded-xl focus:outline-none focus:ring-1 transition resize-none bg-gray-50 focus:bg-white border text-sm font-bold text-slate-900
                                            {{ $errors->has('issue') ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-200 focus:border-brand-primary focus:ring-brand-primary' }}" 
                                            placeholder="{{ __('Describe the problem precisely...') }}">{{ old('issue') }}</textarea>
                                    @error('issue')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- SECTION 3 --}}
                        <div>
                            <h3 class="text-lg font-black text-slate-900 mb-6 flex items-center gap-3 border-b border-gray-100 pb-4">
                                <span class="bg-brand-dark text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold">3</span>
                                {{ __('Document Upload') }}
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                {{-- Invoice Upload --}}
                                <div>
                                    <div class="border-2 border-dashed rounded-2xl p-8 text-center hover:bg-gray-50 transition cursor-pointer group relative
                                                {{ $errors->has('invoice') ? 'border-red-500' : 'border-gray-300 hover:border-brand-primary' }}">
                                        <input type="file" name="invoice" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="invoice_upload" onchange="showFileName('invoice_upload', 'invoice_label')">
                                        <div id="invoice_label">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-brand-soft transition">
                                                <i data-lucide="file-text" class="w-6 h-6 transition {{ $errors->has('invoice') ? 'text-red-400' : 'text-gray-400 group-hover:text-brand-primary' }}"></i>
                                            </div>
                                            <span class="block text-sm font-bold text-slate-900">{{ __('Purchase Invoice') }} <span class="text-red-500">*</span></span>
                                            <span class="text-xs text-gray-400 mt-1 block">{{ __('JPG/PDF Max 2MB') }}</span>
                                        </div>
                                    </div>
                                    @error('invoice')
                                        <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Warranty Card Upload --}}
                                <div>
                                    <div class="border-2 border-dashed rounded-2xl p-8 text-center hover:bg-gray-50 transition cursor-pointer group relative
                                                {{ $errors->has('warranty_card') ? 'border-red-500' : 'border-gray-300 hover:border-brand-primary' }}">
                                        <input type="file" name="warranty_card" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="warranty_upload" onchange="showFileName('warranty_upload', 'warranty_label')">
                                        <div id="warranty_label">
                                            <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:bg-brand-soft transition">
                                                <i data-lucide="credit-card" class="w-6 h-6 transition {{ $errors->has('warranty_card') ? 'text-red-400' : 'text-gray-400 group-hover:text-brand-primary' }}"></i>
                                            </div>
                                            <span class="block text-sm font-bold text-slate-900">{{ __('Warranty Card') }} <span class="text-red-500">*</span></span>
                                            <span class="text-xs text-gray-400 mt-1 block">{{ __('JPG/PDF Max 2MB') }}</span>
                                        </div>
                                    </div>
                                    @error('warranty_card')
                                        <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="pt-8 border-t border-gray-100">
                            <button type="submit" 
                                    class="w-full bg-brand-dark text-white font-black uppercase tracking-widest py-4 rounded-xl hover:bg-brand-primary transition-all duration-300 shadow-lg flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed group"
                                    :disabled="isSubmitting" 
                                    :class="isSubmitting ? 'bg-gray-400 cursor-not-allowed' : 'bg-brand-dark hover:bg-brand-primary'">
                                
                                <span x-show="!isSubmitting" class="flex items-center gap-2">
                                    {{ __('Submit Warranty Claim') }} <i data-lucide="send" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                                </span>

                                <span x-show="isSubmitting" x-cloak class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ __('Processing Data...') }}
                                </span>
                            </button>

                            <p class="text-center text-xs text-gray-500 mt-6">
                                {!! __('By submitting this form, you acknowledge that all provided data is accurate.') !!}
                            </p>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            function showFileName(inputId, labelId) {
                const input = document.getElementById(inputId);
                const label = document.getElementById(labelId);
                if (input.files && input.files[0]) {
                    label.innerHTML = `
                        <div class="w-12 h-12 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i data-lucide="check-circle" class="w-6 h-6 text-brand-primary"></i>
                        </div>
                        <span class="block text-sm font-bold text-slate-900 break-words line-clamp-1">${input.files[0].name}</span>
                        <span class="text-xs text-brand-primary font-bold mt-1 block">{{ __('Ready to upload') }}</span>
                    `;
                    lucide.createIcons();
                }
            }
        </script>
    @endpush

</x-web.main-layout>