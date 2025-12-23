<x-admin.app-layout pageTitle="Contact Messages">

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Contact Messages
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Inbox' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                {{-- Filter & Search Bar --}}
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.contacts.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">

                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" 
                                   placeholder="Search by name, email, or topic...">
                        </div>

                        <div class="w-full md:w-48">
                            <select name="is_read" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="0" {{ request('is_read') === '0' ? 'selected' : '' }}>Unread (New)</option>
                                <option value="1" {{ request('is_read') === '1' ? 'selected' : '' }}>Read</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>

                        @if(request()->hasAny(['search', 'is_read']))
                            <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Sender</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Topic</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Received At</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($messages as $msg)
                                <tr class="hover:bg-gray-50 transition-colors duration-200 {{ !$msg->is_read ? 'bg-indigo-50/30' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{-- Menggunakan x-admin.avatar untuk konsistensi --}}
                                            <x-admin.avatar :name="$msg->name" class="h-10 w-10 rounded-full" />
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900">{{ $msg->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $msg->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                        {{ $msg->topic }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                        {{ $msg->created_at->format('d M Y, H:i') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{-- Menggunakan x-admin.status-badge: Active = Read, Inactive = Unread --}}
                                        <x-admin.status-badge :active="$msg->is_read" true-text="Read" false-text="Unread" />
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.contacts.show', $msg->id) }}" class="p-2 text-gray-500 hover:text-indigo-600 bg-gray-50 hover:bg-indigo-50 rounded-lg transition" title="View Details">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="5" message="No messages found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination & Limit Selector --}}
                @if($messages->hasPages() || $messages->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex-1 flex justify-start">
                            {{ $messages->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</x-admin.app-layout>