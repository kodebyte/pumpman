<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Sitemap') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Site Directory') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Overview of all pages and resources available on the Pumpman Indonesia website.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <section class="bg-brand-gray pb-24 relative z-0 min-h-[600px]">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                
                {{-- CARD 1: PRODUCT CATEGORIES --}}
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-200/60 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-brand-soft flex items-center justify-center text-brand-primary group-hover:scale-110 transition-transform">
                            <i data-lucide="tag" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-black text-slate-900 uppercase tracking-wide text-sm">{{ __('Products') }}</h3>
                    </div>
                    
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('products.index') }}" class="text-sm font-bold text-slate-900 hover:text-brand-primary transition flex items-center gap-2 group/link">
                                {{-- Wrapper lebar tetap agar sejajar --}}
                                <div class="w-5 flex justify-center">
                                    <i data-lucide="arrow-right" class="w-3 h-3 text-slate-300 group-hover/link:text-brand-primary transition-colors"></i>
                                </div>
                                {{ __('All Products') }}
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('products.category', $cat->slug) }}" class="text-sm font-medium text-slate-500 hover:text-brand-primary transition flex items-center gap-2 group/link">
                                    {{-- Wrapper lebar tetap agar sejajar --}}
                                    <div class="w-5 flex justify-center">
                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-300 group-hover/link:bg-brand-primary transition-colors"></span>
                                    </div>
                                    {{ $cat->getTranslation('name') }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                {{-- CARD 2: COMPANY --}}
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-200/60 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-brand-soft flex items-center justify-center text-brand-primary group-hover:scale-110 transition-transform">
                            <i data-lucide="building-2" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-black text-slate-900 uppercase tracking-wide text-sm">{{ __('Company') }}</h3>
                    </div>
                    
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('home') }}" class="text-sm font-medium text-slate-500 hover:text-brand-primary transition flex items-center gap-2">
                                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i> {{ __('Home') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pages.about') }}" class="text-sm font-medium text-slate-500 hover:text-brand-primary transition flex items-center gap-2">
                                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i> {{ __('About Pumpman') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('posts.index') }}" class="text-sm font-medium text-slate-500 hover:text-brand-primary transition flex items-center gap-2">
                                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i> {{ __('News & Insights') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('stores.index') }}" class="text-sm font-medium text-slate-500 hover:text-brand-primary transition flex items-center gap-2">
                                <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i> {{ __('Store Locator') }}
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- CARD 3: SUPPORT --}}
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-200/60 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-brand-soft flex items-center justify-center text-brand-primary group-hover:scale-110 transition-transform">
                            <i data-lucide="life-buoy" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-black text-slate-900 uppercase tracking-wide text-sm">{{ __('Support') }}</h3>
                    </div>
                    
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('faqs.index') }}" class="text-sm font-medium text-slate-500 hover:text-brand-primary transition flex items-center gap-2">
                                <i data-lucide="help-circle" class="w-3 h-3 text-slate-300"></i> {{ __('FAQs') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('warranty-claim') }}" class="text-sm font-medium text-slate-500 hover:text-brand-primary transition flex items-center gap-2">
                                <i data-lucide="shield-check" class="w-3 h-3 text-slate-300"></i> {{ __('Warranty Claim') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('warranty-claim.check') }}" class="text-sm font-medium text-slate-500 hover:text-brand-primary transition flex items-center gap-2">
                                <i data-lucide="search" class="w-3 h-3 text-slate-300"></i> {{ __('Track Repair') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pages.contact') }}" class="text-sm font-medium text-slate-500 hover:text-brand-primary transition flex items-center gap-2">
                                <i data-lucide="mail" class="w-3 h-3 text-slate-300"></i> {{ __('Contact Us') }}
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- CARD 4: CAREERS --}}
                <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-200/60 hover:shadow-md transition-all duration-300 group">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-brand-soft flex items-center justify-center text-brand-primary group-hover:scale-110 transition-transform">
                            <i data-lucide="briefcase" class="w-5 h-5"></i>
                        </div>
                        <h3 class="font-black text-slate-900 uppercase tracking-wide text-sm">{{ __('Careers') }}</h3>
                    </div>
                    
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('careers.index') }}" class="text-sm font-bold text-slate-900 hover:text-brand-primary transition flex items-center gap-2">
                                <i data-lucide="arrow-right" class="w-3 h-3 text-slate-300"></i> {{ __('View All Openings') }}
                            </a>
                        </li>
                        @forelse($careers->take(5) as $job)
                            <li>
                                <a href="{{ route('careers.index') }}#openings" class="block group/link">
                                    <span class="text-sm font-medium text-slate-500 group-hover/link:text-brand-primary transition block">
                                        {{ $job->getTranslation('title') }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 uppercase tracking-wider block mt-0.5">
                                        {{ $job->location }}
                                    </span>
                                </a>
                            </li>
                        @empty
                            <li><span class="text-xs text-slate-400 italic">{{ __('No openings at the moment') }}</span></li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </section>

</x-web.main-layout>