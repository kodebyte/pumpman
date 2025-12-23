<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @php
        // --- 1. OTOMATISASI PENGAMBILAN KEY ---
        
        // Cek apakah controller mengirim $page secara manual? (Opsional/Override)
        // Jika tidak, AMBIL OTOMATIS dari nama route saat ini.
        $currentRouteName = request()->route()->getName(); // Contoh output: 'pages.about' atau 'products.index'
        
        // Gunakan variabel $page jika ada, jika tidak pakai route name otomatis
        $seoKey = $page ?? $currentRouteName;

        // --- 2. AMBIL DARI DATABASE ---
        $seoSetting = App\Models\SeoSetting::getByRoute($seoKey);

        // --- 3. PRIORITAS NILAI (Controller > DB > Config) ---
        
        // Title
        $metaTitle = $title 
                     ?? $seoSetting?->getTranslation('meta_title') 
                     ?? config('app.name');

        // Description
        $metaDescription = $description 
                           ?? $seoSetting?->getTranslation('meta_description') 
                           ?? __('Pumpman Indonesia Official Store');

        // Image
        $dbImage = $seoSetting?->og_image ? asset('storage/' . $seoSetting->og_image) : null;
        $metaImage = $image ?? $dbImage ?? asset('assets/web/images/logo-aiwa.png');
    @endphp

    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">

    <meta property="og:title" content="{{ $metaTitle }}" />
    <meta property="og:description" content="{{ $metaDescription }}" />
    <meta property="og:image" content="{{ $metaImage }}" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-brand antialiased text-gray-900 bg-white selection:bg-aiwaRed selection:text-white">

    @include('web.layouts.partials.navbar')

    <main>
        {{ $slot }}
    </main>

    @include('web.layouts.partials.footer')

    <div x-data="{ isOpen: false }" class="fixed bottom-6 right-6 z-[9999] font-sans group">
        <div x-show="isOpen"
            x-transition:enter="transition ease-out duration-300 transform origin-bottom-right"
            x-transition:enter-start="opacity-0 scale-90 translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200 transform origin-bottom-right"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-90 translate-y-2"
            @click.outside="isOpen = false"
            class="absolute bottom-20 right-0 w-[300px] bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
            
            <div class="bg-brand-dark p-5 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/2"></div>
                <h3 class="text-white font-bold text-lg relative z-10">Hello, Pumpman here! 👋</h3>
                <p class="text-white/80 text-xs mt-1 relative z-10">Need help with pumps? Chat with our team below.</p>
            </div>

            <div class="p-4 space-y-3">
                
                <a href="https://wa.me/6281234567890?text=Halo%20Sales%20Pumpman" target="_blank" class="flex items-center gap-4 p-3 rounded-xl hover:bg-brand-soft/50 transition-colors group/item">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                            <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                        </div>
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm group-hover/item:text-brand-primary transition">Sales Support</h4>
                        <p class="text-xs text-slate-500">Order & Price Inquiry</p>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 ml-auto group-hover/item:text-brand-primary"></i>
                </a>

                <a href="https://wa.me/6281234567891?text=Halo%20Engineer%20Pumpman" target="_blank" class="flex items-center gap-4 p-3 rounded-xl hover:bg-brand-soft/50 transition-colors group/item">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                            <i data-lucide="wrench" class="w-5 h-5"></i>
                        </div>
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm group-hover/item:text-brand-primary transition">Technical Engineer</h4>
                        <p class="text-xs text-slate-500">Spec Calculation</p>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 ml-auto group-hover/item:text-brand-primary"></i>
                </a>

                <a href="https://wa.me/6281234567892?text=Halo%20Admin" target="_blank" class="flex items-center gap-4 p-3 rounded-xl hover:bg-brand-soft/50 transition-colors group/item">
                    <div class="relative">
                        <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                            <i data-lucide="shield-check" class="w-5 h-5"></i>
                        </div>
                        <div class="absolute bottom-0 right-0 w-3 h-3 bg-gray-400 border-2 border-white rounded-full"></div>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800 text-sm group-hover/item:text-brand-primary transition">After Sales</h4>
                        <p class="text-xs text-slate-500">Warranty & Spareparts</p>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-300 ml-auto group-hover/item:text-brand-primary"></i>
                </a>
            </div>

            <div class="bg-gray-50 p-3 text-center border-t border-gray-100">
                <p class="text-[10px] text-slate-400">Available Mon-Fri, 08:00 - 17:00</p>
            </div>
        </div>

        <button @click="isOpen = !isOpen" 
                class="flex items-center justify-center w-14 h-14 bg-[#25D366] hover:bg-[#20bd5a] text-white rounded-full shadow-lg hover:shadow-green-500/40 transition-all duration-300 transform hover:scale-110 focus:outline-none relative">
            
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                class="absolute transition-all duration-300"
                :class="isOpen ? 'opacity-0 -rotate-90' : 'opacity-100 rotate-0'">
                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path>
            </svg>
            
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                class="absolute transition-all duration-300"
                :class="isOpen ? 'opacity-100 rotate-0' : 'opacity-0 rotate-90'">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
            </svg>
        </button>
    </div>

    @stack('scripts')
</body>
</html>