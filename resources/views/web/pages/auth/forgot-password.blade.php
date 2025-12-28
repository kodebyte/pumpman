<x-web.main-layout>

    <div class="pt-24 flex items-center justify-center bg-brand-gray pb-24 px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-gray-200/60 relative overflow-hidden">
            {{-- Industrial Accent Line --}}
            <div class="absolute top-0 left-0 w-full h-1.5 bg-brand-primary"></div>

            <div class="text-center mb-10 mt-2">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-green-50 text-brand-primary rounded-2xl mb-6 shadow-sm border border-green-100">
                    <i data-lucide="key-round" class="w-8 h-8"></i>
                </div>
                <h2 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight mb-3">{{ __('Forgot Password?') }}</h2>
                <p class="text-sm text-slate-500 leading-relaxed max-w-xs mx-auto">
                    {{ __('No worries. Enter your email and we will send you a link to reset your password.') }}
                </p>
            </div>

            <x-web.auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Email Address') }}</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400 group-focus-within:text-brand-primary transition"></i>
                        <input type="email" name="email" :value="old('email')" required autofocus class="w-full bg-gray-50 border border-gray-200 text-slate-900 text-sm font-bold rounded-xl focus:ring-brand-primary focus:border-brand-primary block pl-12 p-3.5 transition placeholder-gray-400 focus:bg-white" placeholder="name@company.com">
                    </div>
                    <x-web.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <button type="submit" class="w-full bg-brand-dark text-white font-bold py-4 rounded-xl hover:bg-brand-primary transition shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2 group uppercase tracking-widest text-sm">
                    {{ __('Send Reset Link') }} <i data-lucide="send" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <div class="mt-8 text-center border-t border-gray-100 pt-6">
                <a href="{{ route('login') }}" class="text-sm font-bold text-slate-400 hover:text-brand-primary flex items-center justify-center gap-2 transition group">
                    <i data-lucide="arrow-left" class="w-4 h-4 group-hover:-translate-x-1 transition-transform"></i> {{ __('Back to Login') }}
                </a>
            </div>
        </div>
    </div>

</x-web.main-layout>