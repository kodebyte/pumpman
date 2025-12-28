<x-web.main-layout>

    <section class="py-24 bg-white relative">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                {{-- Text Content --}}
                <div class="space-y-8 order-2 lg:order-1">
                    <h2 class="text-4xl font-black text-slate-900 tracking-tight leading-tight uppercase">
                        {{ __('More Than Just') }} <br> <span class="text-brand-primary">{{ __('A Distributor.') }}</span>
                    </h2>
                    <div class="space-y-6 text-slate-600 leading-relaxed text-lg">
                        <p>
                            {!! __('Founded in 2010 in Jakarta, <strong>PUMPMAN</strong> has evolved from a local supplier to a national leader in industrial pumping solutions. We understand that in the industry, <span class="text-slate-900 font-bold">downtime is not an option.</span>') !!}
                        </p>
                        <p>
                            {{ __('We combine global-tier products with local engineering expertise. Our goal is not just to sell a pump, but to ensure your entire system operates at peak efficiency for years to come.') }}
                        </p>
                    </div>
                    
                    {{-- Stats Grid --}}
                    <div class="grid grid-cols-3 gap-8 pt-8 border-t border-gray-100">
                        <div>
                            <span class="block text-4xl font-black text-slate-900">15+</span>
                            <span class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">{{ __('Years Experience') }}</span>
                        </div>
                        <div>
                            <span class="block text-4xl font-black text-slate-900">500+</span>
                            <span class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">{{ __('Projects Done') }}</span>
                        </div>
                        <div>
                            <span class="block text-4xl font-black text-slate-900">24/7</span>
                            <span class="text-[10px] text-gray-400 uppercase tracking-widest font-bold">{{ __('Support Team') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Image Composition --}}
                <div class="relative order-1 lg:order-2 group">
                    <div class="relative z-10 rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white">
                        <img src="https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?q=80&w=2070&auto=format&fit=crop" 
                             class="w-full h-auto transform group-hover:scale-105 transition duration-700 grayscale group-hover:grayscale-0" 
                             alt="Pumpman Engineer">
                    </div>
                    {{-- Decorative Elements --}}
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-brand-gray rounded-full -z-0"></div>
                    <div class="absolute -top-10 -right-10 w-64 h-64 bg-brand-primary/10 rounded-full -z-0"></div>
                    
                    {{-- Floating Badge --}}
                    <div class="absolute bottom-10 -left-6 bg-brand-dark text-white p-6 rounded-2xl shadow-xl hidden md:block z-20">
                        <i data-lucide="shield-check" class="w-8 h-8 text-brand-primary mb-2"></i>
                        <p class="text-xs font-bold uppercase tracking-widest text-brand-primary">{{ __('Certified') }}</p>
                        <p class="font-bold text-lg">{{ __('ISO 9001:2015') }}</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- 2. THE PIPELINE TIMELINE (Vertical History) --}}
    <section id="our-story" class="py-24 bg-white relative">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-4xl font-black text-slate-900 uppercase tracking-tight mb-4">{{ __('The Flow of History') }}</h2>
                <p class="text-slate-500">{{ __('A decade and a half of relentless innovation and partnership.') }}</p>
            </div>

            <div class="relative">
                {{-- The Pipe (Vertical Line) --}}
                <div class="absolute left-4 md:left-1/2 top-0 bottom-0 w-1 bg-gray-200 transform md:-translate-x-1/2"></div>

                <div class="space-y-16">
                    {{-- Item 1 (Right) --}}
                    <div class="relative flex flex-col md:flex-row items-center justify-between group">
                        <div class="hidden md:block w-5/12 text-right pr-12"></div>
                        <div class="absolute left-4 md:left-1/2 w-8 h-8 bg-white border-4 border-brand-primary rounded-full transform -translate-x-1/2 z-10 group-hover:scale-125 transition duration-300 shadow-lg"></div>
                        <div class="w-full md:w-5/12 pl-12 md:pl-12">
                            <span class="text-6xl font-black text-gray-100 absolute -top-4 -left-2 md:left-8 z-0">2010</span>
                            <div class="relative z-10 bg-gray-50 p-8 rounded-tr-[2rem] rounded-bl-[2rem] border border-gray-100 hover:border-brand-primary/30 transition shadow-sm">
                                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('Foundation') }}</h3>
                                <p class="text-slate-500 text-sm leading-relaxed">
                                    {{ __('Established in West Jakarta as a specialized supplier for centrifugal and submersible pumps.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Item 2 (Left) --}}
                    <div class="relative flex flex-col md:flex-row-reverse items-center justify-between group">
                        <div class="hidden md:block w-5/12 text-left pl-12"></div>
                        <div class="absolute left-4 md:left-1/2 w-8 h-8 bg-brand-dark border-4 border-gray-200 rounded-full transform -translate-x-1/2 z-10 group-hover:border-brand-primary transition duration-300 shadow-lg"></div>
                        <div class="w-full md:w-5/12 pl-12 md:pr-12 md:pl-0 text-left md:text-right">
                            <span class="text-6xl font-black text-gray-100 absolute -top-4 -right-2 md:right-8 z-0 hidden md:block">2015</span>
                            <div class="relative z-10 bg-gray-50 p-8 rounded-tl-[2rem] rounded-br-[2rem] border border-gray-100 hover:border-brand-primary/30 transition shadow-sm">
                                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('Engineering Division') }}</h3>
                                <p class="text-slate-500 text-sm leading-relaxed">
                                    {{ __('Launched our dedicated engineering team to provide head & flow calculations and installation support.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Item 3 (Right) --}}
                    <div class="relative flex flex-col md:flex-row items-center justify-between group">
                        <div class="hidden md:block w-5/12 text-right pr-12"></div> 
                        <div class="absolute left-4 md:left-1/2 w-8 h-8 bg-white border-4 border-brand-primary rounded-full transform -translate-x-1/2 z-10 group-hover:scale-125 transition duration-300 shadow-lg"></div>
                        <div class="w-full md:w-5/12 pl-12 md:pl-12">
                            <span class="text-6xl font-black text-gray-100 absolute -top-4 -left-2 md:left-8 z-0">2020</span>
                            <div class="relative z-10 bg-gray-50 p-8 rounded-tr-[2rem] rounded-bl-[2rem] border border-gray-100 hover:border-brand-primary/30 transition shadow-sm">
                                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('Digital Leap') }}</h3>
                                <p class="text-slate-500 text-sm leading-relaxed">
                                    {{ __('Expanded nationwide with a digital procurement system, serving over 500+ corporate clients.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Item 4 (Left - NOW) --}}
                    <div class="relative flex flex-col md:flex-row-reverse items-center justify-between group">
                        <div class="hidden md:block w-5/12 text-left pl-12"></div>
                        <div class="absolute left-4 md:left-1/2 w-8 h-8 bg-brand-primary border-4 border-green-200 rounded-full transform -translate-x-1/2 z-10 animate-pulse shadow-lg"></div>
                        <div class="w-full md:w-5/12 pl-12 md:pr-12 md:pl-0 text-left md:text-right">
                            <span class="text-6xl font-black text-gray-100 absolute -top-4 -right-2 md:right-8 z-0 hidden md:block">{{ __('NOW') }}</span>
                            <div class="relative z-10 bg-brand-dark text-white p-8 rounded-tl-[2rem] rounded-br-[2rem] shadow-xl">
                                <h3 class="text-xl font-bold mb-2">{{ __('Industry 4.0') }}</h3>
                                {{-- REVISI: Mengganti text-gray-400 menjadi text-white/80 di dalam box gelap --}}
                                <p class="text-white/80 text-sm leading-relaxed">
                                    {{ __('Focusing on IoT-enabled pumps and sustainable green energy solutions for modern factories.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. VISION & MISSION (Replaced "Philosophy") --}}
    <section class="py-24 bg-brand-gray border-t border-gray-200">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                <div>
                    <span class="text-brand-primary font-bold uppercase tracking-widest text-xs mb-2 block">{{ __('Our Compass') }}</span>
                    <h2 class="text-4xl font-black text-slate-900 uppercase">{{ __('Vision & Mission') }}</h2>
                </div>
                <div class="w-full md:w-1/3 bg-gray-200 h-px"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                {{-- VISION CARD --}}
                <div class="bg-white p-10 border-l-4 border-brand-primary shadow-sm hover:-translate-y-2 transition duration-300 rounded-tr-[3rem]">
                    <div class="w-16 h-16 bg-brand-soft flex items-center justify-center mb-8 rounded-2xl text-brand-primary">
                        <i data-lucide="telescope" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-6 uppercase tracking-tight">{{ __('Vision') }}</h3>
                    <p class="text-slate-600 leading-relaxed text-lg">
                        {{ __('To become the most trusted and comprehensive industrial fluid solution provider in Southeast Asia, known for integrity, innovation, and engineering excellence.') }}
                    </p>
                </div>

                {{-- MISSION CARD --}}
                <div class="bg-white p-10 border-l-4 border-slate-900 shadow-sm hover:-translate-y-2 transition duration-300 rounded-br-[3rem]">
                    <div class="w-16 h-16 bg-slate-100 flex items-center justify-center mb-8 rounded-2xl text-slate-900">
                        <i data-lucide="target" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 mb-6 uppercase tracking-tight">{{ __('Mission') }}</h3>
                    <ul class="space-y-4 text-slate-600">
                        <li class="flex items-start gap-4">
                            <i data-lucide="check-circle" class="w-5 h-5 text-brand-primary mt-1 flex-shrink-0"></i>
                            <span>{{ __('Providing high-quality original products with official warranties.') }}</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <i data-lucide="check-circle" class="w-5 h-5 text-brand-primary mt-1 flex-shrink-0"></i>
                            <span>{{ __('Delivering fast and precise engineering solutions to minimize client downtime.') }}</span>
                        </li>
                        <li class="flex items-start gap-4">
                            <i data-lucide="check-circle" class="w-5 h-5 text-brand-primary mt-1 flex-shrink-0"></i>
                            <span>{{ __('Building long-term partnerships based on trust and mutual growth.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. CERTIFICATIONS (Aiwa Style Grid) --}}
    <section class="py-24 bg-white border-t border-gray-100">
        <div class="container mx-auto px-4 md:px-6 text-center">
            <h2 class="text-3xl font-black mb-4 text-slate-900 uppercase tracking-tight">{{ __('Certified Excellence') }}</h2>
            <p class="text-slate-500 mb-16 max-w-2xl mx-auto">
                {{ __('Our dedication to quality and safety has been recognized by various national and international institutions.') }}
            </p>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 lg:gap-8">
                <div class="group flex flex-col items-center p-8 rounded-2xl bg-white border border-gray-100 hover:border-brand-primary hover:shadow-xl transition duration-300">
                    <div class="w-20 h-20 bg-brand-soft rounded-full flex items-center justify-center text-brand-primary mb-6 group-hover:scale-110 transition">
                        <i data-lucide="award" class="w-10 h-10"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-1 text-slate-900">ISO 9001:2015</h4>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Quality Mgmt</span>
                </div>

                <div class="group flex flex-col items-center p-8 rounded-2xl bg-white border border-gray-100 hover:border-blue-500 hover:shadow-xl transition duration-300">
                    <div class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 mb-6 group-hover:scale-110 transition">
                        <i data-lucide="shield-check" class="w-10 h-10"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-1 text-slate-900">SNI Certified</h4>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">National Standard</span>
                </div>

                <div class="group flex flex-col items-center p-8 rounded-2xl bg-white border border-gray-100 hover:border-red-500 hover:shadow-xl transition duration-300">
                    <div class="w-20 h-20 bg-red-50 rounded-full flex items-center justify-center text-red-600 mb-6 group-hover:scale-110 transition">
                        <i data-lucide="flag" class="w-10 h-10"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-1 text-slate-900">TKDN > 40%</h4>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Local Content</span>
                </div>

                <div class="group flex flex-col items-center p-8 rounded-2xl bg-white border border-gray-100 hover:border-green-500 hover:shadow-xl transition duration-300">
                    <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center text-green-600 mb-6 group-hover:scale-110 transition">
                        <i data-lucide="leaf" class="w-10 h-10"></i>
                    </div>
                    <h4 class="font-bold text-lg mb-1 text-slate-900">Green Industry</h4>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Eco Friendly</span>
                </div>
            </div>
        </div>
    </section>


   {{-- 6. TRUSTED BY --}}
    {{-- Menggunakan bg-brand-gray agar selang-seling dengan section Certifications yang putih --}}
    <section class="py-24 bg-brand-gray border-t border-gray-200">
        <div class="container mx-auto px-4 md:px-6">
            <p class="text-center text-xs font-bold text-gray-400 uppercase tracking-widest mb-12">{{ __('Trusted by Industry Leaders') }}</p>
            
            <div class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-white rounded-lg group-hover:bg-blue-50 transition shadow-sm"> {{-- Ubah bg-gray-100 jadi bg-white agar kontras --}}
                        <i data-lucide="building-2" class="w-8 h-8 text-slate-400 group-hover:text-blue-600"></i>
                    </div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">PDAM JAYA</span>
                </div>
                {{-- ... sisa item lainnya sama, cuma ganti bg-gray-100 jadi bg-white di icon wrapper ... --}}
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-white rounded-lg group-hover:bg-orange-50 transition shadow-sm">
                        <i data-lucide="factory" class="w-8 h-8 text-slate-400 group-hover:text-orange-600"></i>
                    </div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">INDOFOOD</span>
                </div>
                {{-- Lanjutkan pola yang sama untuk logo lain... --}}
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-white rounded-lg group-hover:bg-red-50 transition shadow-sm">
                        <i data-lucide="hard-hat" class="w-8 h-8 text-slate-400 group-hover:text-red-600"></i>
                    </div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">WIKA KARYA</span>
                </div>
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-white rounded-lg group-hover:bg-green-50 transition shadow-sm">
                        <i data-lucide="droplets" class="w-8 h-8 text-slate-400 group-hover:text-green-600"></i>
                    </div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">UNILEVER</span>
                </div>
                 <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-white rounded-lg group-hover:bg-purple-50 transition shadow-sm">
                        <i data-lucide="hotel" class="w-8 h-8 text-slate-400 group-hover:text-purple-600"></i>
                    </div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">ASTON HOTEL</span>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. CTA --}}
    <section class="py-20 bg-brand-dark text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-brand-primary opacity-10"></div>
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <h2 class="text-3xl md:text-5xl font-black mb-6 tracking-tight">{{ __('READY TO SCALE UP?') }}</h2>
            {{-- REVISI: Text putih/80 untuk kontras --}}
            <p class="text-white/80 mb-10 max-w-lg mx-auto leading-relaxed text-lg">
                {{ __('Find the perfect pump solution for your facility or project. Let our engineers assist you.') }}
            </p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-3 bg-white text-brand-dark px-10 py-5 font-bold rounded-full hover:bg-brand-primary hover:text-white transition-all transform hover:-translate-y-1 shadow-2xl">
                {{ __('Explore Catalog') }} <i data-lucide="arrow-right" class="w-5 h-5"></i>
            </a>
        </div>
    </section>

</x-web.main-layout>