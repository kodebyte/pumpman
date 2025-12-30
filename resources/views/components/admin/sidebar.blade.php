<div 
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out md:translate-x-0 md:sticky md:top-0 md:h-screen md:flex md:flex-col shadow-lg md:shadow-none"
>
    <div class="flex items-center justify-center h-16 border-b border-gray-200 px-4">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold text-xl text-gray-800">
            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span>Admin<span class="text-indigo-600">Panel</span></span>
        </a>
        
        <button @click="sidebarOpen = false" class="md:hidden ml-auto text-gray-500 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <div class="flex-1 flex flex-col overflow-y-auto py-4">
        <nav class="flex-1 px-2 space-y-1">
            
            <x-admin.nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Dashboard
            </x-admin.nav-link>

            <div class="pt-4 pb-1"><p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Product Catalog</p></div>
            
            <x-admin.nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg> Products
            </x-admin.nav-link>
            <x-admin.nav-link :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg> Categories
            </x-admin.nav-link>
            <x-admin.nav-link :href="route('admin.marketplaces.index')" :active="request()->routeIs('admin.marketplaces.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg> Marketplaces
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.clients.index')" :active="request()->routeIs('admin.clients.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                {{ __('Clients') }}
            </x-admin.nav-link>

            <div class="pt-4 pb-1">
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sales & Transactions</p>
            </div>
            
            <x-admin.nav-link :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                {{-- Icon: Clipboard List / Receipt --}}
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Orders List
                
                @if(isset($newOrdersCount) && $newOrdersCount > 0)
                    <span class="ml-auto bg-red-600 text-white py-0.5 px-2 rounded-full text-[10px] font-black animate-pulse">
                        {{ $newOrdersCount }}
                    </span>
                @endif
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.orders.report.index')" :active="request()->routeIs('admin.orders.report.*')">
                {{-- Icon: Chart Bar --}}
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Sales Report
            </x-admin.nav-link>

            <div class="pt-4 pb-1"><p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Content & Media</p></div>

            <x-admin.nav-link :href="route('admin.banners.index')" :active="request()->routeIs('admin.banners.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> Hero Banners
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.product-highlights.index')" :active="request()->routeIs('admin.product-highlights.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-7.714 2.143L11 21l-2.286-6.857L1 12l7.714-2.143L11 3z" />
                </svg>
                Product Highlights
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.post-types.index')" :active="request()->routeIs('admin.post-types.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                </svg>
                Post Types
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.posts.index')" :active="request()->routeIs('admin.posts.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg> Posts & Articles
            </x-admin.nav-link>
            
            <x-admin.nav-link :href="route('admin.faqs.index')" :active="request()->routeIs('admin.faqs.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9.247a3.75 3.75 0 015.544 0 3.75 3.75 0 01-1.114 6.22l-.234.09A2.25 2.25 0 0012 18v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zM12 21h.008v.008H12v-.008z" />
                </svg>
                FAQs
            </x-admin.nav-link>
            
            <x-admin.nav-link :href="route('admin.careers.index')" :active="request()->routeIs('admin.careers.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg> Careers
            </x-admin.nav-link>

            <div class="pt-4 pb-1"><p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Business Data</p></div>

            <x-admin.nav-link :href="route('admin.stores.index')" :active="request()->routeIs('admin.stores.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg> Store Locator
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.couriers.index')" :active="request()->routeIs('admin.couriers.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>
                Couriers
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg> Customers
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.whatsapp.index')" :active="request()->routeIs('admin.whatsapp.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                WhatsApp Contact
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.warranty-claims.index')" :active="request()->routeIs('admin.warranty-claims.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Warranty Claims

                @if(isset($pendingWarrantyCount) && $pendingWarrantyCount > 0)
                    <span class="ml-auto bg-rose-600 text-white py-0.5 px-2 rounded-full text-[10px] font-black animate-pulse">
                        {{ $pendingWarrantyCount }}
                    </span>
                @endif
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.contacts.index')" :active="request()->routeIs('admin.contacts.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 4-8-4" />
                </svg>
                Inbox Messages

                {{-- Badge Counter untuk pesan yang belum dibaca (is_read: false) --}}
                @if(isset($unreadMessagesCount) && $unreadMessagesCount > 0)
                    <span class="ml-auto bg-indigo-600 text-white py-0.5 px-2 rounded-full text-[10px] font-black animate-pulse">
                        {{ $unreadMessagesCount }}
                    </span>
                @endif
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.newsletter-subscribers.index')" :active="request()->routeIs('admin.newsletter-subscribers.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Subscribers
            </x-admin.nav-link>

            <div class="pt-4 pb-1"><p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">System</p></div>

            <x-admin.nav-link :href="route('admin.employees.index')" :active="request()->routeIs('admin.employees.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg> Employees
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.seo.index')" :active="request()->routeIs('admin.seo.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                SEO Configuration
            </x-admin.nav-link>

            <x-admin.nav-link :href="route('admin.settings.index')" :active="request()->routeIs('admin.settings.*')">
                <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                General Settings
            </x-admin.nav-link>
        </nav>
        
        <div class="border-t border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-8 w-8 rounded-full bg-gray-300" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::guard('employee')->user()->name) }}&background=random" alt="">
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-700 group-hover:text-gray-900">{{ Auth::guard('employee')->user()->name }}</p>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-700">Log out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>