<x-admin.app-layout pageTitle="Message Details">

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Message Details
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Inbox' => route('admin.contacts.index'),
                        'Details' => '#'
                    ]" />
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.contacts.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Inbox
                </a>
                
                <x-admin.btn-delete :action="route('admin.contacts.destroy', $message->id)" :item="'message from ' . $message->name" />
            </div>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Bagian Isi Pesan --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-8">
                        <div class="flex items-center gap-3 mb-6 border-b pb-4">
                            <div class="p-2 bg-indigo-50 text-indigo-600 rounded-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Topic') }}</p>
                                <h3 class="text-xl font-bold text-gray-900">{{ $message->topic }}</h3>
                            </div>
                        </div>

                        <div class="prose prose-indigo max-w-none">
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4">{{ __('Message Body') }}</p>
                            <div class="bg-gray-50 rounded-xl p-6 text-gray-700 leading-relaxed whitespace-pre-wrap border border-gray-100">{{ $message->message }}</div>
                        </div>
                    </div>
                </div>

                {{-- Bagian Metadata / Pengirim --}}
                <div class="space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                        <h3 class="font-bold text-gray-700 mb-6 border-b pb-2">{{ __('Sender Information') }}</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <x-admin.avatar :name="$message->name" class="h-12 w-12 rounded-full shadow-sm" />
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Full Name') }}</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $message->name }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 rounded-full border border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Email Address') }}</p>
                                    <a href="mailto:{{ $message->email }}" class="text-sm font-bold text-indigo-600 hover:underline">{{ $message->email }}</a>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 rounded-full border border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Received On') }}</p>
                                    <p class="text-sm font-bold text-gray-900">{{ $message->created_at->format('d M Y, H:i') }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $message->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 flex items-center justify-center bg-gray-50 text-gray-400 rounded-full border border-gray-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">{{ __('Current Status') }}</p>
                                    <x-admin.status-badge :active="$message->is_read" true-text="Read" false-text="Unread" />
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->topic }}" 
                               class="w-full inline-flex items-center justify-center px-4 py-3 bg-gray-800 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 shadow-lg shadow-indigo-100 transition duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Reply via Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-admin.app-layout>