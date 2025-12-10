<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Store') }}: {{ $store->name }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Stores' => route('admin.stores.index'),
                        'Edit' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.stores.update', $store->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <h3 class="font-bold text-gray-700">Store Identity</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-admin.input-label for="name" :value="__('Store Name')" />
                                    <x-admin.text-input name="name" :value="old('name', $store->name)" required class="font-semibold text-lg" />
                                    <x-admin.input-error :messages="$errors->get('name')" />
                                </div>
                                
                                <div>
                                    <x-admin.input-label for="type" :value="__('Store Type')" />
                                    <select name="type" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm bg-gray-50">
                                        <option value="retail" {{ old('type', $store->type) == 'retail' ? 'selected' : '' }}>Retail / Reseller</option>
                                        <option value="distributor" {{ old('type', $store->type) == 'distributor' ? 'selected' : '' }}>Official Distributor</option>
                                        <option value="service_center" {{ old('type', $store->type) == 'service_center' ? 'selected' : '' }}>Service Center</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('type')" />
                                </div>

                                <div>
                                    <x-admin.input-label for="phone" :value="__('Phone / WhatsApp')" />
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        </div>
                                        <x-admin.text-input name="phone" :value="old('phone', $store->phone)" class="pl-10" />
                                    </div>
                                    <x-admin.input-error :messages="$errors->get('phone')" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <h3 class="font-bold text-gray-700">Location Address</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-admin.input-label for="address" :value="__('Full Address')" />
                                    <textarea name="address" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">{{ old('address', $store->address) }}</textarea>
                                    <x-admin.input-error :messages="$errors->get('address')" />
                                </div>
                                
                                <div>
                                    <x-admin.input-label for="city" :value="__('City')" />
                                    <x-admin.text-input name="city" :value="old('city', $store->city)" required />
                                    <x-admin.input-error :messages="$errors->get('city')" />
                                </div>
                                
                                <div>
                                    <x-admin.input-label for="postal_code" :value="__('Postal Code (Optional)')" />
                                    <x-admin.text-input name="postal_code" :value="old('postal_code', $store->postal_code)" />
                                </div>

                                <div>
                                    <x-admin.input-label for="province" :value="__('Province (Optional)')" />
                                    <x-admin.text-input name="province" :value="old('province', $store->province)" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                <h3 class="font-bold text-gray-700">Map Coordinates</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="gmaps_link" :value="__('Google Maps Link')" />
                                    <x-admin.text-input name="gmaps_link" :value="old('gmaps_link', $store->gmaps_link)" placeholder="https://goo.gl/maps/..." class="text-sm" />
                                    <x-admin.input-error :messages="$errors->get('gmaps_link')" />
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <x-admin.input-label for="latitude" :value="__('Latitude')" />
                                        <x-admin.text-input name="latitude" :value="old('latitude', $store->latitude)" placeholder="-6.200000" />
                                    </div>
                                    <div>
                                        <x-admin.input-label for="longitude" :value="__('Longitude')" />
                                        <x-admin.text-input name="longitude" :value="old('longitude', $store->longitude)" placeholder="106.816666" />
                                    </div>
                                </div>

                                <div class="bg-blue-50 p-3 rounded-lg flex gap-3 text-xs text-blue-800 border border-blue-100">
                                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p>
                                        Right-click on Google Maps to copy Lat/Long coordinates.
                                        <a href="https://maps.google.com" target="_blank" class="underline font-bold hover:text-blue-600 ml-1">Open Maps →</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Publishing</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" :value="__('Status')" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1" {{ old('is_active', $store->is_active) == true ? 'selected' : '' }}>Active (Visible)</option>
                                        <option value="0" {{ old('is_active', $store->is_active) == false ? 'selected' : '' }}>Inactive (Hidden)</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('is_active')" />
                                </div>

                                <div>
                                    <x-admin.input-label for="order" :value="__('Sort Order')" />
                                    <x-admin.text-input type="number" name="order" :value="old('order', $store->order)" />
                                    <x-admin.input-error :messages="$errors->get('order')" />
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    {{ __('Update Store') }}
                                </x-admin.primary-button>
                                <a href="{{ route('admin.stores.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</x-admin.app-layout>