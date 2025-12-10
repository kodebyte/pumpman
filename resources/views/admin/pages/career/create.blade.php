<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Post New Job') }}</h2>
                <div class="mt-2"><x-admin.breadcrumb :links="['Careers' => route('admin.careers.index'), 'Create' => '#']" /></div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="{ lang: 'en' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.careers.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between sticky top-4 z-20">
                            <h3 class="font-bold text-gray-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Job Description
                            </h3>
                            <div class="flex bg-gray-100 p-1 rounded-lg">
                                <button type="button" @click="lang = 'en'" :class="lang === 'en' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-xs font-bold rounded-md transition-all duration-200">🇺🇸 EN</button>
                                <button type="button" @click="lang = 'id'" :class="lang === 'id' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-xs font-bold rounded-md transition-all duration-200">🇮🇩 ID</button>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm min-h-[500px]">
                            
                            <div x-show="lang === 'en'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                <div class="space-y-5">
                                    <div>
                                        <x-admin.input-label :value="__('Job Title (EN)')" />
                                        <x-admin.text-input name="title[en]" :value="old('title.en')" placeholder="e.g. Sales Executive" class="text-lg font-semibold w-full" required />
                                        <x-admin.input-error :messages="$errors->get('title.en')" />
                                    </div>
                                    <div>
                                        <x-admin.input-label :value="__('Requirements & Description (EN)')" />
                                        <div wire:ignore class="mt-1">
                                            <textarea id="description_en" name="description[en]" rows="10">{{ old('description.en') }}</textarea>
                                        </div>
                                        <x-admin.input-error :messages="$errors->get('description.en')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div x-show="lang === 'id'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                                <div class="space-y-5">
                                    <div>
                                        <x-admin.input-label :value="__('Posisi (ID)')" />
                                        <x-admin.text-input name="title[id]" :value="old('title.id')" placeholder="cth. Eksekutif Penjualan" class="text-lg font-semibold w-full" />
                                        <x-admin.input-error :messages="$errors->get('title.id')" />
                                    </div>
                                    <div>
                                        <x-admin.input-label :value="__('Kualifikasi & Deskripsi (ID)')" />
                                        <div wire:ignore class="mt-1">
                                            <textarea id="description_id" name="description[id]" rows="10">{{ old('description.id') }}</textarea>
                                        </div>
                                        <x-admin.input-error :messages="$errors->get('description.id')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Status</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" :value="__('Visibility')" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1">Open (Visible)</option>
                                        <option value="0">Closed (Hidden)</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('is_active')" />
                                </div>
                                <div>
                                    <x-admin.input-label for="closing_date" :value="__('Closing Date')" />
                                    <input type="date" name="closing_date" value="{{ old('closing_date') }}" class="block w-full border-gray-300 rounded-lg shadow-sm mt-1 text-sm">
                                    <p class="text-xs text-gray-500 mt-1">Automatically closes after this date.</p>
                                </div>
                                <div>
                                    <x-admin.input-label for="order" :value="__('Sort Order')" />
                                    <x-admin.text-input type="number" name="order" value="0" class="w-full" />
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">{{ __('Publish Job') }}</x-admin.primary-button>
                                <a href="{{ route('admin.careers.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Job Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="location" :value="__('Location')" />
                                    <x-admin.text-input name="location" :value="old('location')" placeholder="e.g. Jakarta, Remote" required class="w-full text-sm" />
                                    <x-admin.input-error :messages="$errors->get('location')" />
                                </div>
                                <div>
                                    <x-admin.input-label for="type" :value="__('Employment Type')" />
                                    <select name="type" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="Full-time">Full-time</option>
                                        <option value="Part-time">Part-time</option>
                                        <option value="Contract">Contract</option>
                                        <option value="Internship">Internship</option>
                                    </select>
                                </div>
                                <div>
                                    <x-admin.input-label for="salary_range" :value="__('Salary Range (Optional)')" />
                                    <x-admin.text-input name="salary_range" :value="old('salary_range')" placeholder="e.g. Negotiable / 5jt - 8jt" class="w-full text-sm" />
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @include('admin.plugins.ckeditor')
</x-admin.app-layout>