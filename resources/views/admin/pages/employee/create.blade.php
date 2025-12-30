<x-admin.app-layout pageTitle="Add Employee">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Add Employee
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Employees' => route('admin.employees.index'),
                        'Create' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.employees.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- LEFT COLUMN: DATA UTAMA --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                {{-- Icon: User --}}
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Account Information</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="name" value="Full Name" />
                                    <x-admin.text-input name="name" :value="old('name')" class="w-full" placeholder="e.g. John Doe" required autofocus />
                                    <x-admin.input-error :messages="$errors->get('name')" class="mt-1" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-admin.input-label for="email" value="Email Address" />
                                        <x-admin.text-input type="email" name="email" :value="old('email')" class="w-full" placeholder="employee@company.com" required />
                                        <x-admin.input-error :messages="$errors->get('email')" class="mt-1" />
                                    </div>

                                    <div>
                                        <x-admin.input-label for="role" value="Role" />
                                        <select name="role" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                            <option value="" disabled selected>-- Select Role --</option>
                                            {{-- Sesuaikan value dengan Enum/Database Anda --}}
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                                            <option value="editor" {{ old('role') == 'editor' ? 'selected' : '' }}>Content Editor</option>
                                            <option value="sales" {{ old('role') == 'sales' ? 'selected' : '' }}>Sales Staff</option>
                                            <option value="cs" {{ old('role') == 'cs' ? 'selected' : '' }}>Customer Service</option>
                                        </select>
                                        <x-admin.input-error :messages="$errors->get('role')" class="mt-1" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                {{-- Icon: Lock --}}
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Security</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-admin.input-label for="password" value="Password" />
                                    <x-admin.text-input type="password" name="password" class="w-full" required autocomplete="new-password" />
                                    <x-admin.input-error :messages="$errors->get('password')" class="mt-1" />
                                </div>

                                <div>
                                    <x-admin.input-label for="password_confirmation" value="Confirm Password" />
                                    <x-admin.text-input type="password" name="password_confirmation" class="w-full" required />
                                    <x-admin.input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: STATUS --}}
                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                {{-- Icon: Settings --}}
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Settings</h3>
                            </div>
                            
                            {{-- Field Status (Aktif/Nonaktif) --}}
                            <div>
                                <x-admin.input-label for="is_active" value="Status" />
                                <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                    <option value="1" {{ old('is_active', 1) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-admin.input-error :messages="$errors->get('is_active')" class="mt-1" />
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700 w-full">
                                    Create Account
                                </x-admin.primary-button>
                                <a href="{{ route('admin.employees.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-admin.app-layout>