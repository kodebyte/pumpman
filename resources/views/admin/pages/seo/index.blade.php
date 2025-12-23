<x-admin.app-layout>
    <x-slot name="header" pageTitle="SEO Configuration">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    SEO Configuration
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'SEO Settings' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                {{-- Search Bar --}}
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.seo.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">

                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                   placeholder="Search by page name or route...">
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>

                        @if(request()->has('search'))
                            <a href="{{ route('admin.seo.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Page Name</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Route Key</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Title (EN)</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($settings as $item)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->page }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-[10px] font-mono lowercase">
                                            {{ $item->page_route }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $item->getTranslation('meta_title', 'en') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.seo.edit', $item->id)" label="Config SEO" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="4" message="No SEO settings found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($settings->hasPages() || $settings->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex-1 flex justify-start">
                            {{ $settings->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</x-admin.app-layout>