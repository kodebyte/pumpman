<x-web.main-layout>
    
    <div class="relative w-full h-screen bg-black text-white overflow-hidden">
        <div id="hero-slider" class="flex h-full w-full transition-transform duration-700 ease-in-out">
            <div class="min-w-full h-full relative flex items-center">
                <video autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover z-0">
                    <source src="{{ asset('assets/vid.mp4') }}" type="video/mp4">
                </video>
                <div class="absolute inset-0 bg-black/60 z-0"></div>
                
                <div class="container mx-auto px-6 relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    <div class="lg:col-span-7 space-y-8 pt-20 lg:pt-0">
                        <div class="flex items-center gap-3">
                            <span class="h-[1px] w-12 bg-red-600"></span>
                            <span class="text-red-500 tracking-[0.2em] text-xs font-bold uppercase">Japanese Precision</span>
                        </div>
                        <h1 class="text-6xl lg:text-8xl font-black leading-[0.9] tracking-tighter drop-shadow-2xl">
                            SONIC <br />
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-gray-500">EXCELLENCE.</span>
                        </h1>
                        <p class="text-gray-300 text-lg max-w-md border-l-2 border-red-600 pl-6 py-2 font-medium">
                            Mendefinisikan ulang batas audio high-fidelity. Desain ikonik bertemu dengan teknologi masa depan.
                        </p>
                        <div class="flex gap-6 pt-4">
                            <button class="bg-white text-black px-8 py-4 font-bold flex items-center gap-2 hover:bg-gray-200 transition rounded-none">
                                Explore Series <i data-lucide="arrow-up-right" class="w-5 h-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            </div>

        <button id="prevBtn" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-red-600 text-white p-3 rounded-full backdrop-blur-md transition z-20 group">
            <i data-lucide="chevron-left" class="w-8 h-8 group-hover:-translate-x-1 transition"></i>
        </button>
        <button id="nextBtn" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-red-600 text-white p-3 rounded-full backdrop-blur-md transition z-20 group">
            <i data-lucide="chevron-right" class="w-8 h-8 group-hover:translate-x-1 transition"></i>
        </button>
    </div>

    <section class="py-24 bg-white border-b border-gray-100">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <span class="text-red-600 font-bold uppercase tracking-wider text-xs flex items-center gap-2">
                        <div class="w-2 h-2 bg-red-600 rounded-full animate-pulse"></div> Collection 2024
                    </span>
                    <h2 class="text-5xl font-black mt-3 tracking-tighter text-black">FEATURED <br/> PRODUCTS</h2>
                </div>
                <a href="#" class="flex items-center gap-2 font-bold text-sm border-b border-gray-300 pb-1 hover:border-red-600 hover:text-red-600 transition duration-300">
                    View All Collection <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-12">
                
                @forelse($featuredProducts as $product)
                    <div class="product-item group cursor-pointer flex flex-col bg-softGray rounded-2xl p-5 hover:shadow-lg transition-all duration-300">
                        <div class="relative mb-4 aspect-[5/4] flex items-center justify-center overflow-hidden">
                            @if($product->is_featured)
                                <div class="absolute top-0 left-0 bg-white px-3 py-1.5 rounded-sm shadow-sm z-10">
                                    <span class="text-[10px] font-bold tracking-widest uppercase text-black">HOT</span>
                                </div>
                            @endif
                            
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-contain mix-blend-multiply transition-transform duration-500 ease-out group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                            @endif
                            
                            <div class="absolute inset-x-0 bottom-2 flex justify-center opacity-0 translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 ease-out z-20">
                                <button class="bg-black/90 backdrop-blur-sm text-white text-xs font-bold uppercase tracking-widest px-6 py-3 rounded-full shadow-xl hover:bg-aiwaRed transition-colors flex items-center gap-2 transform hover:scale-105 active:scale-95">
                                    <i data-lucide="plus" class="w-3 h-3"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="flex flex-col items-center text-center px-1 space-y-1 mt-2">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">{{ $product->category->name ?? 'Product' }}</p>
                            <h3 class="text-lg font-bold text-charcoal leading-tight group-hover:text-aiwaRed transition-colors">{{ $product->name }}</h3>
                            <p class="text-sm font-medium text-charcoal">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <p class="col-span-4 text-center text-gray-500">No featured products yet.</p>
                @endforelse

            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        // Masukkan Logic JS Slider dari index.html di sini
        let currentSlide = 0;
        const slides = document.querySelectorAll('#hero-slider > div');
        const sliderWrapper = document.getElementById('hero-slider');
        const totalSlides = slides.length;

        function updateSlider() {
            sliderWrapper.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        document.getElementById('nextBtn').addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlider();
        });

        document.getElementById('prevBtn').addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlider();
        });
        
        // Auto slide
        setInterval(() => {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlider();
        }, 8000);
    </script>
    @endpush

</x-web.main-layout>