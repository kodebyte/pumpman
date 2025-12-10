<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Store Locator') }}</h2>
                <div class="mt-2"><x-admin.breadcrumb :links="['Stores' => '#']" /></div>
            </div>
            <a href="{{ route('admin.stores.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Add Store
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.stores.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">

                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-3 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" placeholder="Search store name or city...">
                        </div>
                        
                        <div class="w-full md:w-40">
                            <select name="type" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <option value="retail" {{ request('type') == 'retail' ? 'selected' : '' }}>Retail</option>
                                <option value="distributor" {{ request('type') == 'distributor' ? 'selected' : '' }}>Distributor</option>
                                <option value="service_center" {{ request('type') == 'service_center' ? 'selected' : '' }}>Service Center</option>
                            </select>
                        </div>

                        <div class="w-full md:w-40">
                            <select name="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs uppercase font-bold hover:bg-gray-200">Search</button>
                        
                        @if(request()->hasAny(['search', 'type', 'is_active', 'sort']))
                            <a href="{{ route('admin.stores.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50 flex items-center justify-center">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <x-admin.th-sortable name="name" label="Store Name" />
                                <x-admin.th-sortable name="city" label="Location" />
                                <x-admin.th-sortable name="type" label="Type" />
                                <x-admin.th-sortable name="order" label="Order" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($stores as $store)
                                <tr class="hover:bg-gray-50 transition">
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $store->name }}</div>
                                        <div class="text-xs text-gray-500 flex items-center mt-1">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                            {{ $store->phone ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 font-medium">{{ $store->city }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs" title="{{ $store->address }}">
                                            {{ Str::limit($store->address, 40) }}
                                        </div>
                                        @if($store->gmaps_link)
                                            <a href="{{ $store->gmaps_link }}" target="_blank" class="text-[10px] text-blue-600 hover:underline flex items-center mt-1">
                                                View Map &rarr;
                                            </a>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badges = [
                                                'retail' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                'distributor' => 'bg-purple-100 text-purple-800 border-purple-200',
                                                'service_center' => 'bg-orange-100 text-orange-800 border-orange-200',
                                            ];
                                            $labels = [
                                                'retail' => 'Retail',
                                                'distributor' => 'Distributor',
                                                'service_center' => 'Service Center',
                                            ];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $badges[$store->type] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $labels[$store->type] ?? ucfirst($store->type) }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                        {{ $store->order }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-admin.status-badge :active="$store->is_active" />
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.stores.edit', $store->id)" />
                                            <x-admin.btn-delete :action="route('admin.stores.destroy', $store->id)" :item="$store->name" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="6" message="No stores found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($stores->hasPages() || $stores->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex-1 flex justify-start">
                            {{ $stores->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.app-layout>