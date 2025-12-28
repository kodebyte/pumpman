<x-web.main-layout>
    {{-- Inject SEO Variables --}}
    <x-slot name="title">{{ $title }}</x-slot>
    <x-slot name="description">{{ $description }}</x-slot>
    <x-slot name="image">{{ $image }}</x-slot>

    {{-- 1. HEADER & HERO --}}
    <div class="pt-14 pb-10 bg-brand-gray relative">
        <div class="container mx-auto px-4 md:px-6">
            
            {{-- Breadcrumb / Meta --}}
            <div class="flex flex-wrap items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-6">
                <a href="{{ route('posts.index') }}" class="hover:text-brand-primary transition">{{ __('News') }}</a>
                <i data-lucide="chevron-right" class="w-3 h-3"></i>
                @if($post->type)
                    <span class="text-brand-primary">{{ $post->type->getTranslation('name') }}</span>
                    <span class="w-1 h-1 rounded-full bg-slate-300"></span>
                @endif
                
                {{-- PERBAIKAN: Cek apakah published_at ada isinya --}}
                @if($post->published_at)
                    <span>{{ $post->published_at->format('d M Y') }}</span>
                @endif
            </div>

            {{-- Title --}}
            <h1 class="text-3xl md:text-5xl font-display font-bold text-slate-900 leading-tight mb-8 max-w-4xl">
                {{ $post->getTranslation('title') }}
            </h1>

            {{-- Author Info --}}
            <div class="flex items-center gap-4 pb-8 border-b border-gray-200">
                <div class="w-10 h-10 rounded-xl bg-white border border-gray-200 flex items-center justify-center overflow-hidden">
                    <span class="font-black text-brand-dark">{{ substr($post->author->name ?? 'A', 0, 1) }}</span>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-900 uppercase tracking-wider">{{ $post->author->name ?? 'Pumpman Team' }}</p>
                    <p class="text-[10px] text-slate-500 font-medium">{{ ceil(str_word_count(strip_tags($post->getTranslation('content'))) / 200) }} {{ __('min read') }}</p>
                </div>
            </div>

        </div>
    </div>

    {{-- 2. ARTICLE CONTENT --}}
    <article class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            
            {{-- Main Image --}}
            @if($post->thumbnail)
                <div class="max-w-5xl mb-12 rounded-[2.5rem] overflow-hidden shadow-xl border border-gray-200/60 bg-white">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" 
                         alt="{{ $post->getTranslation('title') }}" 
                         class="w-full h-auto object-cover">
                </div>
            @endif

            {{-- Content Body --}}
            <div class="max-w-3xl mx-auto">
                <div class="prose prose-lg prose-slate max-w-none 
                            prose-headings:font-display prose-headings:font-bold prose-headings:text-slate-900 
                            prose-a:text-brand-primary prose-a:no-underline hover:prose-a:underline
                            prose-strong:text-slate-900 prose-blockquote:border-brand-primary prose-blockquote:bg-white prose-blockquote:rounded-xl prose-blockquote:p-6 prose-blockquote:not-italic prose-blockquote:shadow-sm">
                    {!! $post->getTranslation('content') !!}
                </div>

                {{-- Share & Tags --}}
                <div class="mt-16 pt-8 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ __('Share:') }}</span>
                        <div class="flex gap-2">
                            <button class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:bg-brand-dark hover:border-brand-dark hover:text-white transition shadow-sm" title="Share">
                                <i data-lucide="share-2" class="w-4 h-4"></i>
                            </button>
                            <button class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center hover:bg-brand-dark hover:border-brand-dark hover:text-white transition shadow-sm" title="Copy Link">
                                <i data-lucide="link" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                    
                    <a href="{{ route('posts.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-dark border-b border-brand-dark pb-0.5 hover:text-brand-primary hover:border-brand-primary transition uppercase tracking-widest">
                        <i data-lucide="arrow-left" class="w-3 h-3"></i> {{ __('Back to News') }}
                    </a>
                </div>
            </div>

        </div>
    </article>

    {{-- 3. RELATED POSTS --}}
    @if($relatedPosts->count() > 0)
    <section class="py-20 bg-white border-t border-gray-100">
        <div class="container mx-auto px-4 md:px-6">
            <div class="flex justify-between items-end mb-10">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">{{ __('Related Insights') }}</h2>
                    <p class="text-slate-500 text-sm mt-1">{{ __('More articles you might find interesting.') }}</p>
                </div>
                <a href="{{ route('posts.index') }}" class="hidden md:flex items-center gap-2 text-xs font-bold text-brand-primary hover:text-brand-dark transition uppercase tracking-widest">
                    {{ __('View All') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedPosts as $related)
                <a href="{{ route('posts.show', $related->slug) }}" class="group block">
                    <div class="relative overflow-hidden rounded-[1.5rem] aspect-[4/3] mb-5 border border-gray-100">
                        <img src="{{ $related->thumbnail ? asset('storage/'.$related->thumbnail) : asset('assets/images/placeholder.png') }}" 
                             class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700">
                        
                        @if($related->type)
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur text-brand-dark text-[10px] font-bold px-3 py-1 rounded-lg uppercase tracking-wider shadow-sm">
                                {{ $related->type->getTranslation('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="space-y-2 px-2">
                        <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            {{-- PERBAIKAN: Cek published_at pada related post --}}
                            @if($related->published_at)
                                <span>{{ $related->published_at->format('d M Y') }}</span>
                                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                            @endif
                            <span>{{ ceil(str_word_count(strip_tags($related->getTranslation('content'))) / 200) }} min</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 leading-tight group-hover:text-brand-primary transition line-clamp-2">
                            {{ $related->getTranslation('title') }}
                        </h3>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

</x-web.main-layout>