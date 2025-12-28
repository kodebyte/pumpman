<x-web.main-layout>

    {{-- 1. HEADER --}}
    {{-- CONSISTENCY: pt-32 pb-12, Uppercase 3XL Title --}}
    <div class="pt-14 pb-12 bg-brand-gray relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Careers') }}</span>
                    </div>
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Join Our Team') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Help us engineer the future of fluid management. We are looking for talented individuals with passion and precision.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. VALUES SECTION --}}
    <section class="bg-brand-gray pb-12 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Value 1 --}}
                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-brand-soft rounded-xl flex items-center justify-center text-brand-primary mb-6 group-hover:scale-110 transition">
                        <i data-lucide="rocket" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">{{ __('Innovation Driven') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ __('Work with advanced industrial technology and contribute to creating efficient solutions.') }}</p>
                </div>
                
                {{-- Value 2 --}}
                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-brand-soft rounded-xl flex items-center justify-center text-brand-primary mb-6 group-hover:scale-110 transition">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">{{ __('Collaborative Culture') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ __('We value every technical insight. Collaboration between engineers and staff is our key.') }}</p>
                </div>

                {{-- Value 3 --}}
                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm hover:shadow-md transition group">
                    <div class="w-12 h-12 bg-brand-soft rounded-xl flex items-center justify-center text-brand-primary mb-6 group-hover:scale-110 transition">
                        <i data-lucide="heart" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">{{ __('Safety & Wellness') }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ __('Work-life balance and workplace safety are our top priorities.') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. OPEN POSITIONS LIST --}}
    <section id="openings" class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            
            <div class="mb-10 flex items-end gap-4">
                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-wide">{{ __('Open Positions') }}</h2>
                <div class="h-1 flex-1 bg-gray-200 rounded-full mb-2"></div>
            </div>

            <div class="space-y-6">
                @forelse($careers as $job)
                    <div x-data="{ open: false }" 
                        class="group bg-white rounded-[2rem] border border-gray-200 transition-all duration-300 overflow-hidden"
                        :class="open ? 'shadow-xl ring-1 ring-brand-primary border-brand-primary' : 'hover:border-brand-primary/50 hover:shadow-lg'">
                        
                        {{-- CARD HEADER (Clickable) --}}
                        <div @click="open = !open" 
                            class="p-8 md:p-10 cursor-pointer flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative">
                            
                            {{-- Left: Job Info --}}
                            <div class="flex-1 space-y-3">
                                <div class="flex flex-wrap items-center gap-3">
                                    <span class="px-3 py-1 bg-brand-dark text-white text-[10px] font-bold uppercase tracking-widest rounded-lg">
                                        {{ $job->type }}
                                    </span>
                                    <div class="flex items-center gap-1.5 text-slate-400 text-xs font-bold uppercase tracking-wider">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                        {{ $job->location }}
                                    </div>
                                </div>

                                <h4 class="text-2xl md:text-3xl font-black text-slate-900 leading-tight transition-colors duration-300"
                                    :class="open ? 'text-brand-primary' : 'group-hover:text-brand-primary'">
                                    {{ $job->getTranslation('title') }}
                                </h4>
                            </div>

                            {{-- Right: Status & Toggle --}}
                            <div class="flex items-center gap-6">
                                <div class="hidden md:block text-right">
                                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mb-1">{{ __('Status') }}</p>
                                    <p class="text-xs font-bold text-brand-primary flex items-center justify-end gap-1.5">
                                        <span class="w-2 h-2 bg-brand-primary rounded-full animate-pulse"></span>
                                        {{ __('Hiring Now') }}
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-full flex items-center justify-center transition-all duration-300 border border-gray-100"
                                    :class="open ? 'bg-brand-primary text-white rotate-180 border-brand-primary' : 'bg-gray-50 text-slate-400 group-hover:bg-brand-soft group-hover:text-brand-primary'">
                                    <i data-lucide="chevron-down" class="w-5 h-5"></i>
                                </div>
                            </div>
                        </div>

                        {{-- CARD CONTENT (Accordion) --}}
                        <div x-show="open" 
                            x-collapse
                            x-cloak
                            class="border-t border-gray-100">
                            <div class="p-8 md:p-10 bg-gray-50/30">
                                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                                    
                                    {{-- Description --}}
                                    <div class="lg:col-span-8">
                                        <div class="prose prose-sm prose-slate max-w-none">
                                            <h5 class="text-slate-900 font-bold uppercase tracking-widest text-xs mb-4 flex items-center gap-2">
                                                <span class="w-8 h-1 bg-brand-primary rounded-full"></span>
                                                {{ __('Job Description & Requirements') }}
                                            </h5>
                                            <div class="leading-relaxed">
                                                {!! $job->getTranslation('description') !!}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Sidebar Info --}}
                                    <div class="lg:col-span-4 space-y-6">
                                        <div class="bg-white p-6 rounded-2xl border border-gray-200 shadow-sm space-y-6">
                                            <div class="space-y-4">
                                                <div class="pb-4 border-b border-gray-50">
                                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Salary Range') }}</p>
                                                    <p class="text-sm font-bold text-slate-900">{{ $job->salary_range ?? __('Competitive') }}</p>
                                                </div>
                                                <div>
                                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">{{ __('Closing Date') }}</p>
                                                    <p class="text-sm font-bold text-slate-900">
                                                        {{ $job->closing_date ? \Carbon\Carbon::parse($job->closing_date)->format('d F Y') : __('Until Filled') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <a href="mailto:hrd@pumpman.co.id?subject=Application for {{ $job->getTranslation('title') }}" 
                                            class="flex items-center justify-center gap-2 w-full py-4 bg-brand-dark text-white rounded-xl font-bold uppercase tracking-widest text-xs hover:bg-brand-primary transition-all duration-300 shadow-lg group/btn">
                                                {{ __('Apply Now') }} <i data-lucide="arrow-up-right" class="w-4 h-4 group-hover/btn:translate-x-0.5 group-hover/btn:-translate-y-0.5 transition-transform"></i>
                                            </a>
                                        </div>

                                        <p class="text-[10px] text-slate-400 text-center italic leading-relaxed">
                                            {{ __('*Only shortlisted candidates will be contacted via email.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-24 bg-white rounded-[2.5rem] border-2 border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                            <i data-lucide="briefcase" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">{{ __('No positions available') }}</h3>
                        <p class="text-slate-500 text-sm">{{ __('Please check back later for new opportunities.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- 4. GENERAL APPLICATION CTA --}}
    <section class="py-20 bg-brand-dark text-white relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        
        <div class="container mx-auto px-4 md:px-6 relative z-10 text-center">
            <div class="max-w-2xl mx-auto">
                <h3 class="text-3xl font-display font-bold mb-4">{{ __('Don\'t see a perfect fit?') }}</h3>
                <p class="text-white/70 mb-8 text-lg leading-relaxed">
                    {{ __('We are always looking for engineering talent. Send your CV to our HR department and we will keep it for future openings.') }}
                </p>
                <a href="mailto:hrd@pumpman.co.id" class="inline-flex items-center gap-2 text-brand-primary font-bold border-b border-brand-primary hover:text-white hover:border-white transition pb-1">
                    {{ __('Send General Application') }} <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </section>

</x-web.main-layout>