<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Add New User') }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Users' => route('admin.users.index'),
                        'Create' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <h3 class="font-bold text-gray-700">Customer Profile</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <x-admin.input-label for="name" :value="__('Full Name')" />
                                    <x-admin.text-input name="name" :value="old('name')" required autofocus class="w-full text-lg font-semibold" placeholder="e.g. Budi Santoso" />
                                    <x-admin.input-error :messages="$errors->get('name')" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-admin.input-label for="email" :value="__('Email Address')" />
                                        <x-admin.text-input type="email" name="email" :value="old('email')" required class="w-full" placeholder="budi@example.com" />
                                        <x-admin.input-error :messages="$errors->get('email')" />
                                    </div>
                                    <div>
                                        <x-admin.input-label for="phone" :value="__('Phone Number')" />
                                        <x-admin.text-input name="phone" :value="old('phone')" class="w-full" placeholder="e.g. 0812..." />
                                        <x-admin.input-error :messages="$errors->get('phone')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <h3 class="font-bold text-gray-700">Company Information (B2B)</h3>
                            </div>
                            
                            <div>
                                <x-admin.input-label for="company_name" :value="__('Company Name')" />
                                <x-admin.text-input name="company_name" :value="old('company_name')" class="w-full" placeholder="Optional for individual customers" />
                                <p class="text-xs text-gray-500 mt-1">Leave blank if this is a personal account.</p>
                                <x-admin.input-error :messages="$errors->get('company_name')" />
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <h3 class="font-bold text-gray-700">Security</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-admin.input-label for="password" :value="__('Password')" />
                                    <x-admin.text-input id="password" type="password" name="password" required class="w-full" />
                                    <x-admin.input-error :messages="$errors->get('password')" />
                                </div>

                                <div>
                                    <x-admin.input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    <x-admin.text-input id="password_confirmation" type="password" name="password_confirmation" required class="w-full" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Publishing</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" :value="__('Account Status')" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive (Ban)</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('is_active')" />
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    {{ __('Create User') }}
                                </x-admin.primary-button>
                                <a href="{{ route('admin.users.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin.app-layout>