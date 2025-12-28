<x-web.main-layout>

    {{-- Background Abu-abu Polos --}}
    <div class="py-24 flex items-center justify-center bg-brand-gray px-4 sm:px-6 lg:px-8">
        {{-- Card: Rounded 2.5rem, Shadow, Border Halus --}}
        <div class="max-w-lg w-full bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-gray-200/60 relative overflow-hidden">
            {{-- Aksen Garis Hijau di Atas (Opsional, pemanis) --}}
            <div class="absolute top-0 left-0 w-full h-1.5 bg-brand-primary"></div>

            <div class="text-center mb-10 mt-2">
                <h2 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight mb-2">{{ __('Welcome Back') }}</h2>
                <p class="text-sm text-slate-500">
                    {{ __('Don\'t have an account?') }} 
                    <a href="{{ route('register') }}" class="font-bold text-brand-primary hover:underline transition">{{ __('Create new account') }}</a>
                </p>
            </div>

            <x-web.auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Email Address') }}</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400 group-focus-within:text-brand-primary transition"></i>
                        <input type="email" name="email" :value="old('email')" required autofocus 
                               class="w-full bg-gray-50 border border-gray-200 text-slate-900 text-sm font-bold rounded-xl focus:ring-brand-primary focus:border-brand-primary block pl-12 p-3.5 transition placeholder-gray-400 focus:bg-white" 
                               placeholder="name@company.com">
                    </div>
                    <x-web.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Password') }}</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400 group-focus-within:text-brand-primary transition"></i>
                        <input type="password" name="password" required autocomplete="current-password"
                               class="w-full bg-gray-50 border border-gray-200 text-slate-900 text-sm font-bold rounded-xl focus:ring-brand-primary focus:border-brand-primary block pl-12 p-3.5 transition placeholder-gray-400 focus:bg-white" 
                               placeholder="••••••••">
                    </div>
                    <x-web.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-brand-primary focus:ring-brand-primary cursor-pointer">
                        <span class="text-slate-500 group-hover:text-brand-primary transition font-medium">{{ __('Remember me') }}</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-bold text-slate-400 hover:text-brand-primary transition">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full bg-brand-dark text-white font-bold py-4 rounded-xl hover:bg-brand-primary transition shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2 group uppercase tracking-widest text-sm">
                    {{ __('Sign In') }} <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
        </div>
    </div>

</x-web.main-layout>