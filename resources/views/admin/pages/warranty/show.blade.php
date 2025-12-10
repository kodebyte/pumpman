<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Claim Details') }} #{{ $claim->claim_code }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Warranty Claims' => route('admin.warranty-claims.index'), 
                        'Details' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b pb-4">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <h3 class="font-bold text-gray-700">Issue Details</h3>
                            </div>
                            
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                    'approved' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'unit_received' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                    'repairing' => 'bg-purple-50 text-purple-700 border-purple-200',
                                    'rejected' => 'bg-red-50 text-red-700 border-red-200',
                                    'completed' => 'bg-green-50 text-green-700 border-green-200',
                                ];
                                $color = $statusColors[$claim->status] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                            @endphp
                            <div class="px-3 py-1 rounded-md border text-xs font-bold uppercase tracking-wider {{ $color }}">
                                {{ str_replace('_', ' ', $claim->status) }}
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Product Name</p>
                                <p class="text-gray-900 font-bold text-lg">{{ $claim->product->name ?? 'Unknown Product' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Serial Number</p>
                                <p class="text-gray-900 font-mono bg-gray-100 inline-block px-2 py-0.5 rounded border border-gray-200 text-sm">
                                    {{ $claim->serial_number ?? 'N/A' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Purchase Date</p>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-gray-700 font-medium">{{ $claim->purchase_date->format('d F Y') }}</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase font-bold tracking-wider mb-1">Store Location</p>
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <p class="text-gray-700 font-medium">{{ $claim->purchase_location ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg border border-gray-100 p-4">
                            <p class="text-xs text-gray-500 uppercase font-bold mb-2 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                Problem Description
                            </p>
                            <p class="text-gray-800 text-sm leading-relaxed whitespace-pre-line">{{ $claim->description }}</p>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                        
                        <div class="flex items-center gap-2 mb-6 border-b pb-4">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <h3 class="font-bold text-gray-700">Evidence Photos</h3>
                        </div>

                        @if(!empty($claim->evidence_photos))
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($claim->evidence_photos as $photo)
                                    <a href="{{ asset('storage/' . $photo) }}" target="_blank" class="group relative aspect-square bg-gray-100 rounded-lg overflow-hidden border border-gray-200 block shadow-sm hover:shadow-md transition">
                                        <img src="{{ asset('storage/' . $photo) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-sm text-gray-500 italic">No evidence photos provided by customer.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                        <div class="flex items-center gap-2 mb-6 border-b pb-4">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <h3 class="font-bold text-gray-700">Customer</h3>
                        </div>
                        
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-sm uppercase tracking-wider">
                                {{ substr($claim->customer_name ?? 'Unknown', 0, 2) }}
                            </div>
                            
                            <div>
                                <p class="font-bold text-gray-900 text-base">{{ $claim->customer_name }}</p>
                                <p class="text-sm text-gray-500">{{ $claim->customer_phone }}</p>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-3 border border-gray-100">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Shipping Address</p>
                            <p class="text-sm text-gray-700 leading-snug">{{ $claim->shipping_address }}</p>
                        </div>
                    </div>

                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 border-t-4 sticky top-6">
                        <div class="flex items-center gap-2 mb-6 border-b pb-4">
                            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <h3 class="font-bold text-gray-700">Process Claim</h3>
                        </div>

                        <form action="{{ route('admin.warranty-claims.update', $claim->id) }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <x-admin.input-label for="status" :value="__('Update Status')" />
                                <div class="relative">
                                    <select name="status" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm pl-3 pr-10 py-2">
                                        <option value="pending" {{ $claim->status == 'pending' ? 'selected' : '' }}>Pending (Review)</option>
                                        <option value="approved" {{ $claim->status == 'approved' ? 'selected' : '' }}>Approved (Send Unit)</option>
                                        <option value="unit_received" {{ $claim->status == 'unit_received' ? 'selected' : '' }}>Unit Received</option>
                                        <option value="repairing" {{ $claim->status == 'repairing' ? 'selected' : '' }}>Repairing</option>
                                        <option value="completed" {{ $claim->status == 'completed' ? 'selected' : '' }}>Completed (Shipped Back)</option>
                                        <option value="rejected" {{ $claim->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <x-admin.input-label for="admin_notes" :value="__('Admin Notes (Internal)')" />
                                <textarea name="admin_notes" rows="4" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm placeholder-gray-400" placeholder="Catatan teknisi, alasan penolakan, atau detail perbaikan...">{{ $claim->admin_notes }}</textarea>
                            </div>
                            
                            <div x-data="{ show: '{{ $claim->status }}' === 'completed' }" x-init="$watch('$el.closest(\'form\').status.value', value => show = value === 'completed')">
                                <x-admin.input-label for="admin_tracking_number" :value="__('Return Tracking No. (Resi)')" />
                                <x-admin.text-input name="admin_tracking_number" :value="$claim->admin_tracking_number" class="w-full text-sm mt-1" placeholder="e.g. JNE-12345678" />
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    {{ __('Update status') }}
                                </x-admin.primary-button>
                                <a href="{{ route('admin.warranty-claims.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-admin.app-layout>