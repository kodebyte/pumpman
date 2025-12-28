<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('My Account') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Account Settings') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Manage your personal profile, security settings, and shipping addresses for future procurement.') }}
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

                {{-- MAIN FORM --}}
                <div class="lg:col-span-3 space-y-8">
                    
                    {{-- Alert Success --}}
                    @if(session('success'))
                        <div x-data="{ show: true }" x-show="show" class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-[1.5rem] flex items-center justify-between animate-fade-in-up shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="bg-green-100 p-1.5 rounded-full">
                                    <i data-lucide="check-circle" class="w-5 h-5 text-green-600"></i>
                                </div>
                                <span class="font-bold text-sm">{{ session('success') }}</span>
                            </div>
                            <button @click="show = false" class="hover:text-green-900 transition"><i data-lucide="x" class="w-4 h-4"></i></button>
                        </div>
                    @endif

                    {{-- 1. PROFILE SETTINGS --}}
                    <div class="bg-white border border-gray-200/60 rounded-[2rem] shadow-sm p-8 md:p-10 relative overflow-hidden group">
                        {{-- Aksen Dekoratif --}}
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-brand-dark"></div>
                        
                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight border-b border-gray-100 pb-6 mb-8 flex items-center gap-3">
                            <span class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-brand-primary border border-gray-100">
                                <i data-lucide="user-cog" class="w-5 h-5"></i>
                            </span>
                            {{ __('Profile Information') }}
                        </h3>

                        {{-- Pastikan route ini sesuai dengan route Anda, misal: 'profile.update' --}}
                        <form action="{{ route('account.update.profile') }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">{{ __('Full Name') }}</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary bg-gray-50 focus:bg-white text-slate-900 font-bold text-sm transition placeholder-gray-300">
                                    @error('name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">{{ __('Phone Number') }}</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary bg-gray-50 focus:bg-white text-slate-900 font-bold text-sm transition placeholder-gray-300">
                                    @error('phone') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">{{ __('Email Address') }}</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary bg-gray-50 focus:bg-white text-slate-900 font-bold text-sm transition placeholder-gray-300">
                                    @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            {{-- Password Change Accordion --}}
                            <div x-data="{ open: false }" class="border-t border-gray-100 pt-8">
                                <button type="button" @click="open = !open" class="text-xs font-bold text-slate-500 hover:text-brand-primary flex items-center gap-2 mb-6 group focus:outline-none transition-colors">
                                    <span class="w-6 h-6 rounded bg-gray-100 flex items-center justify-center group-hover:bg-brand-soft transition">
                                        <i data-lucide="lock" class="w-3 h-3"></i>
                                    </span>
                                    <span class="uppercase tracking-wider">{{ __('Change Password?') }}</span>
                                    <i data-lucide="chevron-down" class="w-3 h-3 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                                </button>
                                
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 -translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-cloak 
                                     class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-brand-soft/30 p-8 rounded-2xl border border-brand-primary/10">
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-slate-500 tracking-wider mb-2">{{ __('New Password') }}</label>
                                        <input type="password" name="password" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary bg-white transition" placeholder="••••••••">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-slate-500 tracking-wider mb-2">{{ __('Confirm Password') }}</label>
                                        <input type="password" name="password_confirmation" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary bg-white transition" placeholder="••••••••">
                                    </div>
                                    @error('password') <p class="md:col-span-2 text-red-500 text-xs font-bold bg-white p-2 rounded border border-red-100">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="mt-8 text-right">
                                <button type="submit" class="bg-brand-dark text-white px-8 py-4 rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-brand-primary transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-2 ml-auto">
                                    {{ __('Save Changes') }} <i data-lucide="save" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- 2. SHIPPING ADDRESS --}}
                    {{-- Menggunakan Logic Alpine 'regionalSelector' --}}
                    <div class="bg-white border border-gray-200/60 rounded-[2rem] shadow-sm p-8 md:p-10 relative overflow-hidden"
                         x-data="regionalSelector(
                            '{{ old('province_id', $user->province_id ?? '') }}', 
                            '{{ old('city_id', $user->city_id ?? '') }}'
                         )">
                        {{-- Aksen Dekoratif --}}
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-brand-primary"></div>

                        <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight border-b border-gray-100 pb-6 mb-8 flex items-center gap-3">
                            <span class="w-10 h-10 bg-gray-50 rounded-xl flex items-center justify-center text-brand-primary border border-gray-100">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </span>
                            {{ __('Shipping Address') }}
                        </h3>
                        
                        {{-- Pastikan route ini sesuai dengan route Anda --}}
                        <form action="{{ route('account.update.address') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-8">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">{{ __('Full Address') }}</label>
                                    <textarea name="address" rows="3" class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary bg-gray-50 focus:bg-white text-slate-900 font-bold text-sm transition resize-none placeholder-gray-300 leading-relaxed" placeholder="{{ __('Street Name, Factory/Office Name, Unit No...') }}">{{ old('address', $user->address) }}</textarea>
                                    @error('address') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    {{-- Provinsi --}}
                                    <div>
                                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">{{ __('Province') }}</label>
                                        <div class="relative">
                                            <select name="province_id" 
                                                    x-model="selectedProvince"
                                                    @change="fetchCities($event.target.value)"
                                                    class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary bg-gray-50 focus:bg-white text-slate-900 font-bold text-sm transition appearance-none cursor-pointer">
                                                <option value="">{{ __('Select Province') }}</option>
                                                @foreach($provinces as $prov)
                                                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                                @endforeach
                                            </select>
                                            <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                                        </div>
                                        @error('province_id') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Kota --}}
                                    <div class="relative">
                                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">{{ __('City / District') }}</label>
                                        <div class="relative">
                                            <select name="city_id" 
                                                    x-model="selectedCity"
                                                    :disabled="!selectedProvince || isLoadingCity"
                                                    class="w-full px-4 py-3.5 rounded-xl border border-gray-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary bg-gray-50 focus:bg-white text-slate-900 font-bold text-sm transition appearance-none cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                                <option value="">{{ __('Select City') }}</option>
                                                <template x-for="city in cities" :key="city.id">
                                                    <option :value="city.id" x-text="city.name" :selected="city.id == selectedCity"></option>
                                                </template>
                                            </select>
                                            <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                                            
                                            <div x-show="isLoadingCity" class="absolute right-10 top-1/2 -translate-y-1/2" style="display: none;">
                                                <svg class="animate-spin h-4 w-4 text-brand-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        @error('city_id') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                    </div>

                                    {{-- Kode Pos --}}
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">{{ __('Postal Code') }}</label>
                                        <div class="relative">
                                            <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 focus:ring-1 focus:ring-brand-primary focus:border-brand-primary bg-gray-50 focus:bg-white text-slate-900 font-bold text-sm transition font-mono tracking-widest placeholder-gray-300" placeholder="1XXXX">
                                            <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"></i>
                                        </div>
                                        @error('postal_code') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 text-right">
                                <button type="submit" class="bg-brand-dark text-white px-8 py-4 rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-brand-primary transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 flex items-center gap-2 ml-auto">
                                    {{ __('Update Address') }} <i data-lucide="map" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
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
                    }
                },

                async fetchCities(provinceId) {
                    if (!provinceId) {
                        this.cities = [];
                        this.selectedCity = '';
                        return;
                    }

                    this.isLoadingCity = true;
                    this.cities = [];

                    try {
                        // Pastikan endpoint API ini sesuai dengan route Anda
                        const response = await fetch(`/api/cities/${provinceId}`);
                        const data = await response.json();
                        this.cities = data;
                        
                        // Validasi: Jika kota yang terpilih tidak ada di provinsi baru, reset
                        if (this.selectedCity) {
                            const exists = this.cities.some(c => c.id == this.selectedCity);
                            if (!exists) this.selectedCity = '';
                        }
                    } catch (error) {
                        console.error('Failed to load cities:', error);
                    } finally {
                        this.isLoadingCity = false;
                    }
                }
            }));
        });
    </script>
    @endpush

</x-web.main-layout>