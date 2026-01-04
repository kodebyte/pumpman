<x-web.main-layout>

    <div class="py-24 flex items-center justify-center bg-brand-gray px-4 sm:px-6 lg:px-8">
        <div class="max-w-lg w-full bg-white rounded-[2.5rem] shadow-2xl p-8 md:p-12 border border-gray-200/60 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1.5 bg-brand-primary"></div>

            <div class="text-center mb-10 mt-2">
                <h2 class="text-3xl font-display font-bold text-slate-900 uppercase tracking-tight mb-2">{{ __('Create Account') }}</h2>
                <p class="text-sm text-slate-500">
                    {{ __('Already have an account?') }} 
                    <a href="{{ route('login') }}" class="font-bold text-brand-primary hover:underline transition">{{ __('Login here') }}</a>
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Full Name') }}</label>
                    <div class="relative group">
                        <i data-lucide="user" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400 group-focus-within:text-brand-primary transition"></i>
                        <input type="text" name="name" :value="old('name')" required autofocus
                               class="w-full bg-gray-50 border border-gray-200 text-slate-900 text-sm font-bold rounded-xl focus:ring-brand-primary focus:border-brand-primary block pl-12 p-3.5 transition placeholder-gray-400 focus:bg-white">
                    </div>
                    <x-web.input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Email Address') }}</label>
                    <div class="relative group">
                        <i data-lucide="mail" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400 group-focus-within:text-brand-primary transition"></i>
                        <input type="email" name="email" :value="old('email')" required
                               class="w-full bg-gray-50 border border-gray-200 text-slate-900 text-sm font-bold rounded-xl focus:ring-brand-primary focus:border-brand-primary block pl-12 p-3.5 transition placeholder-gray-400 focus:bg-white">
                    </div>
                    <x-web.input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Password') }}</label>
                    <div class="relative group">
                        <i data-lucide="lock" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400 group-focus-within:text-brand-primary transition"></i>
                        <input type="password" name="password" required autocomplete="new-password"
                               class="w-full bg-gray-50 border border-gray-200 text-slate-900 text-sm font-bold rounded-xl focus:ring-brand-primary focus:border-brand-primary block pl-12 p-3.5 transition placeholder-gray-400 focus:bg-white">
                    </div>
                    <x-web.input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500 mb-2">{{ __('Confirm Password') }}</label>
                    <div class="relative group">
                        <i data-lucide="check-circle" class="absolute left-4 top-3.5 w-5 h-5 text-slate-400 group-focus-within:text-brand-primary transition"></i>
                        <input type="password" name="password_confirmation" required
                               class="w-full bg-gray-50 border border-gray-200 text-slate-900 text-sm font-bold rounded-xl focus:ring-brand-primary focus:border-brand-primary block pl-12 p-3.5 transition placeholder-gray-400 focus:bg-white">
                    </div>
                    <x-web.input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-start gap-3">
                    <input type="checkbox" required id="terms" class="w-4 h-4 mt-0.5 rounded border-gray-300 text-brand-primary focus:ring-brand-primary cursor-pointer">
                    <label for="terms" class="text-xs text-slate-500 leading-relaxed cursor-pointer">
                        {{ __('I agree to the') }} <a href="#" class="font-bold text-slate-900 hover:text-brand-primary hover:underline">{{ __('Terms of Service') }}</a> {{ __('and') }} <a href="#" class="font-bold text-slate-900 hover:text-brand-primary hover:underline">{{ __('Privacy Policy') }}</a>.
                    </label>
                </div>

                <button type="submit" class="w-full bg-brand-primary text-white font-bold py-4 rounded-xl hover:bg-green-700 transition shadow-lg transform hover:-translate-y-0.5 flex items-center justify-center gap-2 uppercase tracking-widest text-sm">
                    {{ __('Create Account') }}
                </button>
            </form>
        </div>
    </div>

</x-web.main-layout>