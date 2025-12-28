<div class="lg:col-span-1">
    <div class="bg-white border border-gray-200/60 rounded-[2rem] shadow-sm p-8 sticky top-32">
        
        {{-- User Info Singkat --}}
        <div class="flex items-center gap-4 mb-8 pb-8 border-b border-gray-100">
            <div class="w-14 h-14 bg-brand-dark text-white rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-gray-200">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <h4 class="font-bold text-slate-900 truncate text-lg leading-tight">{{ auth()->user()->name }}</h4>
                <p class="text-xs text-slate-500 truncate font-medium">{{ auth()->user()->email }}</p>
            </div>
        </div>

        {{-- Menu Navigasi --}}
        <nav class="space-y-2">
            
            {{-- 1. DASHBOARD --}}
            <a href="{{ route('dashboard') }}" 
               class="flex items-center gap-4 px-5 py-4 font-bold rounded-xl transition-all duration-300 group {{ request()->routeIs('dashboard') ? 'bg-brand-primary text-white shadow-lg shadow-green-900/20' : 'text-slate-500 hover:bg-gray-50 hover:text-brand-primary' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-slate-400 group-hover:text-brand-primary' }} transition-colors"></i> 
                {{ __('Dashboard') }}
            </a>
            
            {{-- 2. MY ORDERS --}}
            <a href="{{ route('orders.index') }}" 
               class="flex items-center gap-4 px-5 py-4 font-bold rounded-xl transition-all duration-300 group {{ request()->routeIs('orders.*') ? 'bg-brand-primary text-white shadow-lg shadow-green-900/20' : 'text-slate-500 hover:bg-gray-50 hover:text-brand-primary' }}">
                <i data-lucide="package" class="w-5 h-5 {{ request()->routeIs('orders.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-primary' }} transition-colors"></i> 
                {{ __('My Orders') }}
            </a>

            {{-- 3. MY ACCOUNT --}}
            <a href="{{ route('account.index') }}" 
               class="flex items-center gap-4 px-5 py-4 font-bold rounded-xl transition-all duration-300 group {{ request()->routeIs('account.*') ? 'bg-brand-primary text-white shadow-lg shadow-green-900/20' : 'text-slate-500 hover:bg-gray-50 hover:text-brand-primary' }}">
                <i data-lucide="user" class="w-5 h-5 {{ request()->routeIs('account.*') ? 'text-white' : 'text-slate-400 group-hover:text-brand-primary' }} transition-colors"></i> 
                {{ __('My Account') }}
            </a>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}" class="pt-6 mt-6 border-t border-gray-100">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 px-5 py-4 text-red-500 hover:bg-red-50 font-bold rounded-xl transition-all duration-300 group">
                    <i data-lucide="log-out" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i> {{ __('Logout') }}
                </button>
            </form>
        </nav>
    </div>
</div>