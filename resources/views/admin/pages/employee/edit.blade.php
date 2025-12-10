<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Employee') }}: {{ $employee->name }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Employees' => route('admin.employees.index'),
                        'Edit' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                                <h3 class="font-bold text-gray-700">Employee Details</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <x-admin.input-label for="name" :value="__('Full Name')" />
                                    <x-admin.text-input name="name" :value="old('name', $employee->name)" required class="w-full text-lg font-semibold" />
                                    <x-admin.input-error :messages="$errors->get('name')" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-admin.input-label for="email" :value="__('Email Address')" />
                                        <x-admin.text-input type="email" name="email" :value="old('email', $employee->email)" required class="w-full" />
                                        <x-admin.input-error :messages="$errors->get('email')" />
                                    </div>
                                    <div>
                                        <x-admin.input-label for="employee_role_id" :value="__('Role')" />
                                        <select name="employee_role_id" id="employee_role_id" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('employee_role_id', $employee->employee_role_id) == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <x-admin.input-error :messages="$errors->get('employee_role_id')" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <h3 class="font-bold text-gray-700">Change Password</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-admin.input-label for="password" :value="__('New Password')" />
                                    <x-admin.text-input id="password" type="password" name="password" class="w-full" autocomplete="new-password" />
                                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password.</p>
                                    <x-admin.input-error :messages="$errors->get('password')" />
                                </div>

                                <div>
                                    <x-admin.input-label for="password_confirmation" :value="__('Confirm New Password')" />
                                    <x-admin.text-input id="password_confirmation" type="password" name="password_confirmation" class="w-full" />
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Account Status</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" :value="__('Status')" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1" {{ old('is_active', $employee->is_active) == true ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $employee->is_active) == false ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('is_active')" />
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    {{ __('Update Employee') }}
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