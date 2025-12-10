<x-admin.guest-layout>

    <x-admin.auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div>
            <x-admin.input-label for="email" :value="__('Email')" />
            <x-admin.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-admin.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-admin.input-label for="password" :value="__('Password')" />
            <x-admin.text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-admin.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-admin.primary-button class="ms-3">
                {{ __('Log in') }}
            </x-admin.primary-button>
        </div>
    </form>
    
</x-admin.guest-layout>