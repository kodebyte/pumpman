<x-web.main-layout>

    {{-- 1. HEADER --}}
    <div class="pt-14 pb-10 bg-brand-gray relative overflow-hidden">
        {{-- Background Decor --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-soft/40 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        
        <div class="container mx-auto px-4 md:px-6 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition">{{ __('Home') }}</a>
                        <i data-lucide="chevron-right" class="w-3 h-3 text-slate-300"></i>
                        <span class="text-brand-primary">{{ __('Contact Us') }}</span>
                    </div>
                    {{-- STANDARDIZED TITLE --}}
                    <h1 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight leading-tight">
                        {{ __('Get In Touch') }}
                    </h1>
                </div>
                <p class="text-slate-500 text-sm max-w-md text-left md:text-right leading-relaxed border-l-4 border-brand-primary pl-4 md:border-l-0 md:border-r-4 md:pr-4">
                    {{ __('Our engineers are ready to assist you. Consult your industrial needs or request a quotation today.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT (Form & Info) --}}
    <section class="bg-brand-gray pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-200 text-green-800 px-6 py-4 rounded-xl mb-8 flex items-start gap-3 shadow-sm animate-fade-in-up">
                    <i data-lucide="check-circle" class="w-5 h-5 mt-0.5 text-brand-primary"></i>
                    <div>
                        <strong class="font-bold">{{ __('Message Sent!') }}</strong>
                        <span class="block text-sm">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-0 shadow-2xl rounded-[2.5rem] overflow-hidden">
                
                {{-- LEFT: CONTACT INFO (RE-DESIGNED) --}}
                {{-- Background Hijau Solid dengan Grid Pattern --}}
                <div class="lg:col-span-5 bg-brand-primary relative p-10 md:p-14 text-white">
                    {{-- Industrial Pattern Overlay --}}
                    <div class="absolute inset-0 opacity-10 pointer-events-none" 
                         style="background-image: linear-gradient(#ffffff 1px, transparent 1px), linear-gradient(90deg, #ffffff 1px, transparent 1px); background-size: 30px 30px;">
                    </div>
                    
                    <div class="relative z-10 h-full flex flex-col justify-between">
                        
                        {{-- Top Info --}}
                        <div class="space-y-10">
                            <div>
                                <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-white/80 mb-2">{{ __('Headquarters') }}</h3>
                                <h2 class="text-2xl font-black uppercase leading-tight tracking-tight">
                                    {{ $contact['contact_company_name'] ?? 'PT. Pumpman Indonesia' }}
                                </h2>
                                <div class="mt-6 flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0 border border-white/10">
                                        <i data-lucide="map-pin" class="w-5 h-5 text-white"></i>
                                    </div>
                                    <p class="text-white/90 text-sm leading-relaxed font-medium pt-1">
                                        {!! nl2br(e($contact['contact_address'])) !!}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <div class="flex items-center gap-4 group">
                                    <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0 border border-white/10 group-hover:bg-white group-hover:text-brand-primary transition">
                                        <i data-lucide="phone" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-bold text-white/60 uppercase tracking-widest block mb-1">{{ __('Call Us') }}</span>
                                        <a href="tel:{{ $contact['contact_phone'] }}" class="text-white font-bold text-lg tracking-wide hover:underline decoration-2 underline-offset-4">
                                            {{ $contact['contact_phone'] }}
                                        </a>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 group">
                                    <div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm flex items-center justify-center flex-shrink-0 border border-white/10 group-hover:bg-white group-hover:text-brand-primary transition">
                                        <i data-lucide="mail" class="w-5 h-5"></i>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-bold text-white/60 uppercase tracking-widest block mb-1">{{ __('Email') }}</span>
                                        <x-web.obfuscated-email 
                                            :email="$contact['contact_email']" 
                                            class="text-white font-bold text-lg tracking-wide hover:underline decoration-2 underline-offset-4" 
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Bottom Info (Hours) --}}
                        <div class="mt-12 pt-8 border-t border-white/20">
                            <div class="flex items-start gap-4">
                                <i data-lucide="clock" class="w-5 h-5 text-white/80 mt-1"></i>
                                <div>
                                    <h4 class="font-bold text-white mb-1">{{ __('Operational Hours') }}</h4>
                                    <p class="text-white/80 text-sm whitespace-pre-line leading-relaxed">
                                        {!! e($contact['contact_business_hours']) !!}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- RIGHT: FORM (Clean White) --}}
                <div class="lg:col-span-7 bg-white p-10 md:p-14">
                    <div class="mb-10">
                        <span class="text-brand-primary font-bold tracking-widest uppercase text-xs mb-2 block">{{ __('Discussion') }}</span>
                        <h3 class="text-3xl font-black text-slate-900 mb-4">{{ __('Start a Conversation') }}</h3>
                        <p class="text-slate-500 text-sm leading-relaxed max-w-lg">
                            {{ __('Need a custom pump solution or a quotation? Fill out the form below and our engineering team will respond within 24 hours.') }}
                        </p>
                    </div>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf 

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-900 uppercase tracking-wider">{{ __('Your Name') }} <span class="text-red-500">*</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex: Budi Santoso" 
                                    class="w-full bg-gray-50 border rounded-lg px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-0 transition placeholder-gray-400 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-200' }}">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-900 uppercase tracking-wider">{{ __('Email Address') }} <span class="text-red-500">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Ex: budi@company.com" 
                                    class="w-full bg-gray-50 border rounded-lg px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-0 transition placeholder-gray-400 {{ $errors->has('email') ? 'border-red-500' : 'border-gray-200' }}">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-900 uppercase tracking-wider">{{ __('Subject / Topic') }} <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="topic" class="w-full bg-gray-50 border border-gray-200 rounded-lg px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-0 transition appearance-none cursor-pointer">
                                    <option value="" disabled selected>{{ __('Select Inquiry Type...') }}</option>
                                    <option value="Request Quotation" {{ old('topic') == 'Request Quotation' ? 'selected' : '' }}>{{ __('Request Quotation (RFQ)') }}</option>
                                    <option value="Technical Consultation" {{ old('topic') == 'Technical Consultation' ? 'selected' : '' }}>{{ __('Technical Consultation') }}</option>
                                    <option value="Product Availability" {{ old('topic') == 'Product Availability' ? 'selected' : '' }}>{{ __('Product Availability') }}</option>
                                    <option value="Partnership" {{ old('topic') == 'Partnership' ? 'selected' : '' }}>{{ __('Partnership / Distributor') }}</option>
                                    <option value="Other" {{ old('topic') == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                </select>
                                <i data-lucide="chevron-down" class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400 pointer-events-none"></i>
                            </div>
                            @error('topic')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-900 uppercase tracking-wider">{{ __('Message') }} <span class="text-red-500">*</span></label>
                            <textarea name="message" rows="5" placeholder="{{ __('Describe your project requirements or questions here...') }}" 
                                    class="w-full bg-gray-50 border rounded-lg px-4 py-3.5 text-sm font-bold text-slate-900 focus:outline-none focus:border-brand-primary focus:bg-white focus:ring-0 transition placeholder-gray-400 {{ $errors->has('message') ? 'border-red-500' : 'border-gray-200' }}">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"></div>
                            @error('g-recaptcha-response')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-xl hover:bg-brand-primary transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2 group">
                            {{ __('Send Inquiry') }} 
                            <i data-lucide="send" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. MAP SECTION --}}
    <section class="h-[500px] w-full bg-slate-900 relative overflow-hidden grayscale contrast-125">
        <iframe 
            src="{{ $contact['contact_map_embed'] ?? 'https://www.google.com/maps/embed?pb=...' }}" 
            width="100%" 
            height="100%" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        
        <div class="absolute bottom-10 left-6 md:left-20 bg-white p-8 rounded-2xl shadow-2xl max-w-sm border-l-8 border-brand-primary">
            <div class="flex items-center gap-3 mb-4">
                <i data-lucide="map" class="w-6 h-6 text-brand-primary"></i>
                <h4 class="font-black text-xl text-slate-900">{{ __('Visit Our Workshop') }}</h4>
            </div>
            <p class="text-sm text-slate-500 mb-6 leading-relaxed">
                {{ __('See our pumps in action. Schedule a visit to our workshop for a live demo and consultation.') }}
            </p>
            <a href="{{ $contact['contact_google_map_link'] ?? '#' }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-bold bg-slate-900 text-white px-6 py-3 rounded-lg hover:bg-brand-primary transition shadow-lg">
                {{ __('Get Directions') }} <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
            </a>
        </div>
    </section>

    @push('scripts')
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endpush

</x-web.main-layout>