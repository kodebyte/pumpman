@php
    $_appLocale = app()->getLocale();
@endphp

<x-web.main-layout> 

    <section id="hero-slider" class="relative h-[700px] w-full overflow-hidden bg-brand-dark group/slider">
        <div id="slides-container" class="w-full h-full relative">
            @forelse($banners as $index => $banner)
                <div class="slide {{ $index === 0 ? 'slide-active' : 'slide-hidden' }} absolute inset-0 w-full h-full">
                    
                    {{-- 1. MEDIA HANDLING (Video / Image) --}}
                    @if($banner->background_type === 'video' && $banner->video_path)
                        {{-- Video Background --}}
                        <video class="absolute inset-0 w-full h-full object-cover" 
                               autoplay muted loop playsinline 
                               poster="{{ Storage::url($banner->image_desktop) }}">
                            <source src="{{ Storage::url($banner->video_path) }}" type="video/mp4">
                        </video>
                    @else
                        {{-- Image Background (Responsive: Mobile vs Desktop) --}}
                        {{-- Mobile Image (Visible on small screens) --}}
                        <div class="absolute inset-0 bg-cover bg-center md:hidden" 
                             style="background-image: url('{{ Storage::url($banner->image_mobile) }}');">
                        </div>
                        
                        {{-- Desktop Image (Visible on medium screens and up) --}}
                        <div class="absolute inset-0 bg-cover bg-center hidden md:block" 
                             style="background-image: url('{{ Storage::url($banner->image_desktop) }}');">
                        </div>
                    @endif

                    {{-- 2. OVERLAY GRADIENT --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>

                    {{-- 3. TEXT CONTENT --}}
                    {{-- Kita gunakan flex justify-start (kiri) atau justify-end (kanan) secara acak atau bisa diatur di DB nanti. 
                         Untuk sekarang kita default ke kiri seperti desain awal, atau kanan untuk variasi --}}
                    <div class="relative z-10 h-full container mx-auto px-4 md:px-6 flex items-center {{ $index % 2 != 0 ? 'justify-end' : '' }}">
                        <div class="max-w-xl p-8 md:p-0 text-white slide-content text-left">
                            
                            {{-- Tagline / Badge --}}
                            @if($banner->getTranslation('tagline'))
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 border border-white/30 text-white text-xs font-bold uppercase tracking-wider mb-6 backdrop-blur-md">
                                    @if($index === 0) 
                                        <span class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></span> 
                                    @endif
                                    {{ $banner->getTranslation('tagline') }}
                                </div>
                            @endif

                            {{-- Title --}}
                            <h1 class="font-display text-4xl md:text-6xl font-bold leading-tight mb-6">
                                {!! nl2br($banner->getTranslation('title')) !!}
                            </h1>

                            {{-- Subtitle --}}
                            <p class="text-lg text-gray-100 mb-8 leading-relaxed font-light">
                                {{ $banner->getTranslation('subtitle') }}
                            </p>

                            {{-- CTA Button --}}
                            <div class="flex gap-4">
                                <a href="{{ $banner->target_url }}" class="bg-brand-accent text-white px-8 py-4 rounded-xl font-bold hover:bg-yellow-500 transition shadow-glow flex items-center gap-2">
                                    {{ $banner->getTranslation('cta_text') ?? 'Explore Now' }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- FALLBACK: Jika tidak ada banner aktif di DB, tampilkan static slide agar layout tidak rusak --}}
                <div class="slide slide-active absolute inset-0 w-full h-full">
                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1574360778004-946766d61665?q=80&w=1974&auto=format&fit=crop');"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-black/30"></div>
                    <div class="relative z-10 h-full container mx-auto px-4 md:px-6 flex items-center">
                        <div class="max-w-xl p-8 md:p-0 text-white slide-content">
                            <h1 class="font-display text-4xl md:text-6xl font-bold leading-tight mb-6">Welcome to <br><span class="text-brand-accent">PUMPMAN</span></h1>
                            <p class="text-lg text-gray-100 mb-8">No banners active. Please configure Hero Banners in Admin Panel.</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- CONTROLS --}}
        @if($banners->count() > 1)
            <button id="prev-slide" class="absolute left-4 top-1/2 -translate-y-1/2 z-20 p-4 text-white/50 hover:text-white transition-all transform hover:scale-110 focus:outline-none">
                <i data-lucide="chevron-left" class="w-10 h-10 shadow-sm"></i>
            </button>
            <button id="next-slide" class="absolute right-4 top-1/2 -translate-y-1/2 z-20 p-4 text-white/50 hover:text-white transition-all transform hover:scale-110 focus:outline-none">
                <i data-lucide="chevron-right" class="w-10 h-10 shadow-sm"></i>
            </button>
            <div id="dots-container" class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 flex items-center gap-4"></div>
        @endif
    </section>

    <section class="py-20 bg-white overflow-hidden">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">Browse Collections</span>
                    <h2 class="text-2xl md:text-3xl font-display font-bold text-slate-900">Popular Categories</h2>
                </div>
                
                <div class="flex gap-3">
                    <button id="cat-prev" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-slate-600 hover:bg-brand-primary hover:text-white hover:border-brand-primary transition focus:outline-none">
                        <i data-lucide="chevron-left" class="w-5 h-5"></i>
                    </button>
                    <button id="cat-next" class="w-10 h-10 rounded-full border border-gray-200 flex items-center justify-center text-slate-600 hover:bg-brand-primary hover:text-white hover:border-brand-primary transition focus:outline-none">
                        <i data-lucide="chevron-right" class="w-5 h-5"></i>
                    </button>
                </div>
            </div>

            <div id="category-slider" class="flex gap-6 overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory pb-4">
                @foreach($featuredCategories as $category)
                    <div class="min-w-[280px] md:min-w-[calc(50%-12px)] lg:min-w-[calc(25%-18px)] flex-shrink-0 snap-start">
                        <a href="{{ route('products.category', $category->slug) }}" class="group block bg-white rounded-[2rem] p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 h-64 relative overflow-hidden">
                            <div class="flex flex-col justify-between h-full relative z-10">
                                {{-- Icon/Image Wrapper --}}
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 transition duration-300 bg-brand-soft text-brand-primary group-hover:scale-110 overflow-hidden">
                                    <i data-lucide="droplets" class="w-7 h-7"></i>
                                </div>

                                <div class="mb-2">
                                    <h3 class="font-bold text-slate-900 text-xl leading-tight mb-1 group-hover:text-brand-primary transition">
                                        {{ $category->getTranslation('name') }}
                                    </h3>
                                    <p class="text-sm text-slate-500 font-medium">
                                        {{-- Optional: Add specific description per category later, or generic text --}}
                                        {{ __('Explore Collection') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Decorative Background Circle --}}
                            <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-48 h-48 group-hover:scale-110 transition duration-500">
                                <div class="w-full h-full bg-gradient-to-br from-brand-soft to-transparent rounded-full">
                                    @if($category->image)
                                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->getTranslation('name') }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if($productHighlight)
        <section class="py-24 bg-white overflow-hidden relative border-t border-gray-50">
            <div class="absolute top-0 right-0 w-1/3 h-full bg-brand-soft/30 -skew-x-12 translate-x-20 z-0"></div>

            <div class="container mx-auto px-4 md:px-6 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                    
                    <div class="relative group">
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[80%] h-[80%] rounded-full border-2 border-dashed border-brand-primary/20 animate-[spin_20s_linear_infinite]"></div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[60%] h-[60%] rounded-full bg-brand-soft/50 blur-3xl"></div>
                        
                        <img src="{{ Storage::url($productHighlight->image) }}" alt="{{ $productHighlight->getTranslation('title') }}" 
                            class="relative z-10 w-full h-auto object-contain drop-shadow-2xl hover:scale-105 transition duration-700 mix-blend-multiply">
                    </div>

                    <div>
                        <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">
                            {{ $productHighlight->getTranslation('tagline') }}
                        </span>
                        
                        <h2 class="text-3xl md:text-5xl font-display font-bold text-slate-900 mb-6 leading-tight">
                            {!! nl2br($productHighlight->getTranslation('title')) !!}
                        </h2>
                        
                        <p class="text-slate-500 text-lg mb-10 leading-relaxed">
                            {{ $productHighlight->getTranslation('description') }}
                        </p>

                        <div class="space-y-8">
                            @if(is_array($productHighlight->features) || is_object($productHighlight->features))
                                @foreach($productHighlight->features as $feature)
                                    <div class="flex gap-5 group/item">
                                        <div class="flex-shrink-0 w-14 h-14 bg-white border border-gray-100 text-brand-primary rounded-2xl flex items-center justify-center shadow-md group-hover/item:bg-brand-primary group-hover/item:text-white transition duration-300">
                                            <i data-lucide="{{ $feature['icon'] ?? 'check-circle' }}" class="w-7 h-7"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-slate-900 mb-2 group-hover/item:text-brand-primary transition">
                                                {{ $feature['title'][$_appLocale] ?? '' }}
                                            </h4>
                                            <p class="text-sm text-slate-500 leading-relaxed">
                                                {{ $feature['desc'][$_appLocale] ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        @if($productHighlight->button_url)
                            <div class="mt-10 pt-10 border-t border-gray-100">
                                <a href="{{ $productHighlight->button_url }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 hover:text-brand-primary transition border-b-2 border-black hover:border-brand-primary pb-1">
                                    {{ $productHighlight->getTranslation('button_text') ?? 'Learn More' }} 
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="py-24 bg-brand-gray overflow-hidden">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-10">
               <div>
                  <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">
                      {{ __('Best Choice') }}
                  </span>
                  <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900">
                      {{ __('Featured Products') }}
                  </h2>
               </div>
               <a href="{{ route('products.index') }}" class="group flex items-center gap-2 text-slate-500 hover:text-brand-primary transition font-medium pb-1 border-b border-transparent hover:border-brand-primary">
                   {{ __('Browse All') }} 
                   <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
               </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                    <x-web.product-card :product="$product" />
                @empty
                    <div class="col-span-1 sm:col-span-2 lg:col-span-4 text-center py-20 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                        <p class="text-gray-500 font-bold mb-2">{{ __('No featured products available.') }}</p>
                        <p class="text-xs text-gray-400">{{ __('Please check back later.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    
    <section class="py-12 border-t border-gray-50 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <p class="text-center text-sm font-bold text-gray-400 uppercase tracking-widest mb-8">Trusted by 500+ Industries & Companies</p>
            <div class="flex flex-wrap justify-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-blue-50 transition"><i data-lucide="building-2" class="w-8 h-8 text-slate-400 group-hover:text-blue-600"></i></div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">PDAM JAYA</span>
                </div>
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-orange-50 transition"><i data-lucide="factory" class="w-8 h-8 text-slate-400 group-hover:text-orange-600"></i></div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">INDOFOOD</span>
                </div>
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-red-50 transition"><i data-lucide="hard-hat" class="w-8 h-8 text-slate-400 group-hover:text-red-600"></i></div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">WIKA KARYA</span>
                </div>
                <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-green-50 transition"><i data-lucide="droplets" class="w-8 h-8 text-slate-400 group-hover:text-green-600"></i></div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">UNILEVER</span>
                </div>
                 <div class="flex items-center gap-2 group cursor-default">
                    <div class="p-2 bg-gray-100 rounded-lg group-hover:bg-purple-50 transition"><i data-lucide="hotel" class="w-8 h-8 text-slate-400 group-hover:text-purple-600"></i></div>
                    <span class="font-black text-xl text-slate-300 group-hover:text-slate-600">ASTON HOTEL</span>
                </div>
            </div>
        </div>
    </section>

    <section class="py-10 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="bg-brand-dark rounded-[2.5rem] p-8 md:p-12 relative overflow-hidden shadow-2xl flex flex-col md:flex-row items-center justify-between gap-8 group">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-brand-accent/20 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2"></div>
                <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                <div class="relative z-10 max-w-2xl text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 text-brand-accent text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="w-2 h-2 rounded-full bg-brand-accent animate-pulse"></span> Online Support
                    </div>
                    <h2 class="text-3xl md:text-4xl font-display font-bold text-white mb-4 leading-tight">Confused about calculating <br><span class="text-brand-accent">Head & Flow?</span></h2>
                    <p class="text-white/80 text-lg font-light leading-relaxed">Don't risk buying the wrong pump. Our certified engineers are ready to help you calculate the specifications for free.</p>
                </div>
                <div class="relative z-10 flex flex-col sm:flex-row gap-4">
                    <a href="#" class="bg-white text-brand-dark px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition shadow-lg flex items-center justify-center gap-2 group/btn"><i data-lucide="message-circle" class="w-5 h-5"></i> Chat via WhatsApp</a>
                    <a href="#" class="px-8 py-4 rounded-full font-bold text-white border border-white/30 hover:bg-white/10 transition flex items-center justify-center gap-2"><i data-lucide="phone" class="w-5 h-5"></i> Call Sales</a>
                </div>
            </div>
        </div>
    </section>
    
    <section class="py-24 bg-white">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-12">
               <div>
                   <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">
                       {{ __('Industry Insights') }}
                   </span>
                   <h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900">
                       {{ __('Latest News') }}
                   </h2>
               </div>
               <a href="{{ route('posts.index') }}" class="group flex items-center gap-2 text-slate-500 hover:text-brand-primary transition font-medium pb-1 border-b border-transparent hover:border-brand-primary">
                   {{ __('Read Blog') }} 
                   <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
               </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
               @forelse($latestPosts as $post)
                   <article class="group cursor-pointer flex flex-col h-full">
                       {{-- Image --}}
                       <div class="overflow-hidden rounded-[2rem] relative mb-5 aspect-[4/3]">
                           @if($post->thumbnail)
                                <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                                     alt="{{ $post->getTranslation('title') }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                           @else
                                <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                    <i data-lucide="image" class="w-12 h-12"></i>
                                </div>
                           @endif

                           {{-- Date Badge --}}
                           @if(!is_null($post->published_at))
                               <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-4 py-2 rounded-xl shadow-sm">
                                   <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">
                                       {{ $post->published_at->format('M') }}
                                   </span>
                                   <span class="block text-xl font-black text-slate-900 leading-none text-center">
                                       {{ $post->published_at->format('d') }}
                                   </span>
                               </div>
                           @endif
                       </div>

                       <div class="flex flex-col flex-1">
                           {{-- Category / Type --}}
                           <div class="flex items-center gap-2 text-brand-primary text-xs font-bold uppercase tracking-widest mb-2">
                               <i data-lucide="tag" class="w-3 h-3"></i> 
                               {{ $post->type ? ucfirst($post->type->getTranslation('name')) : __('General') }}
                           </div>

                           {{-- Title --}}
                           <h3 class="text-2xl font-bold text-slate-900 leading-snug mb-4 group-hover:text-brand-primary transition-colors">
                               <a href="{{ route('posts.show', $post->slug) }}">
                                   {{ $post->getTranslation('title') }}
                               </a>
                           </h3>

                           {{-- Excerpt (Optional) --}}
                           <p class="text-gray-500 text-sm line-clamp-3 mb-4 flex-1">
                                {{ Str::limit(strip_tags($post->getTranslation('content')), 100) }}
                           </p>

                           {{-- Read More --}}
                           <div class="mt-auto">
                               <span class="inline-flex items-center gap-2 text-sm font-bold text-slate-900 group-hover:text-brand-primary transition border-b-2 border-transparent group-hover:border-brand-primary pb-0.5">
                                   {{ __('Read Article') }} 
                                   <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                               </span>
                           </div>
                       </div>
                   </article>
               @empty
                   <div class="col-span-3 text-center py-12 text-gray-400 border border-dashed rounded-xl">
                       {{ __('No latest news available.') }}
                   </div>
               @endforelse
            </div>
        </div>
    </section>

    <section class="py-24 bg-brand-gray overflow-hidden">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-10">
               <div><span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">Our Credibility</span><h2 class="text-3xl md:text-4xl font-display font-bold text-slate-900">Certifications & Awards</h2></div>
               <div class="flex gap-3">
                  <button id="cert-prev" class="w-10 h-10 rounded-full border border-gray-200 bg-white flex items-center justify-center text-slate-600 hover:bg-brand-primary hover:text-white hover:border-brand-primary transition focus:outline-none shadow-sm"><i data-lucide="chevron-left" class="w-5 h-5"></i></button>
                  <button id="cert-next" class="w-10 h-10 rounded-full border border-gray-200 bg-white flex items-center justify-center text-slate-600 hover:bg-brand-primary hover:text-white hover:border-brand-primary transition focus:outline-none shadow-sm"><i data-lucide="chevron-right" class="w-5 h-5"></i></button>
               </div>
            </div>
            <div id="certification-slider" class="flex gap-6 overflow-x-auto no-scrollbar scroll-smooth snap-x snap-mandatory pb-4">
                 <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 flex flex-col items-center text-center snap-start group cursor-default">
                     <div class="w-20 h-20 bg-brand-soft rounded-2xl flex items-center justify-center mb-6 transition duration-300 group-hover:scale-110"><i data-lucide="award" class="w-10 h-10 text-brand-primary"></i></div>
                     <h3 class="font-bold text-slate-900 text-xl mb-2 group-hover:text-brand-primary transition">ISO 9001:2015</h3><p class="text-sm text-slate-500 leading-relaxed">Certified Quality Management System.</p>
                 </div>
                 <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 flex flex-col items-center text-center snap-start group cursor-default">
                     <div class="w-20 h-20 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 transition duration-300 group-hover:scale-110"><i data-lucide="shield-check" class="w-10 h-10 text-blue-600"></i></div>
                     <h3 class="font-bold text-slate-900 text-xl mb-2 group-hover:text-brand-primary transition">SNI Certified</h3><p class="text-sm text-slate-500 leading-relaxed">Meets Indonesian National Standard.</p>
                 </div>
                 <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 flex flex-col items-center text-center snap-start group cursor-default">
                     <div class="w-20 h-20 bg-red-50 rounded-2xl flex items-center justify-center mb-6 transition duration-300 group-hover:scale-110"><i data-lucide="flag" class="w-10 h-10 text-red-600"></i></div>
                     <h3 class="font-bold text-slate-900 text-xl mb-2 group-hover:text-brand-primary transition">TKDN > 40%</h3><p class="text-sm text-slate-500 leading-relaxed">High local content certification.</p>
                 </div>
                 <div class="min-w-[280px] md:min-w-[320px] bg-white rounded-[2rem] p-8 border border-gray-100 shadow-sm hover:shadow-lg hover:border-brand-primary/30 transition-all duration-300 flex flex-col items-center text-center snap-start group cursor-default">
                     <div class="w-20 h-20 bg-green-50 rounded-2xl flex items-center justify-center mb-6 transition duration-300 group-hover:scale-110"><i data-lucide="leaf" class="w-10 h-10 text-green-600"></i></div>
                     <h3 class="font-bold text-slate-900 text-xl mb-2 group-hover:text-brand-primary transition">Green Industry</h3><p class="text-sm text-slate-500 leading-relaxed">Eco-friendly operational standards.</p>
                 </div>
            </div>
        </div>
    </section>

    {{-- Tambahkan id="newsletter" agar fitur withFragment('newsletter') di controller berfungsi --}}
    <section id="newsletter" class="py-20 border-b border-gray-100 bg-white relative overflow-hidden">
        {{-- Optional: Background Pattern --}}
        <div class="absolute inset-0 opacity-[0.03]" 
                style="background-image: radial-gradient(#000 1px, transparent 1px); background-size: 20px 20px;">
        </div>

        <div class="container mx-auto px-4 md:px-6 text-center relative z-10">
            <div class="max-w-2xl mx-auto">
                <span class="text-brand-primary font-black tracking-widest uppercase text-xs mb-3 block">
                    {{ __('Stay Connected') }}
                </span>
                <h2 class="text-3xl md:text-4xl font-display font-black text-slate-900 mb-4 uppercase tracking-tight">
                    {{ __("Don't Miss Special Promos") }}
                </h2>
                <p class="text-slate-500 mb-10 text-sm md:text-base leading-relaxed">
                    {{ __('Get the latest industrial pump updates, engineering case studies, and exclusive offers directly to your inbox.') }}
                </p>
                
                {{-- START: Alert Messages --}}
                @if(session('newsletter_success'))
                    <div class="mb-8 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center justify-center gap-3 animate-fade-in-up shadow-sm">
                        <div class="bg-green-100 p-1 rounded-full">
                            <i data-lucide="check-circle" class="w-4 h-4 text-green-600"></i>
                        </div>
                        <span class="text-sm font-bold">{{ session('newsletter_success') }}</span>
                    </div>
                @endif

                @error('email')
                    <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center justify-center gap-3 animate-fade-in-up shadow-sm">
                        <div class="bg-red-100 p-1 rounded-full">
                            <i data-lucide="alert-circle" class="w-4 h-4 text-red-600"></i>
                        </div>
                        <span class="text-sm font-bold">{{ $message }}</span>
                    </div>
                @enderror
                {{-- END: Alert Messages --}}

                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="relative max-w-lg mx-auto flex items-center group">
                    @csrf
                    <div class="absolute left-6 text-gray-400 group-focus-within:text-brand-primary transition-colors z-10">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                    </div>
                    
                    <input type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            placeholder="{{ __('Enter your email address') }}" 
                            required
                            class="w-full pl-14 pr-36 py-4 rounded-2xl border border-gray-200 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-brand-primary/10 focus:border-brand-primary outline-none transition-all shadow-sm text-sm font-bold text-slate-900 placeholder-gray-400 relative z-0">
                    
                    <button type="submit" class="absolute right-2 top-2 bottom-2 bg-brand-dark text-white px-6 rounded-xl font-bold hover:bg-brand-primary transition-all duration-300 shadow-md text-xs uppercase tracking-widest z-10 flex items-center gap-2 group/btn hover:shadow-lg hover:-translate-y-0.5">
                        {{ __('Subscribe') }}
                        <i data-lucide="send" class="w-3 h-3 group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5 transition-transform"></i>
                    </button>
                </form>
                
                <p class="text-[10px] text-gray-400 mt-6 font-medium">
                    {{ __('We respect your privacy. No spam, ever.') }}
                </p>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            // Sliders Logic
            document.addEventListener('DOMContentLoaded', () => {
                // Hero Slider
                const slides = document.querySelectorAll('.slide');
                const prevBtn = document.getElementById('prev-slide');
                const nextBtn = document.getElementById('next-slide');
                const dotsContainer = document.getElementById('dots-container');

                if (dotsContainer && slides.length > 0) {
                    let currentSlide = 0;
                    const slideCount = slides.length;
                    let slideInterval;

                    // Create Dots
                    slides.forEach((_, index) => {
                        const dot = document.createElement('button');
                        dot.classList.add('w-2', 'h-2', 'rounded-full', 'transition-all', 'duration-300');
                        if (index === 0) dot.classList.add('bg-white', 'w-6');
                        else dot.classList.add('bg-white/40', 'hover:bg-white');
                        dot.addEventListener('click', () => { goToSlide(index); resetTimer(); });
                        dotsContainer.appendChild(dot);
                    });

                    const dots = dotsContainer.querySelectorAll('button');

                    function updateSlides() {
                        slides.forEach((slide, index) => {
                            if (index === currentSlide) {
                                slide.classList.remove('slide-hidden');
                                slide.classList.add('slide-active');
                            } else {
                                slide.classList.add('slide-hidden');
                                slide.classList.remove('slide-active');
                            }
                        });
                        dots.forEach((dot, index) => {
                            if (index === currentSlide) {
                                dot.classList.remove('bg-white/40', 'w-2');
                                dot.classList.add('bg-white', 'w-6');
                            } else {
                                dot.classList.add('bg-white/40', 'w-2');
                                dot.classList.remove('bg-white', 'w-6');
                            }
                        });
                    }

                    function nextSlide() { currentSlide = (currentSlide + 1) % slideCount; updateSlides(); }
                    function prevSlide() { currentSlide = (currentSlide - 1 + slideCount) % slideCount; updateSlides(); }
                    function goToSlide(index) { currentSlide = index; updateSlides(); }
                    function resetTimer() { clearInterval(slideInterval); slideInterval = setInterval(nextSlide, 6000); }

                    if (nextBtn) nextBtn.addEventListener('click', () => { nextSlide(); resetTimer(); });
                    if (prevBtn) prevBtn.addEventListener('click', () => { prevSlide(); resetTimer(); });

                    resetTimer();
                }

                // Simple Horizontal Scroll (Categories & Certs)
                const setupScroll = (containerId, nextId, prevId) => {
                    const container = document.getElementById(containerId);
                    const next = document.getElementById(nextId);
                    const prev = document.getElementById(prevId);
                    
                    if (container && next && prev) {
                        next.addEventListener('click', () => { container.scrollBy({ left: 320, behavior: 'smooth' }); });
                        prev.addEventListener('click', () => { container.scrollBy({ left: -320, behavior: 'smooth' }); });
                    }
                };
                setupScroll('category-slider', 'cat-next', 'cat-prev');
                setupScroll('certification-slider', 'cert-next', 'cert-prev');
            });
        </script>
    @endpush
    
</x-web.main-layout>