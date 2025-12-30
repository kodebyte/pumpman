<x-admin.app-layout pageTitle="WhatsApp Contacts">
    
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    WhatsApp Contacts
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'WhatsApp' => '#'
                    ]" />
                </div>
            </div>
           
            <a href="{{ route('admin.whatsapp.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center">
                <x-admin.svg.plus />
                Add Contact
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                {{-- FILTER SECTION --}}
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.whatsapp.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">

                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                   placeholder="Search title or phone...">
                        </div>

                        <div class="w-full md:w-40">
                            <select name="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>

                        @if(request()->hasAny(['search', 'is_active', 'sort']))
                            <a href="{{ route('admin.whatsapp.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                {{-- TABLE SECTION --}}
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <x-admin.th-sortable name="title" label="Contact Info" />
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Phone & Message</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Style</th>
                                <x-admin.th-sortable name="order" label="Order" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($contacts as $contact)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $contact->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $contact->subtitle ?? '-' }}</div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="text-sm font-mono text-gray-700">{{ $contact->phone }}</div>
                                        <div class="text-xs text-gray-400 truncate max-w-xs" title="{{ $contact->message }}">
                                            {{ Str::limit($contact->message, 30) }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-2 px-2.5 py-1 rounded-md text-xs font-medium bg-gray-50 text-gray-700 border border-gray-200">
                                            <span class="w-3 h-3 rounded-full block" style="background-color: {{ $contact->color }};"></span>
                                            <span>{{ ucfirst($contact->color) }}</span>
                                            <span class="text-gray-300">|</span>
                                            <span>{{ $contact->icon }}</span>
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $contact->order }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <x-admin.status-badge :active="$contact->is_active" />
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.whatsapp.edit', $contact->id)" />
                                            <x-admin.btn-delete :action="route('admin.whatsapp.destroy', $contact->id)" :item="$contact->title" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="6" message="No contacts found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($contacts->hasPages())
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex-1 flex justify-start">
                            {{ $contacts->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$contacts->perPage()" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</x-admin.app-layout>