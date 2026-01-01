<x-admin.app-layout pageTitle="Payment Methods">
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Payment Methods
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Payment Methods' => '#'
                    ]" />
                </div>
            </div>
            <a href="{{ route('admin.payment-methods.create') }}" class="px-4 py-2 bg-gray-800 rounded-md text-xs text-white uppercase hover:bg-gray-700 transition flex items-center">
                <x-admin.svg.plus /> Add Method
            </a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.payment-methods.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Search payment method...">
                        </div>

                        <div class="w-full md:w-40">
                            <select name="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs font-semibold uppercase hover:bg-gray-200">Search</button>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Logo</th>
                                <x-admin.th-sortable name="name" label="Name" />
                                <x-admin.th-sortable name="order" label="Sort Order" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($paymentMethods as $payment)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="h-10 w-16 bg-gray-50 border rounded flex items-center justify-center p-1">
                                            <img src="{{ $payment->image_url }}" alt="{{ $payment->name }}" class="h-full w-full object-contain">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-bold text-gray-900">{{ $payment->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $payment->order }}</td>
                                    <td class="px-6 py-4">
                                        <x-admin.status-badge :active="$payment->is_active" />
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.payment-methods.edit', $payment->id)" />
                                            <x-admin.btn-delete :action="route('admin.payment-methods.destroy', $payment->id)" :item="$payment->name" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="5" message="No payment methods found." />
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($paymentMethods->hasPages())
                    <div class="bg-white px-6 py-4 border-t border-gray-200">
                        {{ $paymentMethods->appends(request()->all())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-admin.app-layout>