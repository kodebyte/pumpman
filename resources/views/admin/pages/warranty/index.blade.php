<x-admin.app-layout pageTitle="Warranty Claims">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Warranty Claims
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Claims' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.warranty-claims.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-3 block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" placeholder="Search Claim ID, Customer, Serial No...">
                        </div>
                        <div class="w-full md:w-40">
                            <select name="status" class="block w-full rounded-lg border-gray-300 shadow-sm sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>

                        @if(request()->hasAny(['search', 'status', 'sort']))
                            <a href="{{ route('admin.warranty-claims.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Claim Info</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Product Info</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($claims as $claim)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $claim->claim_code }}</div>
                                        <div class="text-xs text-gray-500">{{ $claim->customer_name }}</div>
                                        <div class="text-xs text-gray-400">{{ $claim->customer_phone }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $claim->product->name ?? 'Unknown Product' }}</div>
                                        <div class="text-xs text-gray-500">SN: {{ $claim->serial_number ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $claim->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badges = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-blue-100 text-blue-800',
                                                'unit_received' => 'bg-indigo-100 text-indigo-800',
                                                'repairing' => 'bg-purple-100 text-purple-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                            ];
                                            $badgeClass = $badges[$claim->status] ?? 'bg-gray-100 text-gray-800';
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $claim->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.warranty-claims.show', $claim->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 px-3 py-1 rounded-md text-xs font-bold border border-indigo-200">
                                                View Details
                                            </a>
                                            <x-admin.btn-delete :action="route('admin.warranty-claims.destroy', $claim->id)" :item="$claim->claim_code" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="5" message="No warranty claims found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($claims->hasPages() || $claims->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex-1 flex justify-start">
                            {{ $claims->appends(request()->all())->links() }}
                        </div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
    
</x-admin.app-layout>