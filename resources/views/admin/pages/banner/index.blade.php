<x-admin.app-layout pageTitle="Hero Banners">

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Hero Banners
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Hero Banners' => '#'
                    ]" />
                </div>
            </div>
            
            <a href="{{ route('admin.banners.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center">
                <x-admin.svg.plus />
                Add Hero Banner
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.banners.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">

                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="pl-3 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" 
                                   placeholder="Search title...">
                        </div>
                        
                        <div class="w-full md:w-40">
                            <select name="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>
                        
                        @if(request()->hasAny(['search', 'is_active', 'sort']))
                            <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Preview</th>
                                
                                <x-admin.th-sortable name="title" label="Title" />
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                                <x-admin.th-sortable name="order" label="Order" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($banners as $banner)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($banner->image_desktop)
                                            <img src="{{ asset('storage/' . $banner->image_desktop) }}" class="h-12 w-20 object-cover rounded border border-gray-200">
                                        @else
                                            <span class="text-xs text-gray-400">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $banner->getTranslation('title') }}</div>
                                        <div class="text-xs text-gray-500 truncate max-w-xs">{{ $banner->target_url }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $banner->background_type == 'video' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($banner->background_type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-mono">
                                        {{ $banner->order }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-admin.status-badge :active="$banner->is_active" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.banners.edit', $banner->id)" />
                                            <x-admin.btn-delete :action="route('admin.banners.destroy', $banner->id)" :item="'Banner #' . $banner->id" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="6" message="No banners found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($banners->hasPages() || $banners->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex-1 flex justify-start">
                            {{ $banners->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</x-admin.app-layout>