<x-web.main-layout>

    {{-- 2. SUCCESS CARD --}}
    <section class="bg-brand-gray pt-14 pb-24 relative z-0">
        <div class="container mx-auto px-4 md:px-6">
            <div class="max-w-7xl mx-auto bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-200/60">
                
                {{-- Top Banner --}}
                <div class="bg-green-50 p-10 text-center border-b border-green-100">
                    <div class="flex flex-col items-center justify-center gap-4">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center animate-bounce-slow shrink-0 shadow-sm">
                            <i data-lucide="check-circle" class="w-10 h-10 text-brand-primary"></i>
                        </div>
                        <div class="text-center">
                            <h2 class="text-2xl md:text-3xl font-black text-slate-900 mb-2">{{ __('Request Successful!') }}</h2>
                            <p class="text-slate-600">{{ __('Thank you, your warranty claim request has been received by our engineering team.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-8 md:p-14">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20 items-start">
                        {{-- LEFT: TICKET CODE --}}
                        <div class="flex flex-col justify-center h-full space-y-6 order-1 md:order-1">
                            <div class="text-center bg-gray-50 rounded-[2rem] p-10 border border-gray-200" 
                                 x-data="{ 
                                    code: '{{ session('claim_code') }}',
                                    copied: false,
                                    copyToClipboard() {
                                        navigator.clipboard.writeText(this.code);
                                        this.copied = true;
                                        setTimeout(() => this.copied = false, 2000); 
                                    }
                                 }">
                                
                                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400 mb-6">{{ __('Your Claim Ticket Code') }}</p>
                                
                                <div class="inline-flex items-center gap-3 bg-white border-2 border-dashed border-gray-300 rounded-2xl p-3 pl-6 pr-3 transition hover:border-brand-primary group max-w-full shadow-sm">
                                    <span class="text-2xl font-black text-brand-dark tracking-wider select-all break-all" x-text="code"></span>
                                    <div class="h-8 w-px bg-gray-200 mx-2"></div>
                                    <button @click="copyToClipboard()" 
                                            class="flex-shrink-0 p-3 rounded-xl transition-all duration-300 focus:outline-none"
                                            :class="copied ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-500 hover:text-white hover:bg-brand-primary'"
                                            :title="copied ? '{{ __('Copied!') }}' : '{{ __('Copy Code') }}'">
                                        <i x-show="!copied" data-lucide="copy" class="w-5 h-5"></i>
                                        <div x-show="copied" x-cloak class="flex items-center">
                                            <i data-lucide="check" class="w-5 h-5"></i>
                                        </div>
                                    </button>
                                </div>

                                <div class="h-6 mt-4">
                                    <p x-show="copied" 
                                       x-transition 
                                       class="text-xs font-bold text-brand-primary flex items-center justify-center gap-1">
                                        <i data-lucide="check-circle" class="w-3 h-3"></i> {{ __('Code successfully copied!') }}
                                    </p>
                                </div>

                                <div class="mt-8 flex items-start gap-3 text-left bg-blue-50 p-5 rounded-2xl border border-blue-100 text-sm text-blue-800">
                                    <i data-lucide="mail" class="w-5 h-5 flex-shrink-0 mt-0.5"></i>
                                    <span class="leading-relaxed">
                                        {{ __('Ticket details have been sent to') }} <strong>{{ auth()->user()->email ?? __('your email') }}</strong>. {{ __('Please check your Inbox or Spam folder.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- RIGHT: NEXT STEPS --}}
                        <div class="order-2 md:order-2 md:pl-10 md:border-l md:border-gray-100 h-full">
                            <h3 class="font-bold text-lg mb-10 text-slate-900 flex items-center gap-2 uppercase tracking-wide">
                                <i data-lucide="activity" class="w-5 h-5 text-brand-primary"></i>
                                {{ __('What Next?') }}
                            </h3>
                            
                            <div class="space-y-0 relative pl-2">
                                {{-- Timeline Line --}}
                                <div class="absolute left-6 top-2 bottom-10 w-0.5 bg-gray-200"></div>

                                {{-- Step 1 --}}
                                <div class="flex gap-6 relative group">
                                    <div class="w-12 h-12 rounded-full bg-brand-primary text-white flex items-center justify-center text-sm font-bold shrink-0 z-10 ring-8 ring-white shadow-lg">1</div>
                                    <div class="pb-12 pt-1">
                                        <h4 class="font-bold text-slate-900">{{ __('Admin Verification') }}</h4>
                                        <p class="text-sm text-slate-500 mt-2 leading-relaxed">{{ __('Our team will verify your data & documents (1x24 Working Hours). Check status periodically with the ticket code.') }}</p>
                                    </div>
                                </div>
                                
                                {{-- Step 2 --}}
                                <div class="flex gap-6 relative group">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-sm font-bold shrink-0 z-10 ring-8 ring-white border border-gray-200">2</div>
                                    <div class="pb-12 pt-1">
                                        <h4 class="font-bold text-gray-400">{{ __('Shipping Instructions') }}</h4>
                                        <p class="text-xs text-gray-400 mt-2 leading-relaxed">{{ __('If approved, we will send unit shipping instructions to the Service Center via WhatsApp/Email.') }}</p>
                                    </div>
                                </div>

                                {{-- Step 3 --}}
                                <div class="flex gap-6 relative group">
                                    <div class="w-12 h-12 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center text-sm font-bold shrink-0 z-10 ring-8 ring-white border border-gray-200">3</div>
                                    <div>
                                        <h4 class="font-bold text-gray-400 mt-1">{{ __('Unit Repair') }}</h4>
                                        <p class="text-xs text-gray-400 mt-2 leading-relaxed">{{ __('Our expert technicians will repair the unit and inform the estimated completion.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Bottom Buttons --}}
                    <div class="mt-16 pt-10 border-t border-gray-100 flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('warranty-claim') }}" class="sm:w-auto w-full bg-brand-dark text-white px-8 py-4 rounded-xl font-bold hover:bg-brand-primary transition text-center flex items-center justify-center gap-2 group shadow-lg shadow-gray-200">
                            <i data-lucide="plus-circle" class="w-4 h-4 group-hover:rotate-90 transition"></i>
                            {{ __('Submit Another Claim') }}
                        </a>
                        <a href="{{ route('home') }}" class="sm:w-auto w-full border border-gray-200 text-slate-600 px-8 py-4 rounded-xl font-bold hover:bg-gray-50 transition text-center">
                            {{ __('Back to Home') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>

</x-web.main-layout>