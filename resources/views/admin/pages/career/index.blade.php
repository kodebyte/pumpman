<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Careers') }}</h2>
                <div class="mt-2"><x-admin.breadcrumb :links="['Careers' => '#']" /></div>
            </div>
            <a href="{{ route('admin.careers.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Post Job
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.careers.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">

                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-3 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" placeholder="Search job title or location...">
                        </div>
                        
                        <div class="w-full md:w-40">
                            <select name="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs uppercase font-bold hover:bg-gray-200">Search</button>
                        
                        @if(request()->hasAny(['search', 'is_active', 'sort']))
                            <a href="{{ route('admin.careers.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50 flex items-center justify-center">Reset</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <x-admin.th-sortable name="title" label="Job Title" />
                                <x-admin.th-sortable name="location" label="Location & Type" />
                                <x-admin.th-sortable name="closing_date" label="Closing Date" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($careers as $career)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $career->getTranslation('title') }}</div>
                                        <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                            <span>{{ $career->salary_range ?? 'Salary Hidden' }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-1">
                                            <span class="text-sm text-gray-700 flex items-center gap-1">
                                                <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                                {{ $career->location }}
                                            </span>
                                            <span class="text-xs font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded w-fit">
                                                {{ $career->type }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $career->closing_date ? $career->closing_date->format('d M Y') : 'Open Forever' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($career->is_open)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                                <span class="w-1.5 h-1.5 mr-1.5 bg-emerald-500 rounded-full"></span> Open
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                                <span class="w-1.5 h-1.5 mr-1.5 bg-slate-400 rounded-full"></span> Closed
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.careers.edit', $career->id)" />
                                            <x-admin.btn-delete :action="route('admin.careers.destroy', $career->id)" :item="$career->getTranslation('title')" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="5" message="No job postings found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($careers->hasPages() || $careers->count() > 0)
                <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex-1 flex justify-start">{{ $careers->appends(request()->all())->links() }}</div>
                    <x-admin.limit-selector :per-page="$perPage" />
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.app-layout>