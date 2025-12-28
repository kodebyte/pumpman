<nav x-data="{ searchOpen: false, mobileOpen: false }" id="navbar" 
     class="sticky top-0 z-40 w-full bg-white/80 backdrop-blur-lg border-b border-white/20 shadow-sm transition-transform duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] supports-[backdrop-filter]:bg-white/60"
     @keydown.escape.window="searchOpen = false; mobileOpen = false">

    <div class="bg-brand-dark text-white/90 text-xs py-3 px-4 hidden md:block font-medium tracking-wide relative z-[60]">
        <div class="container mx-auto flex justify-between items-center px-4 md:px-6">
            {{-- Left: Trust Signals --}}
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-2">
                    <i data-lucide="check-circle" class="w-3.5 h-3.5 text-white"></i> 
                    <span>{{ __('100% Original Products') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i data-lucide="truck" class="w-3.5 h-3.5 text-white"></i> 
                    <span>{{ __('Free Shipping Jabodetabek*') }}</span>
                </div>
            </div>
            {{-- Right: Utility Links --}}
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-white transition">{{ __('Track Order') }}</a>
                <a href="#" class="hover:text-white transition">{{ __('Help Center') }}</a>
                @guest
                    <a href="{{ route('login') }}" class="text-white font-bold">{{ __('Login / Register') }}</a>
                @endguest
            </div>
        </div>
    </div>

    <div class="border-b border-gray-100/50 relative z-[60] bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-center h-20 gap-8">
                
                {{-- LOGO --}}
                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2">
                    <img src="{{ asset('assets/web/images/logo.png') }}" class="w-64" alt="">
                </a>

                {{-- SEARCH BAR (Desktop) --}}
                <div class="hidden md:flex flex-1 max-w-2xl relative group">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-lucide="search" class="h-5 w-5 text-gray-400 group-focus-within:text-brand-primary transition"></i>
                    </div>
                    <form action="{{ route('products.index') }}" method="GET" class="w-full">
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="block w-full pl-11 pr-4 py-3 bg-brand-input border-transparent rounded-full text-sm placeholder-gray-400 focus:bg-white focus:border-brand-primary focus:ring-4 focus:ring-brand-primary/10 transition-all duration-300" 
                               placeholder="{{ __('Search...') }}">
                    </form>
                </div>
                
                {{-- ICONS AREA --}}
                <div class="flex items-center gap-2 sm:gap-4">
                    
                    {{-- Language Switcher (Desktop) --}}
                    <div class="hidden md:flex items-center gap-2 text-xs font-bold border-r border-gray-200 pr-6 mr-2 h-5 text-slate-500">
                        <a href="{{ route('set-locale', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-brand-primary' : 'hover:text-brand-primary opacity-50' }} transition">EN</a>
                        <span class="opacity-30">/</span>
                        <a href="{{ route('set-locale', 'id') }}" class="{{ app()->getLocale() == 'id' ? 'text-brand-primary' : 'hover:text-brand-primary opacity-50' }} transition">ID</a>
                    </div>

                    {{-- User Dropdown --}}
                    <div class="relative group/user z-50">
                        <a href="{{ route('login') }}" class="relative p-2.5 rounded-full hover:bg-gray-100 transition text-slate-600 block">
                            <i data-lucide="user" class="w-6 h-6 group-hover/user:text-brand-primary transition"></i>
                        </a>
                        <div class="absolute right-0 top-full pt-4 opacity-0 invisible group-hover/user:opacity-100 group-hover/user:visible transition-all duration-300 transform translate-y-2 group-hover/user:translate-y-0 z-50">
                            <div class="bg-white text-black shadow-lg rounded-lg border border-gray-100 w-48 overflow-hidden py-1">
                                @auth
                                    <div class="px-4 py-3 border-b border-gray-100">
                                        <p class="text-xs text-gray-500">{{ __('Hello') }},</p>
                                        <p class="text-sm font-bold truncate">{{ Auth::user()->name }}</p>
                                    </div>
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-50 hover:text-brand-primary">{{ __('Dashboard') }}</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold">{{ __('Logout') }}</button>
                                    </form>
                                @else
                                    <div class="px-4 py-3 text-center">
                                        <p class="text-xs text-gray-500 mb-3">{{ __('Login to access your account') }}</p>
                                        <a href="{{ route('login') }}" class="block w-full bg-brand-primary text-white text-xs font-bold py-2 rounded hover:bg-slate-900 transition mb-2 text-center">{{ __('LOGIN') }}</a>
                                        <a href="{{ route('register') }}" class="block w-full border border-gray-300 text-slate-900 text-xs font-bold py-2 rounded hover:border-slate-900 transition text-center">{{ __('REGISTER') }}</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>

                    {{-- Cart Dropdown (Alpine) --}}
                    <div class="relative group/cart z-50" x-data @mouseenter="$store.cart.onHover()">
                        <a href="{{ route('cart.index') }}" id="cart-icon-target" class="relative p-2.5 rounded-full hover:bg-gray-100 transition text-slate-600 block">
                            <i data-lucide="shopping-bag" class="w-6 h-6 group-hover/cart:text-brand-primary transition"></i>
                            <span x-show="$store.cart.count > 0" 
                                  x-transition.scale
                                  class="absolute top-1 right-1 bg-brand-primary text-white text-[10px] w-4 h-4 rounded-full flex items-center justify-center font-bold shadow-sm"
                                  x-text="$store.cart.count"></span>
                        </a>
                        
                        {{-- Dropdown Content --}}
                        <div class="absolute right-0 top-full pt-4 opacity-0 invisible group-hover/cart:opacity-100 group-hover/cart:visible transition-all duration-300 transform translate-y-2 group-hover/cart:translate-y-0 z-50">
                            <div class="bg-white text-black shadow-2xl rounded-xl border border-gray-100 w-80 md:w-96 overflow-hidden">
                                <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                                    <span class="text-sm font-bold text-gray-700">{{ __('Shopping Cart') }}</span>
                                    <span class="text-xs font-medium text-gray-500" x-text="$store.cart.count + ' {{ __('Items') }}'"></span>
                                </div>

                                <div class="max-h-64 overflow-y-auto scrollbar-hide px-5 pb-5 space-y-5 relative">
                                    {{-- Loading --}}
                                    <div x-show="$store.cart.loading" class="absolute inset-0 bg-white/80 z-10 flex items-center justify-center">
                                        <svg class="animate-spin h-6 w-6 text-brand-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>

                                    {{-- Empty --}}
                                    <template x-if="$store.cart.items.length === 0 && !$store.cart.loading">
                                        <div class="p-8 text-center">
                                            <div class="mx-auto w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                                <i data-lucide="shopping-cart" class="w-6 h-6 text-gray-400"></i>
                                            </div>
                                            <p class="text-sm text-gray-500 font-medium mb-4">{{ __('Your cart is empty') }}</p>
                                            <a href="{{ route('products.index') }}" class="text-xs font-bold text-brand-primary hover:underline">{{ __('Start Shopping') }} &rarr;</a>
                                        </div> 
                                    </template>

                                    {{-- Items --}}
                                    <template x-for="item in $store.cart.items" :key="item.id">
                                        <div class="flex items-start gap-4 group/item relative border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                                            <div class="w-16 h-16 bg-gray-50 rounded-lg border border-gray-100 flex-shrink-0 flex items-center justify-center overflow-hidden">
                                                <img :src="item.image" class="w-full h-full object-contain mix-blend-multiply">
                                            </div>
                                            <div class="flex flex-1 flex-col justify-between py-0.5">
                                                <div>
                                                    <h3 class="line-clamp-1 text-sm font-bold text-gray-900"><a href="#" class="hover:text-brand-primary transition" x-text="item.name"></a></h3>
                                                    <p x-show="item.variant_name" class="mt-1 text-[10px] text-gray-500 uppercase tracking-wider" x-text="item.variant_name"></p>
                                                </div>
                                                <div class="flex items-end justify-between text-xs mt-2">
                                                    <div class="flex items-center gap-2">
                                                        <span class="text-gray-400">Qty <span x-text="item.qty"></span></span>
                                                        <span class="font-bold text-black" x-text="item.price_formatted"></span>
                                                    </div>
                                                    <button @click="$store.cart.removeItem(item.id, item.remove_url)" type="button" class="font-medium text-red-400 hover:text-red-600 transition flex items-center gap-1 text-[10px] uppercase tracking-wider">
                                                        {{ __('Remove') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>

                                <div class="border-t border-gray-100 bg-gray-50 px-5 py-5 space-y-4" x-show="$store.cart.items.length > 0">
                                    <div class="flex justify-between text-base font-bold text-gray-900">
                                        <p>{{ __('Subtotal') }}</p>
                                        <p x-text="$store.cart.subtotal"></p>
                                    </div>
                                    <div class="mt-6 grid grid-cols-2 gap-3">
                                        <a href="{{ route('cart.index') }}" class="flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-xs font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition">{{ __('View Cart') }}</a>
                                        <a href="{{ route('cart.checkout') }}" class="flex items-center justify-center rounded-lg border border-transparent bg-brand-primary px-4 py-2.5 text-xs font-bold text-white shadow-sm hover:bg-green-700 transition">{{ __('Checkout') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mobile Menu Trigger --}}
                    <button id="mobile-menu-btn" @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-slate-700 ml-2 hover:text-brand-primary transition">
                        <i x-show="!mobileOpen" data-lucide="menu" class="h-7 w-7"></i>
                        <i x-show="mobileOpen" data-lucide="x" class="h-7 w-7" style="display: none;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================================
         3. DESKTOP NAVIGATION & MEGA MENU
         ====================================================================== --}}
    <div class="hidden md:block bg-white/50 relative border-b border-gray-100">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex h-14 items-center text-sm font-bold tracking-wide text-slate-700">
                
                {{-- Mega Menu Trigger --}}
                <div id="mega-menu-trigger" class="h-full flex items-center mr-8">
                    <div class="relative group h-full flex items-center cursor-pointer px-3 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                        <div class="flex items-center gap-2 text-slate-800 font-bold">
                            <i data-lucide="layout-grid" class="w-5 h-5 text-brand-primary"></i>
                            <span class="uppercase">{{ __('Shop Categories') }}</span>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 group-hover:text-brand-primary transition-transform group-hover:rotate-180"></i>
                        </div>
                    </div>
                    
                    {{-- Mega Menu Content --}}
                    <div id="mega-menu-content" class="absolute top-full left-0 w-full bg-white shadow-xl border-t border-gray-100 z-50">
                        <div class="container mx-auto px-8 py-10">
                            <div class="grid grid-cols-12 gap-10">
                                
                                {{-- COL 1: CATEGORY LIST (Dynamic) --}}
                                <div class="col-span-3 border-r border-gray-100 pr-6">
                                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 flex items-center gap-2">
                                        <i data-lucide="list" class="w-4 h-4"></i> {{ __('Browse Category') }}
                                    </h3>
                                    <ul class="space-y-4">
                                        @if(isset($menuCategories))
                                            @foreach($menuCategories as $_menuCategory)
                                                <li>
                                                    <a href="{{ route('products.category', $_menuCategory->slug) }}" class="group/link flex items-center justify-between text-base font-bold text-gray-600 hover:text-brand-primary transition-all">
                                                        <span>{{ $_menuCategory->getTranslation('name') }}</span>
                                                        <i data-lucide="chevron-right" class="w-4 h-4 opacity-0 -translate-x-2 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all"></i>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            {{-- Fallback Links --}}
                                            <li><a href="#" class="text-base font-bold text-gray-600 hover:text-brand-primary">Centrifugal Pumps</a></li>
                                            <li><a href="#" class="text-base font-bold text-gray-600 hover:text-brand-primary">Submersible Pumps</a></li>
                                            <li><a href="#" class="text-base font-bold text-gray-600 hover:text-brand-primary">Dosing Pumps</a></li>
                                            <li><a href="#" class="text-base font-bold text-gray-600 hover:text-brand-primary">Spare Parts</a></li>
                                        @endif
                                    </ul>
                                    <div class="mt-6 pt-6 border-t border-gray-100">
                                        <a href="{{ route('products.index') }}" class="text-sm font-bold text-slate-900 border-b-2 border-black hover:text-brand-primary hover:border-brand-primary transition pb-1 inline-flex items-center gap-2">
                                            {{ __('View All Products') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                        </a>
                                    </div>
                                </div>

                                {{-- COL 2: NEW ARRIVAL (Static Fallback / Dynamic Check) --}}
                                <div class="col-span-3">
                                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">{{ __('New Arrival') }}</h3>
                                    {{-- Cek jika variable ada (Optional), jika tidak tampilkan static --}}
                                    <a href="#" class="group/card block h-full">
                                        <div class="bg-gray-50 rounded-2xl p-6 h-48 flex items-center justify-center relative overflow-hidden mb-4 border border-gray-100 group-hover/card:border-brand-primary/30 transition">
                                            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-white rounded-full shadow-sm z-0"></div>
                                            <img src="https://images.unsplash.com/photo-1563823251954-c81b2195dfa6?q=80&w=2072&auto=format&fit=crop" class="w-40 max-h-40 object-contain relative z-10 drop-shadow-xl transform group-hover/card:scale-110 transition duration-500" alt="New Arrival">
                                            <div class="absolute top-4 left-4 bg-black text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">{{ __('New') }}</div>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 group-hover/card:text-brand-primary transition line-clamp-1">Submersible Pro X1</h4>
                                            <p class="text-sm text-gray-500 mt-1 line-clamp-1">Industrial Series</p>
                                        </div>
                                    </a>
                                </div>

                                {{-- COL 3: BEST SELLER --}}
                                <div class="col-span-3">
                                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">{{ __('Best Seller') }}</h3>
                                    <a href="#" class="group/card block h-full">
                                        <div class="bg-gray-50 rounded-2xl p-6 h-48 flex items-center justify-center relative overflow-hidden mb-4 border border-gray-100 group-hover/card:border-brand-primary/30 transition">
                                            <img src="https://images.unsplash.com/photo-1574360778004-946766d61665?q=80&w=1974&auto=format&fit=crop" class="w-full h-full object-cover relative z-10 drop-shadow-xl transform group-hover/card:scale-105 transition duration-500 rounded-lg" alt="Best Seller">
                                            <div class="absolute top-4 left-4 bg-brand-primary text-white text-[10px] font-bold px-2 py-1 rounded uppercase tracking-wider">{{ __('Hot') }}</div>
                                        </div>
                                        <div>
                                            <h4 class="text-lg font-bold text-gray-900 group-hover/card:text-brand-primary transition line-clamp-1">Centrifugal Heavy Duty</h4>
                                            <p class="text-sm text-gray-500 mt-1 line-clamp-1">Water Supply</p>
                                        </div>
                                    </a>
                                </div>

                                {{-- COL 4: PROMO BANNER --}}
                                <div class="col-span-3">
                                    <div class="bg-slate-900 rounded-2xl h-full p-8 flex flex-col justify-between relative overflow-hidden group/banner shadow-lg">
                                        <div class="absolute top-0 right-0 w-48 h-48 bg-brand-primary rounded-full blur-[80px] opacity-30 group-hover/banner:opacity-40 transition duration-700"></div>
                                        <div class="relative z-10">
                                            <span class="bg-white/20 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1 rounded-full mb-4 inline-block border border-white/10">{{ __('LIMITED OFFER') }}</span>
                                            <h3 class="text-2xl font-black text-white leading-tight mb-2">Year End <br><span class="text-brand-accent">Service Sale</span></h3>
                                            <p class="text-sm text-gray-400 leading-relaxed">{{ __('Get 30% off for maintenance & spare parts.') }}</p>
                                        </div>
                                        <div class="relative z-10 mt-6">
                                            <a href="#" class="bg-white text-black text-xs font-bold px-6 py-3 rounded-full hover:bg-gray-200 transition inline-flex items-center gap-2">
                                                {{ __('Book Now') }} <i data-lucide="arrow-right" class="w-3 h-3"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Standard Links --}}
                <div class="flex items-center gap-8 text-slate-700">
                    <a href="{{ route('home') }}" class="hover:text-brand-primary transition uppercase">{{ __('Home') }}</a>
                    <a href="{{ route('pages.about') }}" class="hover:text-brand-primary transition uppercase">{{ __('About Us') }}</a>
                    <a href="{{ route('pages.contact') }}" class="hover:text-brand-primary transition uppercase">{{ __('Contact Us') }}</a>
                    <a href="{{ route('stores.index') }}" class="hover:text-brand-primary transition uppercase">{{ __('Find a Store') }}</a>
                    
                    {{-- Support Dropdown --}}
                    <div class="relative group h-14 flex items-center">
                        <a href="#" class="hover:text-brand-primary transition uppercase flex items-center gap-1 cursor-pointer">
                            {{ __('Support') }} <i data-lucide="chevron-down" class="w-4 h-4 transition-transform group-hover:rotate-180"></i>
                        </a>
                        <div class="absolute right-0 top-full pt-0 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 min-w-[220px] z-50">
                            <div class="bg-white text-slate-800 shadow-xl rounded-lg border border-gray-100 overflow-hidden py-2 mt-0">
                                <a href="{{ route('faqs.index') }}" class="flex items-center gap-3 px-6 py-3 text-sm font-bold hover:bg-gray-50 hover:text-brand-primary transition group/item"><i data-lucide="help-circle" class="w-4 h-4 text-gray-400 group-hover/item:text-brand-primary"></i> {{ __('FAQ') }}</a>
                                <a href="{{ route('warranty-claim') }}" class="flex items-center gap-3 px-6 py-3 text-sm font-bold hover:bg-gray-50 hover:text-brand-primary transition group/item"><i data-lucide="shield-check" class="w-4 h-4 text-gray-400 group-hover/item:text-brand-primary"></i> {{ __('Warranty Claim') }}</a>
                                <a href="{{ route('warranty-claim.check') }}" class="flex items-center gap-3 px-6 py-3 text-sm font-bold hover:bg-gray-50 hover:text-aiwaRed transition group/item"><i data-lucide="search" class="w-4 h-4 text-gray-400 group-hover/item:text-aiwaRed"></i> {{ __('Claim Status') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ======================================================================
         4. MOBILE MENU (OFF-CANVAS) - Integrated from Aiwa
         ====================================================================== --}}
    <div x-show="mobileOpen" 
         x-transition:enter="transition transform ease-[cubic-bezier(0.25,1,0.5,1)] duration-500"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition transform ease-[cubic-bezier(0.25,1,0.5,1)] duration-500"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="fixed inset-0 bg-white text-slate-800 z-50 pt-28 px-6 overflow-y-auto md:hidden flex flex-col h-screen"
         style="display: none;">
         
         <div class="flex flex-col pb-20">
            
            {{-- Mobile Search --}}
            <div class="mb-8">
                <form action="{{ route('products.index') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full bg-gray-50 border border-gray-200 text-slate-800 text-sm py-3 px-4 rounded-xl focus:outline-none focus:border-brand-primary focus:ring-1 focus:ring-brand-primary transition-colors" 
                           placeholder="{{ __('Search products...') }}">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </button>
                </form>
            </div>

            {{-- Links --}}
            <div class="border-b border-gray-100 py-5">
                <a href="{{ route('home') }}" class="block w-full text-2xl font-black uppercase tracking-tight hover:text-brand-primary transition-colors">{{ __('Home') }}</a>
            </div>
            
            {{-- PRODUCTS (Accordion) --}}
            <div x-data="{ open: false }" class="border-b border-gray-100 py-5">
                <button @click="open = !open" class="flex justify-between items-center w-full text-2xl font-black uppercase tracking-tight hover:text-brand-primary text-left transition-colors">
                    {{ __('Products') }} 
                    <i data-lucide="chevron-down" class="w-6 h-6 transition-transform duration-300" :class="open ? 'rotate-180 text-brand-primary' : 'text-gray-400'"></i>
                </button>
                <div x-show="open" x-collapse.duration.500ms class="mt-4 space-y-4 pl-1">
                    @if(isset($menuCategories))
                        @foreach($menuCategories as $_menuCategory)
                            <a href="{{ route('products.category', $_menuCategory->slug) }}" class="block text-base font-bold text-gray-500 hover:text-brand-primary pl-4 border-l-2 border-gray-100 hover:border-brand-primary transition-all">
                                {{ $_menuCategory->getTranslation('name') }}
                            </a>
                        @endforeach
                    @else
                         {{-- Static Fallback --}}
                         <a href="#" class="block text-base font-bold text-gray-500 hover:text-brand-primary pl-4 border-l-2 border-gray-100 hover:border-brand-primary">Centrifugal Pumps</a>
                         <a href="#" class="block text-base font-bold text-gray-500 hover:text-brand-primary pl-4 border-l-2 border-gray-100 hover:border-brand-primary">Submersible Pumps</a>
                    @endif
                    <a href="{{ route('products.index') }}" class="block text-base font-black text-slate-900 hover:text-brand-primary pl-4 border-l-2 border-transparent mt-6">{{ __('View All Products') }} →</a>
                </div>
            </div>

            <div class="border-b border-gray-100 py-5">
                <a href="{{ route('pages.about') }}" class="block w-full text-2xl font-black uppercase tracking-tight hover:text-brand-primary transition-colors">{{ __('About Us') }}</a>
            </div>

            <div class="border-b border-gray-100 py-5">
                <a href="{{ route('pages.contact') }}" class="block w-full text-2xl font-black uppercase tracking-tight hover:text-brand-primary transition-colors">{{ __('Contact Us') }}</a>
            </div>

            <div class="border-b border-gray-100 py-5">
                <a href="{{ route('stores.index') }}" class="block w-full text-2xl font-black uppercase tracking-tight hover:text-brand-primary transition-colors">{{ __('Find a Store') }}</a>
            </div>

            {{-- SUPPORT (Accordion) --}}
            <div x-data="{ openSupport: false }" class="border-b border-gray-100 py-5">
                <button @click="openSupport = !openSupport" class="flex justify-between items-center w-full text-2xl font-black uppercase tracking-tight hover:text-brand-primary text-left transition-colors">
                    {{ __('Support') }}
                    <i data-lucide="chevron-down" class="w-6 h-6 transition-transform duration-300" :class="openSupport ? 'rotate-180 text-brand-primary' : 'text-gray-400'"></i>
                </button>
                <div x-show="openSupport" x-collapse.duration.500ms class="mt-4 space-y-4 pl-1">
                    <a href="{{ route('faqs.index') }}" class="block text-base font-bold text-gray-500 hover:text-brand-primary pl-4 border-l-2 border-gray-100 hover:border-brand-primary transition-all">{{ __('FAQ') }}</a>
                    <a href="{{ route('warranty-claim') }}" class="block text-base font-bold text-gray-500 hover:text-brand-primary pl-4 border-l-2 border-gray-100 hover:border-brand-primary transition-all">{{ __('Warranty Claim') }}</a>
                </div>
            </div>

            {{-- MOBILE LANGUAGE SWITCHER --}}
            <div class="border-b border-gray-100 py-5 flex items-center gap-4">
                <span class="text-sm font-bold text-gray-400 uppercase tracking-wider">{{ __('Language') }}:</span>
                <div class="flex items-center gap-2">
                    <a href="{{ route('set-locale', 'en') }}" class="px-4 py-2 rounded-lg border {{ app()->getLocale() == 'en' ? 'bg-brand-primary text-white border-brand-primary' : 'border-gray-200 text-gray-500' }} text-xs font-bold transition">English</a>
                    <a href="{{ route('set-locale', 'id') }}" class="px-4 py-2 rounded-lg border {{ app()->getLocale() == 'id' ? 'bg-brand-primary text-white border-brand-primary' : 'border-gray-200 text-gray-500' }} text-xs font-bold transition">Indonesia</a>
                </div>
            </div>

            {{-- AUTH BUTTONS --}}
            <div class="pt-8 grid grid-cols-2 gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="col-span-2 text-center bg-brand-dark text-white font-bold py-4 rounded-xl shadow-lg hover:bg-brand-primary transition-colors">{{ __('My Dashboard') }}</a>
                @else
                    <a href="{{ route('login') }}" class="text-center border-2 border-slate-900 text-slate-900 font-bold py-3 rounded-xl hover:bg-gray-50 transition-colors">{{ __('Login') }}</a>
                    <a href="{{ route('register') }}" class="text-center bg-brand-dark text-white font-bold py-3 rounded-xl shadow-lg hover:bg-brand-primary transition-colors">{{ __('Register') }}</a>
                @endauth
            </div>
        </div>
    </div>

    {{-- ======================================================================
         5. SEARCH MODAL OVERLAY (Optional but kept for compatibility)
         ====================================================================== --}}
    <div x-show="searchOpen" 
         x-transition:enter="transition ease-[cubic-bezier(0.16,1,0.3,1)] duration-500"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-[cubic-bezier(0.16,1,0.3,1)] duration-300"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 bg-slate-900 z-[100] overflow-y-auto"
         style="display: none;">
        
        <button @click="searchOpen = false" class="absolute top-6 right-6 md:top-8 md:right-8 group p-2 rounded-full hover:bg-white/10 transition z-50">
            <span class="sr-only">{{ __('Close') }}</span>
            <i data-lucide="x" class="w-6 h-6 text-gray-400 group-hover:text-white transition-colors duration-300"></i>
        </button>

        <div class="container mx-auto px-6 pt-24 pb-12 flex flex-col items-center">
            <div class="w-full max-w-2xl text-center mb-12" @click.away="searchOpen = false">
                <label for="search-input" class="block text-brand-primary font-bold tracking-widest uppercase mb-6 text-[10px] animate-fade-in-up">{{ __('What are you looking for?') }}</label>
                <div class="relative group mb-8">
                    <form action="{{ route('products.index') }}" method="GET" class="relative group mb-8">
                        <input x-ref="searchInput" type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Type product name...') }}" 
                            class="w-full bg-transparent border-b border-gray-700 text-white text-2xl md:text-3xl font-bold py-4 px-2 focus:outline-none focus:border-brand-primary focus:ring-0 transition-colors placeholder-gray-600 text-center rounded-xl" autocomplete="off">
                        <button type="submit" class="hidden md:block absolute right-0 top-1/2 -translate-y-1/2 p-2 hover:text-brand-primary transition-colors text-gray-600 group-focus-within:text-white">
                            <i data-lucide="search" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.store('cart', {
                    // Pastikan class helper ada, atau ganti dengan angka 0 jika error
                    count: {{ \App\Helpers\CartHelper::count() ?? 0 }}, 
                    items: [], 
                    subtotal: 'Rp 0',
                    loading: false,
                    hasLoaded: false,
                    
                    updateCount(newCount) { this.count = newCount; this.fetchCart(true); },
                    onHover() { if (!this.hasLoaded) { this.fetchCart(); } },
                    async fetchCart(force = false) {
                        if (this.loading) return;
                        this.loading = true;
                        try {
                            const response = await fetch('{{ route('cart.data') }}'); 
                            if (!response.ok) throw new Error('Network error');
                            const data = await response.json();
                            this.count = data.count; this.items = data.items; this.subtotal = data.subtotal;
                            this.hasLoaded = true;
                        } catch (error) { console.error('Failed to fetch cart:', error); } finally { this.loading = false; }
                    },
                    async removeItem(id, url) {
                        try {
                            if(confirm("{{ __('Are you sure to remove this product?') }}")) {
                                const response = await fetch(url, {
                                    method: 'DELETE',
                                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }
                                });
                                const result = await response.json();
                                if (result.success) { this.fetchCart(); }
                            }
                        } catch (error) { console.error('Error removing item:', error); }
                    }
                });
            });
        </script>
    @endpush
</nav>