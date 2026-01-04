<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('News & Updates') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Technical Insights') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Latest updates, engineering case studies, and industry news directly from the Pumpman team.') }}
                </p>
            </div>

            {{-- Category Filter --}}
            <div class="mt-8 flex flex-wrap gap-2">
                <a href="{{ route('posts.index') }}" 
                   class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition shadow-sm
                   {{ !request()->route('postType') ? 'bg-brand-dark text-white' : 'bg-white text-slate-500 hover:text-brand-primary hover:shadow-md' }}">
                    {{ __('All Updates') }}
                </a>

                @foreach ($postTypes as $postType)
                    <a href="{{ route('posts.index', $postType->slug) }}" 
                       class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition shadow-sm
                       {{ request()->route('postType')?->slug === $postType->slug ? 'bg-brand-dark text-white' : 'bg-white text-slate-500 hover:text-brand-primary hover:shadow-md' }}">
                        {{ $postType->getTranslation('name') }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <section class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            
            {{-- FEATURED POST --}}
            @if($featuredPost)
                <div class="mb-16">
                    <a href="{{ route('posts.show', $featuredPost->slug) }}" class="group block relative rounded-[2.5rem] overflow-hidden shadow-2xl h-[500px] border border-gray-200/60">
                        {{-- Background Image --}}
                        <div class="absolute inset-0 bg-slate-900">
                            <img src="{{ $featuredPost->thumbnail ? asset('storage/'.$featuredPost->thumbnail) : asset('assets/images/placeholder-industrial.jpg') }}" 
                                class="w-full h-full object-cover opacity-60 group-hover:opacity-40 group-hover:scale-105 transition duration-700 ease-out">
                        </div>
                        
                        {{-- Content Overlay --}}
                        <div class="absolute inset-0 flex flex-col justify-end p-8 md:p-12 bg-gradient-to-t from-black/90 via-black/40 to-transparent">
                            <div class="max-w-3xl relative z-10 translate-y-4 group-hover:translate-y-0 transition duration-500">
                                <div class="flex items-center gap-4 mb-4">
                                    <span class="bg-brand-primary text-white text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-widest">
                                        {{ __('Featured Story') }}
                                    </span>
                                    @if($featuredPost->type)
                                        <span class="text-white/80 text-xs font-bold uppercase tracking-wider border-l border-white/30 pl-4">
                                            {{ $featuredPost->type->getTranslation('name') }}
                                        </span>
                                    @endif
                                </div>
                                
                                <h2 class="text-3xl md:text-5xl font-black text-white leading-tight mb-4 group-hover:text-brand-primary transition-colors">
                                    {{ $featuredPost->getTranslation('title') }}
                                </h2>
                                
                                <p class="text-slate-300 text-sm md:text-base line-clamp-2 mb-6 max-w-2xl">
                                    {{ Str::limit(strip_tags($featuredPost->getTranslation('content')), 150) }}
                                </p>

                                <div class="flex items-center gap-2 text-xs font-bold text-white uppercase tracking-widest opacity-0 group-hover:opacity-100 transition duration-500 delay-100">
                                    {{ __('Read Full Article') }} <i data-lucide="arrow-right" class="w-4 h-4 text-brand-primary"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            {{-- POSTS GRID --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                @forelse($posts as $post)
                    <article class="group bg-white rounded-[2rem] border border-gray-200/60 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                        {{-- Thumbnail --}}
                        <a href="{{ route('posts.show', $post->slug) }}" class="block relative h-60 overflow-hidden">
                            <img src="{{ $post->thumbnail ? asset('storage/'.$post->thumbnail) : asset('assets/images/placeholder.png') }}" 
                                 class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-out">
                            
                            {{-- Date Badge --}}
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur text-slate-900 text-[10px] font-black px-3 py-1.5 rounded-lg uppercase tracking-widest shadow-sm">
                                {{ is_null($post->published_at) ?: $post->published_at->format('d M Y') }}
                            </div>
                        </a>

                        {{-- Content --}}
                        <div class="p-8 flex flex-col flex-1">
                            <div class="mb-4">
                                @if($post->type)
                                    <span class="text-brand-primary text-[10px] font-bold uppercase tracking-widest mb-2 block">
                                        {{ $post->type->getTranslation('name') }}
                                    </span>
                                @endif
                                
                                <h3 class="text-xl font-bold text-slate-900 leading-tight group-hover:text-brand-primary transition line-clamp-2">
                                    <a href="{{ route('posts.show', $post->slug) }}">
                                        {{ $post->getTranslation('title') }}
                                    </a>
                                </h3>
                            </div>

                            <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-6 flex-1">
                                {{ Str::limit(strip_tags($post->getTranslation('content')), 100) }}
                            </p>

                            <div class="pt-6 border-t border-gray-100 flex justify-between items-center">
                                <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-900 uppercase tracking-widest group-hover:text-brand-primary transition">
                                    {{ __('Read More') }} <i data-lucide="arrow-right" class="w-3 h-3 transition-transform group-hover:translate-x-1"></i>
                                </a>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    {{ ceil(str_word_count(strip_tags($post->getTranslation('content'))) / 200) }} {{ __('min read') }}
                                </span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-gray-100">
                            <i data-lucide="newspaper" class="w-8 h-8 text-slate-300"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900">{{ __('No updates available') }}</h3>
                        <p class="text-slate-500 text-sm">{{ __('Stay tuned for future technical insights.') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- PAGINATION --}}
            <div class="flex justify-center border-t border-gray-200 pt-10">
                <nav class="flex items-center gap-4">
                    @if($posts->previousPageUrl())
                        <a href="{{ $posts->previousPageUrl() }}" class="flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-xl text-xs font-bold text-slate-700 uppercase tracking-widest hover:border-brand-primary hover:text-brand-primary transition shadow-sm">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Previous') }}
                        </a>
                    @else
                        <button disabled class="flex items-center gap-2 px-6 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-slate-400 uppercase tracking-widest cursor-not-allowed">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i> {{ __('Previous') }}
                        </button>
                    @endif

                    @if($posts->nextPageUrl())
                        <a href="{{ $posts->nextPageUrl() }}" class="flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-xl text-xs font-bold text-slate-700 uppercase tracking-widest hover:border-brand-primary hover:text-brand-primary transition shadow-sm">
                            {{ __('Next Page') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    @else
                        <button disabled class="flex items-center gap-2 px-6 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-bold text-slate-400 uppercase tracking-widest cursor-not-allowed">
                            {{ __('Next Page') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    @endif
                </nav>
            </div>

        </div>
    </section>
 
</x-web.main-layout>