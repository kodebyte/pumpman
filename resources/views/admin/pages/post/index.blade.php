<x-admin.app-layout pageTitle="Posts & Articles">
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Posts & Articles
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Posts' => '#'
                    ]" />
                </div>
            </div>

            <a href="{{ route('admin.posts.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center">
                <x-admin.svg.plus />
                Add Post
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}"><input type="hidden" name="direction" value="{{ request('direction') }}">
                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-3 block w-full rounded-lg border-gray-300 shadow-sm text-sm" placeholder="Search title...">
                        </div>
                        <div class="w-full md:w-40">
                            <select name="post_type_id" class="block w-full rounded-lg border-gray-300 shadow-sm text-sm" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}" {{ request('post_type_id') == $type->id ? 'selected' : '' }}>
                                        {{ $type->getTranslation('name') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>

                         @if(request()->hasAny(['search', 'post_type_id', 'sort']))
                            <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Thumbnail</th>
                                <x-admin.th-sortable name="title" label="Title" />
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                                <x-admin.th-sortable name="created_at" label="Published" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($posts as $post)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" class="h-10 w-16 object-cover rounded border">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900 line-clamp-1">{{ $post->getTranslation('title') }}</div>
                                        <div class="text-xs text-gray-500">By: {{ $post->author->name ?? 'System' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 capitalize">
                                            {{ $post->type ? $post->type->getTranslation('name') : 'Uncategorized' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $post->published_at ? $post->published_at->format('d M Y') : 'Draft' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-admin.status-badge :active="$post->is_active" true-text="Published" />
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.posts.edit', $post->id)" />
                                            <x-admin.btn-delete :action="route('admin.posts.destroy', $post->id)" :item="$post->getTranslation('title')" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="6" message="No posts found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($posts->hasPages() || $posts->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex-1 flex justify-start">
                            {{ $posts->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</x-admin.app-layout>