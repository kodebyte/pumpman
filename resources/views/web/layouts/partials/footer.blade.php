<footer class="bg-brand-dark text-white pt-16 pb-8 mt-auto border-t border-white/10">
    <div class="container mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            {{-- 1. BRAND INFO --}}
            <div>
                <div class="flex items-center gap-2 mb-6">
                    <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
                        <i data-lucide="droplet" class="w-6 h-6 text-white"></i>
                    </div>
                    <span class="font-display font-bold text-2xl tracking-tight">PUMPMAN</span>
                </div>
                <p class="text-white/80 text-sm leading-relaxed mb-8">
                    {{ __('The most complete industrial pump and spare parts center in Indonesia. We provide authentic products with official warranty and expert support.') }}
                </p>
                
                {{-- Social Media Dynamic --}}
                <div class="flex gap-4">
                    @php
                        $socials = [
                            ['key' => 'social_facebook', 'icon' => 'facebook', 'label' => 'Facebook'],
                            ['key' => 'social_instagram', 'icon' => 'instagram', 'label' => 'Instagram'],
                            ['key' => 'social_linkedin', 'icon' => 'linkedin', 'label' => 'LinkedIn'], // Pumpman specific icon
                            ['key' => 'social_youtube', 'icon' => 'youtube', 'label' => 'Youtube'],
                        ];
                    @endphp

                    @foreach($socials as $soc)
                        @if(!empty($globalSettings[$soc['key']]))
                            <a href="{{ $globalSettings[$soc['key']] }}" target="_blank" aria-label="{{ $soc['label'] }}"
                               class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white hover:text-brand-dark transition-all duration-300 group">
                                <i data-lucide="{{ $soc['icon'] }}" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- 2. EXPLORE MENU --}}
            <div>
                <h4 class="font-bold text-lg mb-6 flex items-center gap-2">
                    {{ __('Explore') }} 
                    <span class="w-8 h-0.5 bg-brand-accent/50 rounded-full"></span>
                </h4>
                <ul class="space-y-4 text-sm text-white/80">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('Home') }}</a></li>
                    <li><a href="{{ route('products.index') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('Products') }}</a></li>
                    <li><a href="{{ route('pages.about') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('About Us') }}</a></li>
                    <li><a href="{{ route('pages.contact') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('Contact Us') }}</a></li>
                    <li><a href="{{ route('posts.index') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('News') }}</a></li>
                    <li><a href="{{ route('careers.index') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('Careers') }}</a></li>
                    <li><a href="{{ route('pages.contact') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('Find a Store') }}</a></li>
                    <li><a href="{{ route('faqs.index') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('FAQ') }}</a></li>
                    <li><a href="{{ route('warranty-claim') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('Warranty Claim') }}</a></li>
                    <li><a href="{{ route('warranty-claim.check') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('Claim Status') }}</a></li>
                    <li><a href="{{ route('order-tracking') }}" class="hover:text-brand-accent hover:pl-2 transition-all duration-300 inline-block">{{ __('Track Order') }}</a></li>
                </ul>
            </div>

            {{-- 3. OFFICIAL STORES (Dynamic from DB) --}}
            <div>
                <h4 class="font-bold text-lg mb-6 flex items-center gap-2">
                    {{ __('Official Stores') }} 
                    <span class="w-8 h-0.5 bg-brand-accent/50 rounded-full"></span>
                </h4>
                <div class="flex flex-col gap-3">
                    {{-- Pastikan variable $footerMarketplaces dikirim via AppServiceProvider (sama seperti Aiwa) --}}
                    @if(isset($footerMarketplaces) && count($footerMarketplaces) > 0)
                        @foreach($footerMarketplaces as $marketplace)
                            <a href="{{ $marketplace->url }}" target="_blank" 
                               class="group flex items-center gap-3 bg-white/5 hover:bg-white/10 border border-white/10 px-3 py-3 rounded-xl transition-all">
                                
                                <div class="bg-white rounded-lg w-8 h-8 flex items-center justify-center p-1 shadow-sm flex-shrink-0 overflow-hidden">
                                    @if($marketplace->icon)
                                        <img src="{{ asset('storage/' . $marketplace->icon) }}" alt="{{ $marketplace->name }}" class="w-full h-full object-contain">
                                    @else
                                        <i data-lucide="shopping-bag" class="w-4 h-4 text-brand-dark"></i>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <span class="block text-white font-bold leading-none text-sm">{{ $marketplace->name }}</span>
                                    <span class="text-[10px] text-white/50 group-hover:text-brand-accent transition-colors">{{ __('Official Store') }}</span>
                                </div>
                                
                                <i data-lucide="external-link" class="w-4 h-4 text-white/30 group-hover:text-white ml-auto"></i>
                            </a>
                        @endforeach
                    @else
                        {{-- Fallback Static jika data kosong --}}
                        <div class="text-white/50 text-sm italic">{{ __('No marketplaces linked yet.') }}</div>
                    @endif
                </div>
            </div>

            {{-- 4. PAYMENTS --}}
            <div>
                <h4 class="font-bold text-lg mb-6 flex items-center gap-2">
                    {{ __('We Accept') }} 
                    <span class="w-8 h-0.5 bg-brand-accent/50 rounded-full"></span>
                </h4>
                <p class="text-white/70 text-sm mb-4">{{ __('Secure payments via trusted partners:') }}</p>
                
                {{-- Payment Grid --}}
                <div class="grid grid-cols-4 gap-2">
                    @if(isset($paymentMethods) && $paymentMethods->count() > 0)
                        @foreach($paymentMethods as $pay)
                            <div class="bg-white rounded-md h-9 p-1 flex items-center justify-center shadow-sm hover:scale-105 transition overflow-hidden" title="{{ $pay->name }}">
                                <img src="{{ $pay->image_url }}" alt="{{ $pay->name }}" class="h-full object-contain">
                            </div>
                        @endforeach
                    @else
                        {{-- Fallback text jika database kosong --}}
                        <p class="text-xs text-white/30 col-span-4 italic">No payment methods configured.</p>
                    @endif
                </div>

                <div class="mt-6 flex items-center gap-2 text-xs text-white/50 bg-white/5 p-3 rounded-lg border border-white/5">
                    <i data-lucide="lock" class="w-4 h-4 text-brand-accent"></i>
                    <span>{{ __('Encrypted & Secure Transaction') }}</span>
                </div>
            </div>
        </div>

        {{-- BOTTOM BAR --}}
        <div class="pt-8 border-t border-white/10 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-white/60">
            <p>&copy; {{ date('Y') }} <strong class="text-white">PT. Pumpman Indonesia Industry</strong>. {{ __('All rights reserved.') }}</p>
            <div class="flex gap-6">
                {{-- Gunakan route jika sudah ada, atau biarkan hash untuk sementara --}}
                <a href="#" class="hover:text-white transition">{{ __('Privacy Policy') }}</a>
                <a href="#" class="hover:text-white transition">{{ __('Terms of Service') }}</a>
                <a href="{{ route('sitemap') }}" class="hover:text-white transition">{{ __('Sitemap') }}</a>
            </div>
        </div>
    </div>
</footer>