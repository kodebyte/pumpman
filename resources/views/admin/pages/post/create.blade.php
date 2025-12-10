<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Write New Post') }}</h2>
                <div class="mt-2"><x-admin.breadcrumb :links="['Posts' => route('admin.posts.index'), 'Create' => '#']" /></div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="{ 
        lang: 'en',
        imgPreview: null,
        
        // Data Binding untuk Live Preview
        form: {
            en: { title: '{{ old('title.en') }}', meta_title: '{{ old('meta_title.en') }}', meta_desc: '{{ old('meta_description.en') }}' },
            id: { title: '{{ old('title.id') }}', meta_title: '{{ old('meta_title.id') }}', meta_desc: '{{ old('meta_description.id') }}' }
        },

        previewImage(event) {
            const file = event.target.files[0];
            if(file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.imgPreview = e.target.result; }
                reader.readAsDataURL(file);
            }
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between sticky top-4 z-20">
                            <h3 class="font-bold text-gray-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                Content Editor
                            </h3>
                            <div class="flex bg-gray-100 p-1 rounded-lg">
                                <button type="button" @click="lang = 'en'" :class="lang === 'en' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-xs font-bold rounded-md transition-all duration-200">🇺🇸 English</button>
                                <button type="button" @click="lang = 'id'" :class="lang === 'id' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-xs font-bold rounded-md transition-all duration-200">🇮🇩 Indonesia</button>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm min-h-[500px]">
                            
                            <div x-show="lang === 'en'" x-transition>
                                <div class="space-y-5">
                                    <div>
                                        <x-admin.input-label :value="__('Article Title (EN)')" />
                                        <x-admin.text-input name="title[en]" x-model="form.en.title" placeholder="Enter title here..." class="text-lg font-semibold w-full" required />
                                        <x-admin.input-error :messages="$errors->get('title.en')" />
                                    </div>
                                    <div>
                                        <x-admin.input-label :value="__('Content (EN)')" />
                                        <div wire:ignore class="mt-1">
                                            <textarea id="content_en" name="content[en]" rows="10">{{ old('content.en') }}</textarea>
                                        </div>
                                        <x-admin.input-error :messages="$errors->get('content.en')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div x-show="lang === 'id'" x-transition style="display: none;">
                                <div class="space-y-5">
                                    <div>
                                        <x-admin.input-label :value="__('Judul Artikel (ID)')" />
                                        <x-admin.text-input name="title[id]" x-model="form.id.title" placeholder="Masukkan judul disini..." class="text-lg font-semibold w-full" />
                                        <x-admin.input-error :messages="$errors->get('title.id')" />
                                    </div>
                                    <div>
                                        <x-admin.input-label :value="__('Konten (ID)')" />
                                        <div wire:ignore class="mt-1">
                                            <textarea id="content_id" name="content[id]" rows="10">{{ old('content.id') }}</textarea>
                                        </div>
                                        <x-admin.input-error :messages="$errors->get('content.id')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <h3 class="font-bold text-gray-700">SEO Configuration</h3>
                            </div>

                            <div x-show="lang === 'en'" x-transition>
                                <div class="space-y-4">
                                    <div>
                                        <x-admin.input-label :value="__('Meta Title (EN)')" />
                                        <x-admin.text-input name="meta_title[en]" x-model="form.en.meta_title" placeholder="Custom title..." class="w-full" />
                                        <x-admin.input-error :messages="$errors->get('meta_title.en')" />
                                    </div>
                                    <div>
                                        <x-admin.input-label :value="__('Meta Description (EN)')" />
                                        <textarea name="meta_description[en]" x-model="form.en.meta_desc" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 text-sm" placeholder="Short summary..."></textarea>
                                        <x-admin.input-error :messages="$errors->get('meta_description.en')" />
                                    </div>
                                </div>
                            </div>

                            <div x-show="lang === 'id'" x-transition style="display: none;">
                                <div class="space-y-4">
                                    <div>
                                        <x-admin.input-label :value="__('Meta Title (ID)')" />
                                        <x-admin.text-input name="meta_title[id]" x-model="form.id.meta_title" placeholder="Judul khusus..." class="w-full" />
                                        <x-admin.input-error :messages="$errors->get('meta_title.id')" />
                                    </div>
                                    <div>
                                        <x-admin.input-label :value="__('Meta Description (ID)')" />
                                        <textarea name="meta_description[id]" x-model="form.id.meta_desc" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 text-sm" placeholder="Ringkasan..."></textarea>
                                        <x-admin.input-error :messages="$errors->get('meta_description.id')" />
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 bg-white border border-gray-200 rounded-lg p-5 shadow-sm">
                                <p class="text-xs font-bold text-gray-500 uppercase mb-4 border-b pb-2">Google Search Preview</p>
                                <div class="font-sans max-w-[600px]">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-7 h-7 bg-gray-100 rounded-full border flex items-center justify-center text-xs font-bold text-gray-500">{{ substr(config('app.name'), 0, 1) }}</div>
                                        <div class="flex flex-col">
                                            <span class="text-sm text-[#202124]">{{ config('app.name') }}</span>
                                            <span class="text-xs text-[#202124]">{{ config('app.url') }} › posts</span>
                                        </div>
                                    </div>
                                    
                                    <h3 class="text-[20px] text-[#1a0dab] font-normal leading-snug hover:underline cursor-pointer truncate mb-1" 
                                        x-text="lang === 'en' 
                                            ? (form.en.meta_title || form.en.title || 'Article Title Placeholder') 
                                            : (form.id.meta_title || form.id.title || 'Judul Artikel Disini')">
                                    </h3>

                                    <div class="text-sm text-[#4d5156] leading-relaxed line-clamp-2">
                                        <span class="text-gray-400 text-xs mr-1" x-text="new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })"></span> — 
                                        <span x-text="lang === 'en' 
                                            ? (form.en.meta_desc || 'Please enter a description to see preview...') 
                                            : (form.id.meta_desc || 'Masukkan deskripsi untuk melihat preview...')">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Publishing</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" :value="__('Status')" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1">Published</option>
                                        <option value="0">Draft</option>
                                    </select>
                                </div>
                                <div>
                                    <x-admin.input-label for="published_at" :value="__('Schedule Publish')" />
                                    <input type="datetime-local" name="published_at" class="block w-full border-gray-300 rounded-lg shadow-sm mt-1 text-sm">
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">{{ __('Save & Publish') }}</x-admin.primary-button>
                                <a href="{{ route('admin.posts.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Meta Data</h3>
                            <div class="mb-4">
                                <x-admin.input-label for="type" :value="__('Post Type')" />
                                <select name="type" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                    <option value="news">News / Berita</option>
                                    <option value="article">Article / Blog</option>
                                    <option value="promo">Promo / Event</option>
                                </select>
                            </div>
                            <div>
                                <x-admin.input-label for="thumbnail" :value="__('Thumbnail Image')" />
                                <div class="mt-2 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-2 hover:bg-gray-50 transition" onclick="document.getElementById('thumbnail').click()">
                                    <div class="w-full h-40 bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
                                        <template x-if="!imgPreview">
                                            <div class="text-center text-gray-400">
                                                <svg class="mx-auto h-8 w-8" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                                <span class="text-xs">Click to upload</span>
                                            </div>
                                        </template>
                                        <template x-if="imgPreview">
                                            <img :src="imgPreview" class="w-full h-full object-cover">
                                        </template>
                                    </div>
                                    <input id="thumbnail" type="file" name="thumbnail" class="hidden" accept="image/*" @change="previewImage">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Rec: 800x600px. Max 2MB.</p>
                                <x-admin.input-error :messages="$errors->get('thumbnail')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @include('admin.plugins.ckeditor')
</x-admin.app-layout>