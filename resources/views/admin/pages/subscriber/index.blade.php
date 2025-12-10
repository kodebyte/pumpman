<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Newsletter Subscribers') }}</h2>
                <div class="mt-2"><x-admin.breadcrumb :links="['Subscribers' => '#']" /></div>
            </div>
            <a href="{{ route('admin.newsletter-subscribers.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Subscriber
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.newsletter-subscribers.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-3 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" placeholder="Search email...">
                        </div>
                        <div class="w-full md:w-40">
                            <select name="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Subscribed</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Unsubscribed</option>
                            </select>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-gray-100 text-gray-800 border border-gray-300 rounded-lg text-xs uppercase font-bold hover:bg-gray-200 transition">Search</button>

                        @if(request()->hasAny(['search', 'is_active', 'sort']))
                            <a href="{{ route('admin.newsletter-subscribers.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50 flex items-center justify-center">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email Address</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Joined Date</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($subscribers as $sub)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $sub->email }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($sub->is_active)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Subscribed</span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Unsubscribed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $sub->created_at->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.newsletter-subscribers.edit', $sub->id)" />
                                            <x-admin.btn-delete :action="route('admin.newsletter-subscribers.destroy', $sub->id)" :item="$sub->email" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="4" message="No subscribers found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($subscribers->hasPages())
                <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex-1 flex justify-start">{{ $subscribers->appends(request()->all())->links() }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.app-layout>