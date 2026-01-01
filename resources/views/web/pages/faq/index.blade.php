<x-web.main-layout>

    {{-- 1. HEADER --}}
    {{-- CONSISTENCY: pt-32 pb-12, Uppercase 3XL Title --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('FAQ') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('FAQ') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Find answers to common questions about product specifications, warranty, installation, and after-sales service.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT (Card Layout) --}}
    <section class="bg-brand-gray pb-24 relative z-0" 
             x-data="{ 
                activeGroup: {{ $faqCategories->isNotEmpty() ? $faqCategories->first()->id : 'null' }}, 
                activeItem: null,
                switchGroup(id) {
                    this.activeItem = null; // Reset accordion saat ganti kategori
                    this.activeGroup = id;
                }
             }">
        <div class="container mx-auto px-4 md:px-6">
            
            {{-- FLOATING CARD --}}
            <div class="flex flex-col lg:flex-row bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-200/60 min-h-[600px]">
                
                {{-- LEFT: SIDEBAR CATEGORIES --}}
                <aside class="w-full lg:w-[350px] bg-gray-50 border-r border-gray-200 flex flex-col">
                    <div class="p-8 border-b border-gray-200 bg-gray-50">
                        <h3 class="font-black text-slate-900 uppercase tracking-widest text-sm flex items-center gap-2">
                            <i data-lucide="grid" class="w-4 h-4 text-brand-primary"></i>
                            {{ __('Categories') }}
                        </h3>
                    </div>
                    
                    {{-- Category List --}}
                    <div class="flex-1 overflow-y-auto p-4 space-y-2">
                        @foreach($faqCategories as $category)
                            <button @click="switchGroup({{ $category->id }})" 
                                    class="w-full text-left px-6 py-4 rounded-xl text-sm font-bold transition-all duration-300 flex items-center justify-between group relative overflow-hidden"
                                    :class="activeGroup === {{ $category->id }} 
                                        ? 'bg-brand-primary text-white shadow-lg shadow-green-900/20' 
                                        : 'text-slate-500 hover:bg-white hover:text-brand-primary hover:shadow-sm'">
                                
                                <span class="relative z-10">{{ $category->getTranslation('title') }}</span>
                                
                                {{-- REVISI: Bungkus ikon dalam SPAN. Logika warna dipindah ke SPAN ini agar reaktif --}}
                                <span class="relative z-10 transition-transform duration-300 flex items-center justify-center"
                                      :class="activeGroup === {{ $category->id }} 
                                            ? 'text-white translate-x-1' 
                                            : 'text-slate-400 group-hover:text-brand-primary'">
                                    
                                    {{-- Ikon Lucide hanya sebagai elemen statis, warnanya mengikuti parent (span) --}}
                                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                                </span>
                            </button>
                        @endforeach
                    </div>

                    {{-- Contact Support Teaser --}}
                    {{-- <div class="p-6 mt-auto border-t border-gray-200 bg-white">
                        <p class="text-xs text-gray-400 mb-3 font-bold uppercase tracking-wider">{{ __('Still need help?') }}</p>
                        <a href="{{ route('pages.contact') }}" class="flex items-center gap-3 text-sm font-bold text-slate-900 hover:text-brand-primary transition group">
                            <div class="w-8 h-8 rounded-full bg-brand-dark flex items-center justify-center text-white group-hover:bg-brand-primary transition">
                                <i data-lucide="message-circle" class="w-4 h-4"></i>
                            </div>
                            {{ __('Contact Support') }}
                        </a>
                    </div> --}}
                </aside>

                {{-- RIGHT: ACCORDION CONTENT --}}
                <div class="flex-1 p-8 md:p-12 bg-white">
                    @foreach($faqCategories as $category)
                        <template x-if="activeGroup === {{ $category->id }}">
                            <div class="animate-fade-in-up"> 
                                <div class="mb-10 pb-6 border-b border-gray-100">
                                    <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">{{ __('F.A.Q') }}</span>
                                    <h2 class="text-3xl font-black text-slate-900">{{ $category->getTranslation('title') }}</h2>
                                </div>

                                <div class="space-y-4">
                                    @forelse($category->children as $faq)
                                        <div class="border border-gray-100 rounded-2xl transition-all duration-300 hover:border-brand-primary/30 hover:shadow-sm bg-white"
                                             x-data="{ id: {{ $faq->id }} }">
                                            
                                            <button @click="activeItem = (activeItem === id ? null : id)" 
                                                    class="w-full flex justify-between items-center p-6 text-left select-none focus:outline-none group">
                                                <span class="font-bold text-slate-700 text-lg pr-8 group-hover:text-brand-primary transition">
                                                    {{ $faq->getTranslation('title') }}
                                                </span>
                                                <div class="w-8 h-8 rounded-full flex items-center justify-center transition-colors duration-300 flex-shrink-0"
                                                     :class="activeItem === id ? 'bg-brand-primary text-white' : 'bg-gray-100 text-gray-400 group-hover:text-brand-primary'">
                                                    <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-300" 
                                                       :class="activeItem === id ? 'rotate-180' : ''"></i>
                                                </div>
                                            </button>

                                            <div x-show="activeItem === id" x-collapse x-cloak>
                                                <div class="px-6 pb-8 pt-2">
                                                    <div class="prose prose-sm max-w-none text-slate-500 prose-p:leading-relaxed prose-a:text-brand-primary hover:prose-a:text-green-700">
                                                        {!! $faq->getTranslation('answer') !!}
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @empty
                                        <div class="py-16 text-center border-2 border-dashed border-gray-100 rounded-3xl bg-gray-50/50">
                                            <div class="bg-white w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                                <i data-lucide="inbox" class="w-8 h-8 text-slate-300"></i>
                                            </div>
                                            <h3 class="font-bold text-slate-900">{{ __('No Questions Yet') }}</h3>
                                            <p class="text-sm text-slate-400 mt-1">{{ __('This category is currently empty.') }}</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </template>
                    @endforeach
                </div>

            </div>
        </div>
    </section>

</x-web.main-layout>