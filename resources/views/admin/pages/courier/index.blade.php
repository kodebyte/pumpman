<x-admin.app-layout pageTitle="Couriers">

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Couriers
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Couriers' => '#'
                    ]" />
                </div>
            </div>
            
            <a href="{{ route('admin.couriers.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center">
                <x-admin.svg.plus />
                Add Courier
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                {{-- SEARCH & FILTER --}}
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.couriers.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">

                        {{-- Search Input --}}
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                   placeholder="Search by courier name or code...">
                        </div>

                        {{-- Filter Status --}}
                        <div class="w-full md:w-40">
                            <select name="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>

                        @if(request()->hasAny(['search', 'is_active', 'sort']))
                            <a href="{{ route('admin.couriers.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                {{-- TABLE LIST --}}
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Logo</th>
                                <x-admin.th-sortable name="name" label="Courier Name" />
                                <x-admin.th-sortable name="code" label="Service Code" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($couriers as $courier)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- Gunakan komponen Avatar atau img biasa --}}
                                        @if($courier->logo)
                                            <div class="h-10 w-10 rounded-lg border border-gray-200 bg-white p-1">
                                                <img src="{{ Storage::url($courier->logo) }}" class="w-full h-full object-contain" alt="{{ $courier->name }}">
                                            </div>
                                        @else
                                            <div class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                                <i data-lucide="truck" class="w-5 h-5"></i>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $courier->name }}</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                                            {{ $courier->code }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-admin.status-badge :active="$courier->is_active" true-text="Active" false-text="Inactive" />
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.couriers.edit', $courier->id)" />
                                            <x-admin.btn-delete :action="route('admin.couriers.destroy', $courier->id)" :item="$courier->name" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="5" message="No couriers found. Add one to start shipping!" />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($couriers->hasPages() || $couriers->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex-1 flex justify-start">
                            {{ $couriers->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</x-admin.app-layout>