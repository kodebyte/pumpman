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
                        
                        <img src="{{ Storage::url($productHighlight->image) }}" 
                            alt="{{ $productHighlight->getTranslation('title') }}" 
                            class="relative z-10 w-full h-auto object-contain drop-shadow-2xl hover:scale-105 transition duration-700 mix-blend-multiply">
                        
                        {{-- 
                        <div class="absolute bottom-10 -right-4 md:right-10 bg-white p-4 rounded-2xl shadow-xl z-20 border border-gray-100 animate-bounce" style="animation-duration: 3s;">
                            <div class="flex items-center gap-3">
                                <div class="bg-green-100 p-2 rounded-full text-green-600">
                                    <i data-lucide="zap" class="w-6 h-6"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-500 font-bold uppercase">Energy Saving</p>
                                    <p class="text-lg font-black text-slate-900">Up to 30%</p>
                                </div>
                            </div>
                        </div>
                        --}}
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
                                            {{-- Render icon dynamic dari nama icon (contoh: 'cpu', 'shield') --}}
                                            <i data-lucide="{{ $feature['icon'] ?? 'check-circle' }}" class="w-7 h-7"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-slate-900 mb-2 group-hover/item:text-brand-primary transition">
                                                {{ $feature['title'][app()->getLocale()] ?? '' }}
                                            </h4>
                                            <p class="text-sm text-slate-500 leading-relaxed">
                                                {{ $feature['description'][app()->getLocale()] ?? '' }}
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