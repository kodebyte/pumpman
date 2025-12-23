<x-admin.app-layout pageTitle="Categories">
    
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Categories
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Categories' => '#'
                    ]" />
                </div>
            </div>
           
            <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center">
                <x-admin.svg.plus />
                Add Category
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.categories.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">

                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                   placeholder="Search category name...">
                        </div>

                        <div class="w-full md:w-40">
                            <select name="is_featured" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Featured</option>
                                <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Standard</option>
                            </select>
                        </div>

                        <div class="w-full md:w-40">
                            <select name="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>

                        @if(request()->hasAny(['search', 'is_featured', 'is_active', 'sort']))
                            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Image</th>
                                
                                <x-admin.th-sortable name="name" label="Category Name" />
                                <x-admin.th-sortable name="is_featured" label="Featured" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Slug</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-admin.avatar :name="$category->getTranslation('name')" :photo="$category->image" class="h-10 w-10 rounded-lg" />
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">
                                            {{ $category->getTranslation('name') }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($category->is_featured)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                <svg class="w-3 h-3 mr-1 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                                Featured
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">Standard</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-admin.status-badge :active="$category->is_active" true-text="Visible" false-text="Hidden" />
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                        {{ $category->slug }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.categories.edit', $category->id)" />
                                            <x-admin.btn-delete :action="route('admin.categories.destroy', $category->id)" :item="$category->getTranslation('name')" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="6" message="No categories found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($categories->hasPages() || $categories->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex-1 flex justify-start">
                            {{ $categories->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</x-admin.app-layout>