<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('FAQs') }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'FAQs' => '#'
                    ]" />
                </div>
            </div>
            
            <a href="{{ route('admin.faqs.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none transition ease-in-out duration-150 gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add New
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.faqs.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">

                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="pl-3 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" 
                                   placeholder="Search questions or categories (ID/EN)...">
                        </div>
                        
                        {{-- <div class="w-full md:w-40">
                            <select name="type" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <option value="category" {{ request('type') == 'category' ? 'selected' : '' }}>Categories Only</option>
                                <option value="question" {{ request('type') == 'question' ? 'selected' : '' }}>Questions Only</option>
                            </select>
                        </div> --}}

                        <div class="w-full md:w-40">
                            <select name="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-800 border border-gray-300 rounded-lg text-xs uppercase font-bold hover:bg-gray-200 transition">Search</button>
                        
                        @if(request()->hasAny(['search', 'type', 'is_active', 'sort']))
                            <a href="{{ route('admin.faqs.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50 flex items-center justify-center">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <x-admin.th-sortable name="title" label="Content (Title/Question)" />
                                
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Parent Category</th>
                                
                                <x-admin.th-sortable name="order" label="Order" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($faqs as $faq)
                                <tr class="hover:bg-gray-50 transition {{ !$faq->parent_id ? 'bg-indigo-50/30' : '' }}">
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-start">
                                            @if(!$faq->parent_id)
                                                <div class="flex items-center">
                                                    <span class="mr-3 p-1.5 bg-indigo-100 text-indigo-600 rounded-md">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                                                    </span>
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900">{{ $faq->getTranslation('title') }}</div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="flex items-start ml-4 border-l-2 border-gray-200 pl-4">
                                                    <div>
                                                        <div class="text-sm font-medium text-gray-900">{{ $faq->getTranslation('title') }}</div>
                                                        <div class="text-xs text-gray-500 line-clamp-1 mt-0.5">
                                                            {{ Str::limit($faq->getTranslation('answer'), 60) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(!$faq->parent_id)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-indigo-600 text-white">
                                                CATEGORY
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-white text-gray-600 border border-gray-200">
                                                QUESTION
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($faq->parent)
                                            <span class="font-medium text-indigo-600">{{ $faq->parent->getTranslation('title') }}</span>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                        {{ $faq->order }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-admin.status-badge :active="$faq->is_active" />
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.faqs.edit', $faq->id)" />
                                            <x-admin.btn-delete 
                                                :action="route('admin.faqs.destroy', $faq->id)" 
                                                :item="$faq->getTranslation('title')" 
                                                confirm-text="Deleting a Category will also delete ALL questions inside it. Are you sure?"
                                            />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="6" message="No FAQs or Categories found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($faqs->hasPages() || $faqs->count() > 0)
                <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex-1 flex justify-start">
                        {{ $faqs->appends(request()->all())->links() }}
                    </div>
                    <x-admin.limit-selector :per-page="$perPage" />
                </div>
                @endif

            </div>
        </div>
    </div>
</x-admin.app-layout>