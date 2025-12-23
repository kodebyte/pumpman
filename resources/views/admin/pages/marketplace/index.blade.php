<x-admin.app-layout pageTitle="Marketplaces">

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Marketplaces
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Marketplaces' => '#'
                    ]" />
                </div>
            </div>

            <a href="{{ route('admin.marketplaces.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center">
                <x-admin.svg.plus />
                Add Marketplace
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.marketplaces.index') }}" class="flex gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">
                        
                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-3 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" placeholder="Search marketplace...">
                        </div>
                        
                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>
                        
                        @if(request()->hasAny(['search', 'sort']))
                            <a href="{{ route('admin.marketplaces.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <x-admin.th-sortable name="name" label="Identity" />
                                <x-admin.th-sortable name="order" label="Order" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($marketplaces as $marketplace)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <img src="{{ asset('storage/' . $marketplace->icon) }}" class="h-8 w-8 rounded object-contain border bg-gray-50">
                                            <span class="ml-3 text-sm font-bold text-gray-900">{{ $marketplace->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono">
                                        {{ $marketplace->order }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-admin.status-badge :active="$marketplace->is_active" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.marketplaces.edit', $marketplace->id)" />
                                            <x-admin.btn-delete :action="route('admin.marketplaces.destroy', $marketplace->id)" :item="$marketplace->name" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="4" message="No marketplaces found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($marketplaces->hasPages() || $marketplaces->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                        <div class="flex-1 flex justify-start">
                            {{ $marketplaces->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-admin.app-layout>