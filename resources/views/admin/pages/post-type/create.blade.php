<x-admin.app-layout pageTitle="Add Post Type">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Add Post Type
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Post Types' => route('admin.post-types.index'),
                        'Create' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="{ lang: 'en' }">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.post-types.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center justify-between mb-6 border-b border-gray-100 pb-4">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                    <h3 class="font-bold text-gray-700">Type Name</h3>
                                </div>
                                
                                <div class="flex bg-gray-100 p-1 rounded-lg">
                                    <button type="button" @click="lang = 'en'" 
                                        :class="lang === 'en' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" 
                                        class="px-3 py-1 text-xs font-bold rounded-md transition-all duration-200">
                                        EN
                                    </button>
                                    <button type="button" @click="lang = 'id'" 
                                        :class="lang === 'id' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" 
                                        class="px-3 py-1 text-xs font-bold rounded-md transition-all duration-200">
                                        ID
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-4 min-h-[80px]">
                                <div x-show="lang === 'en'"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0">
                                    
                                    <x-admin.input-label for="name_en" value="Name" />
                                    <x-admin.text-input name="name[en]" :value="old('name.en')" class="w-full text-lg font-semibold mt-1" required />
                                    <x-admin.input-error :messages="$errors->get('name.en')" class="mt-1" />
                                </div>

                                <div x-show="lang === 'id'" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     style="display: none;">
                                     
                                    <x-admin.input-label for="name_id" value="Nama" />
                                    <x-admin.text-input name="name[id]" :value="old('name.id')" class="w-full text-lg font-semibold mt-1" />
                                    <x-admin.input-error :messages="$errors->get('name.id')" class="mt-1" />
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <h3 class="font-bold text-gray-700">Configuration</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="slug" value="Slug (Unique Key)" />
                                    <x-admin.text-input name="slug" :value="old('slug')" class="w-full mt-1 bg-gray-50 font-mono text-sm" required />
                                    <p class="text-xs text-gray-400 mt-1">Used for system logic. No spaces.</p>
                                    <x-admin.input-error :messages="$errors->get('slug')" class="mt-1" />
                                </div>

                                <div>
                                    <x-admin.input-label for="is_active" value="Status" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700 w-full">
                                    Save Type
                                </x-admin.primary-button>
                                <a href="{{ route('admin.post-types.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-admin.app-layout>