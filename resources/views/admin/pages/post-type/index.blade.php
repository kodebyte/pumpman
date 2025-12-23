<x-admin.app-layout pageTitle="Post Types">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Post Types
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Post Types' => '#'
                    ]" />
                </div>
            </div>

            <a href="{{ route('admin.post-types.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center">
                <x-admin.svg.plus />
                Add Post Type
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.post-types.index') }}" class="flex gap-4">
                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-3 block w-full rounded-lg border-gray-300 shadow-sm text-sm" placeholder="Search type...">
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>

                         @if(request()->hasAny(['search', 'category_id', 'is_active', 'sort']))
                            <a href="{{ route('admin.post-types.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <x-admin.th-sortable name="slug" label="Slug" />
                                <x-admin.th-sortable name="name" label="Name" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($types as $type)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-indigo-600">
                                        {{ $type->slug }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $type->getTranslation('name', 'en') }}</div>
                                        <div class="text-xs text-gray-500">{{ $type->getTranslation('name', 'id') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-admin.status-badge :active="$type->is_active" true-text="Active" />
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.post-types.edit', $type->id)" />
                                            <x-admin.btn-delete :action="route('admin.post-types.destroy', $type->id)" :item="$type->slug" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="4" message="No post types found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($types->hasPages() || $types->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                        <div class="flex-1 flex justify-start">
                            {{ $types->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</x-admin.app-layout>