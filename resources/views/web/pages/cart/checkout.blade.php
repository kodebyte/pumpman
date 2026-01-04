<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <a href="{{ route('cart.index') }}" class="hover:text-brand-primary transition">{{ __('Procurement List') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Checkout') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Finalize Order') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Complete your shipping details below. A secure payment link will be generated after confirmation.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CHECKOUT SECTION --}}
    <section class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form"
                x-data="{ isProcessing: false }" @submit="isProcessing = true">
                @csrf
                @honeypot
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
                    
                    {{-- LEFT: FORMS --}}
                    <div class="lg:col-span-7 space-y-8">
                        
                        {{-- Step 1: Contact Info --}}
                        <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-sm border border-gray-200/60">
                            <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3 border-b border-gray-100 pb-4">
                                <span class="w-8 h-8 bg-brand-dark text-white rounded-lg flex items-center justify-center text-sm font-bold">1</span>
                                {{ __('Contact Information') }}
                            </h3>

                            @guest
                                <div class="mb-8 flex items-start gap-4 p-5 bg-brand-soft/30 border border-brand-primary/20 rounded-xl">
                                    <div class="p-2 bg-white rounded-full text-brand-primary shadow-sm mt-0.5">
                                        <i data-lucide="user" class="w-4 h-4"></i>
                                    </div>
                                    <div class="text-sm text-slate-600 leading-relaxed">
                                        <span class="font-bold text-slate-900 block mb-1">{{ __('Already have an account?') }}</span> 
                                        <a href="{{ route('checkout.login') }}" class="font-bold text-brand-primary hover:text-brand-dark hover:underline transition">{{ __('Login now') }}</a> 
                                        {{ __('to retrieve your saved address and speed up the process.') }}
                                    </div>
                                </div>
                            @endguest

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Email Address') }} <span class="text-red-500">*</span></label>
                                    <input type="email" 
                                            name="email" 
                                            value="{{ auth()->user()->email ?? old('email') }}" 
                                            class="w-full bg-gray-50 border rounded-xl px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-1 focus:ring-brand-primary transition placeholder-gray-400 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }}"
                                            required>
                                    @error('email')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Step 2: Shipping Details --}}
                        <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-sm border border-gray-200/60" 
                             x-data="regionalSelector(
                                '{{ old('province_id', auth()->user()->province_id ?? '') }}', 
                                '{{ old('city_id', auth()->user()->city_id ?? '') }}'
                            )">
                            
                            <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center gap-3 border-b border-gray-100 pb-4">
                                <span class="w-8 h-8 bg-brand-dark text-white rounded-lg flex items-center justify-center text-sm font-bold">2</span>
                                {{ __('Shipping Details') }}
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('First Name') }} <span class="text-red-500">*</span></label>
                                    <input type="text" name="first_name" value="{{ old('first_name', auth()->check() ? explode(' ', auth()->user()->name)[0] : '') }}" 
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-1 focus:ring-brand-primary transition placeholder-gray-400" required>
                                </div>
                                
                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Last Name') }} <span class="text-red-500">*</span></label>
                                    <input type="text" name="last_name" required value="{{ auth()->check() && count(explode(' ', auth()->user()->name)) > 1 ? explode(' ', auth()->user()->name)[1] : old('last_name') }}" 
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-1 focus:ring-brand-primary transition placeholder-gray-400">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Full Address') }} <span class="text-red-500">*</span></label>
                                    <input type="text" name="address" value="{{ old('address', auth()->user()->address ?? '') }}" 
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-1 focus:ring-brand-primary transition placeholder-gray-400" 
                                        required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Province') }} <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="province_name" id="province_name" value="{{ old('province_name', auth()->user()->province->name ?? '') }}">
                                    
                                    <div class="relative">
                                        <select name="province_id" 
                                                x-model="selectedProvince"
                                                @change="fetchCities($event.target.value); updateName($event, 'province_name')"
                                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-1 focus:ring-brand-primary transition appearance-none cursor-pointer">
                                            <option value="">{{ __('Select Province') }}</option>
                                            @foreach($provinces as $prov)
                                                <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('province_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="md:col-span-1 relative">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('City / District') }} <span class="text-red-500">*</span></label>
                                    <input type="hidden" name="city_name" id="city_name" value="{{ old('city_name') }}">

                                    <div class="relative">
                                        <select name="city_id" 
                                                x-model="selectedCity"
                                                @change="updateName($event, 'city_name')"
                                                :disabled="!selectedProvince || isLoadingCity"
                                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-1 focus:ring-brand-primary transition appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                            <option value="">{{ __('Select City') }}</option>
                                            <template x-for="city in cities" :key="city.id">
                                                <option :value="city.id" x-text="city.name" :selected="city.id == selectedCity"></option>
                                            </template>
                                        </select>
                                    </div>
                                    
                                    <div x-show="isLoadingCity" class="absolute right-10 top-[40px]" style="display: none;">
                                        <svg class="animate-spin h-4 w-4 text-brand-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    @error('city_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Postal Code') }} <span class="text-red-500">*</span></label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code', auth()->user()->postal_code ?? '') }}" 
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-1 focus:ring-brand-primary transition placeholder-gray-400" required>
                                </div>

                                <div class="md:col-span-1">
                                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">{{ __('Phone Number') }} <span class="text-red-500">*</span></label>
                                    <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" 
                                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-1 focus:ring-brand-primary transition placeholder-gray-400" required>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-100 p-6 rounded-2xl border border-gray-200 text-center text-sm text-slate-500">
                            <p>{!! __('Payment will be processed securely via <strong>Midtrans Payment Gateway</strong> after you click "Place Order".') !!}</p>
                        </div>
                    </div>

                    {{-- RIGHT: SUMMARY --}}
                    <div class="lg:col-span-5 sticky top-32">
                        {{-- REVISI: Background Hijau Polos (Clean) --}}
                        <div class="bg-brand-primary text-white rounded-[2rem] shadow-2xl p-8 relative overflow-hidden group">
                            
                            <h3 class="font-black text-xl text-white mb-6 uppercase tracking-wide border-b border-white/20 pb-4">{{ __('Order Summary') }}</h3>
                            
                            <div class="space-y-4 mb-6 max-h-64 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($cartItems as $item)
                                    <div class="flex gap-4 group/item">
                                        <div class="w-16 h-16 bg-white rounded-lg p-2 flex-shrink-0 border border-white/20 flex items-center justify-center">
                                            @php
                                                $img = $item->product->images->where('is_primary', true)->first() 
                                                    ?? $item->product->images->first();
                                                $imgUrl = $img ? asset('storage/' . $img->image_path) : asset('assets/web/images/placeholder.png');
                                            @endphp
                                            <img src="{{ $imgUrl }}" class="w-full h-full object-contain mix-blend-multiply">
                                        </div>
                                        <div class="flex-1">
                                            <h4 class="font-bold text-sm text-white line-clamp-1">{{ $item->product->name }}</h4>
                                            @if($item->variant)
                                                <p class="text-xs text-white/70">{{ $item->variant->name }}</p>
                                            @endif
                                            <p class="text-xs font-bold text-white/60 mt-1">Qty: {{ $item->qty }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-bold text-sm text-white">
                                                Rp {{ number_format($item->variant ? $item->variant->price * $item->qty : ($item->product->final_price ?? $item->product->price) * $item->qty, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-3 text-sm text-white/90 mb-8 border-t border-b border-white/20 py-6 font-medium">
                                <div class="flex justify-between">
                                    <span>{{ __('Subtotal') }}</span>
                                    <span class="font-bold text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>{{ __('Shipping (Flat)') }}</span>
                                    <span class="font-bold text-white">Rp {{ number_format($shippingFee, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>{{ __('Tax (11%)') }}</span>
                                    <span class="font-bold text-white">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-end mb-8">
                                <span class="font-bold text-lg text-white uppercase tracking-wider">{{ __('Total Pay') }}</span>
                                <span class="text-3xl font-black text-white tracking-tight">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            {{-- REVISI: Tombol Putih Solid --}}
                            <button type="submit" 
                                :disabled="isProcessing"
                                :class="isProcessing ? 'bg-gray-200 cursor-not-allowed text-gray-500' : 'bg-white hover:bg-brand-dark hover:text-white text-brand-dark shadow-lg hover:-translate-y-1'"
                                class="w-full py-4 rounded-xl font-bold uppercase tracking-widest text-sm text-center transition-all duration-300 flex items-center justify-center gap-3">
                            
                                <span x-show="!isProcessing">{{ __('Place Order & Pay') }}</span>
                                
                                <span x-show="isProcessing" x-cloak class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    {{ __('Processing...') }}
                                </span>
                            </button>

                            <p class="text-[10px] text-white/60 text-center mt-4 leading-relaxed">
                                {!! __('By placing your order, you agree to our <a href="#" class="underline hover:text-white">Terms of Service</a>.') !!}
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('regionalSelector', (initialProvinceId = null, initialCityId = null) => ({
                    selectedProvince: initialProvinceId,
                    selectedCity: initialCityId,
                    cities: [],
                    isLoadingCity: false,

                    init() {
                        if (this.selectedProvince) {
                            this.fetchCities(this.selectedProvince);
                            this.$nextTick(() => {
                                const provSelect = document.querySelector('select[name="province_id"]');
                                if(provSelect && provSelect.selectedOptions.length > 0) {
                                    this.updateHiddenInput('province_name', provSelect.selectedOptions[0].text);
                                }
                            });
                        }
                    },

                    async fetchCities(provinceId) {
                        if (!provinceId) {
                            this.cities = [];
                            this.selectedCity = '';
                            this.updateHiddenInput('province_name', '');
                            this.updateHiddenInput('city_name', '');
                            return;
                        }

                        this.isLoadingCity = true;
                        this.cities = [];

                        try {
                            const response = await fetch(`/api/cities/${provinceId}`);
                            const data = await response.json();
                            this.cities = data;
                            
                            if (this.selectedCity) {
                                const selectedCityObj = this.cities.find(c => c.id == this.selectedCity);
                                if (selectedCityObj) {
                                    this.updateHiddenInput('city_name', selectedCityObj.name);
                                } else {
                                    this.selectedCity = '';
                                    this.updateHiddenInput('city_name', '');
                                }
                            }
                        } catch (error) {
                            console.error('Failed to load cities:', error);
                        } finally {
                            this.isLoadingCity = false;
                        }
                    },

                    updateName(event, targetInputId) {
                        const select = event.target;
                        if (select.selectedIndex >= 0) {
                            const text = select.options[select.selectedIndex].text;
                            this.updateHiddenInput(targetInputId, text);
                        }
                    },

                    updateHiddenInput(id, value) {
                        const el = document.getElementById(id);
                        if(el) el.value = value;
                    }
                }));
            });
        </script>
    @endpush

</x-web.main-layout>