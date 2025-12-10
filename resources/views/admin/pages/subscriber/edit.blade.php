<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Subscriber') }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Subscribers' => route('admin.newsletter-subscribers.index'), 
                        'Edit' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 p-6">
                
                <div class="flex items-center gap-2 mb-6 border-b pb-4">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                    <h3 class="font-bold text-gray-700">Subscriber Details</h3>
                </div>

                <form action="{{ route('admin.newsletter-subscribers.update', $subscriber->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <x-admin.input-label for="email" :value="__('Email Address')" />
                            <x-admin.text-input type="email" name="email" id="email" :value="old('email', $subscriber->email)" required 
                                class="w-full text-lg font-semibold" />
                            <x-admin.input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-admin.input-label for="is_active" :value="__('Subscription Status')" />
                            <select name="is_active" id="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                <option value="1" {{ old('is_active', $subscriber->is_active) == true ? 'selected' : '' }}>Subscribed (Active)</option>
                                <option value="0" {{ old('is_active', $subscriber->is_active) == false ? 'selected' : '' }}>Unsubscribed (Inactive)</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Inactive users will not receive marketing emails.</p>
                            <x-admin.input-error :messages="$errors->get('is_active')" class="mt-2" />
                        </div>
                    </div>
                    
                    <div class="mt-8 flex justify-end gap-3 border-t pt-6">
                        <a href="{{ route('admin.newsletter-subscribers.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                            Cancel
                        </a>
                        <x-admin.primary-button class="bg-gray-800 hover:bg-gray-700">
                            {{ __('Update Subscriber') }}
                        </x-admin.primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin.app-layout>