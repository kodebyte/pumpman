<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit FAQ') }}: {{ $faq->getTranslation('title') }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'FAQs' => route('admin.faqs.index'), 
                        'Edit' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="{ 
        type: '{{ $faq->parent_id ? 'question' : 'category' }}', 
        lang: 'en' 
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.faqs.update', $faq->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 border-b pb-4">
                                
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    <h3 class="font-bold text-gray-700">FAQ Content</h3>
                                </div>

                                <div class="flex items-center gap-3">
                                    
                                    <div class="hidden sm:block px-3 py-1 rounded-md bg-indigo-50 text-indigo-700 font-bold text-xs border border-indigo-200 uppercase tracking-wider">
                                        <span x-text="type"></span> Mode
                                    </div>

                                    <div class="flex bg-gray-100 p-1 rounded-lg">
                                        <button type="button" @click="lang = 'en'" :class="lang === 'en' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-xs font-bold rounded transition-all duration-200">🇺🇸 EN</button>
                                        <button type="button" @click="lang = 'id'" :class="lang === 'id' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-xs font-bold rounded transition-all duration-200">🇮🇩 ID</button>
                                    </div>
                                </div>
                                
                                <input type="hidden" name="type" x-model="type"> 
                            </div>

                            <div class="space-y-4">
                                
                                <div x-show="type === 'question'" x-transition>
                                    <x-admin.input-label for="parent_id" :value="__('Assign to Category')" />
                                    <select name="parent_id" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ old('parent_id', $faq->parent_id) == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->getTranslation('title') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('parent_id')" />
                                </div>

                                <div class="relative min-h-[120px]">

                                    <div x-show="lang === 'en'"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-1"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         class="space-y-4">
                                         
                                        <div>
                                            <x-admin.input-label>
                                                <span x-text="type === 'category' ? 'Category Name (EN)' : 'Question (EN)'"></span>
                                            </x-admin.input-label>
                                            <x-admin.text-input name="title[en]" :value="old('title.en', $faq->title['en'] ?? '')" required class="w-full text-lg font-semibold" />
                                            <x-admin.input-error :messages="$errors->get('title.en')" />
                                        </div>

                                        <div x-show="type === 'question'">
                                            <x-admin.input-label :value="__('Answer (EN)')" />
                                            <textarea name="answer[en]" rows="5" class="block w-full border-gray-300 rounded-lg shadow-sm mt-1 text-sm focus:ring-indigo-500">{{ old('answer.en', $faq->answer['en'] ?? '') }}</textarea>
                                            <x-admin.input-error :messages="$errors->get('answer.en')" />
                                        </div>
                                    </div>

                                    <div x-show="lang === 'id'"
                                         x-transition:enter="transition ease-out duration-300"
                                         x-transition:enter-start="opacity-0 translate-y-1"
                                         x-transition:enter-end="opacity-100 translate-y-0"
                                         style="display: none;"
                                         class="space-y-4">
                                         
                                        <div>
                                            <x-admin.input-label>
                                                <span x-text="type === 'category' ? 'Nama Kategori (ID)' : 'Pertanyaan (ID)'"></span>
                                            </x-admin.input-label>
                                            <x-admin.text-input name="title[id]" :value="old('title.id', $faq->title['id'] ?? '')" class="w-full text-lg font-semibold" />
                                            <x-admin.input-error :messages="$errors->get('title.id')" />
                                        </div>

                                        <div x-show="type === 'question'">
                                            <x-admin.input-label :value="__('Jawaban (ID)')" />
                                            <textarea name="answer[id]" rows="5" class="block w-full border-gray-300 rounded-lg shadow-sm mt-1 text-sm focus:ring-indigo-500">{{ old('answer.id', $faq->answer['id'] ?? '') }}</textarea>
                                            <x-admin.input-error :messages="$errors->get('answer.id')" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Publishing</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" :value="__('Status')" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1" {{ old('is_active', $faq->is_active) == true ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $faq->is_active) == false ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('is_active')" />
                                </div>

                                <div>
                                    <x-admin.input-label for="order" :value="__('Sort Order')" />
                                    <x-admin.text-input type="number" name="order" :value="old('order', $faq->order)" class="w-full text-sm" />
                                    <p class="text-xs text-gray-500 mt-1">Lower number appears first.</p>
                                    <x-admin.input-error :messages="$errors->get('order')" />
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    {{ __('Update FAQ') }}
                                </x-admin.primary-button>
                                <a href="{{ route('admin.faqs.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-admin.app-layout>