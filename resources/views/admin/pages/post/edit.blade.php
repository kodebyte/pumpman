<x-admin.app-layout pageTitle="Edit Post">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Post
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Posts' => route('admin.posts.index'), 
                        'Edit' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="postEditor({
        en: { 
            title: '{{ old('title.en', $post->title['en'] ?? '') }}', 
            meta_title: '{{ old('meta_title.en', $post->meta_title['en'] ?? '') }}', 
            meta_desc: '{{ old('meta_description.en', $post->meta_description['en'] ?? '') }}' 
        },
        id: { 
            title: '{{ old('title.id', $post->title['id'] ?? '') }}', 
            meta_title: '{{ old('meta_title.id', $post->meta_title['id'] ?? '') }}', 
            meta_desc: '{{ old('meta_description.id', $post->meta_description['id'] ?? '') }}' 
        }
    })">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between sticky top-4 z-20">
                            <h3 class="font-bold text-gray-700 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Content Editor
                            </h3>
                            <div class="flex bg-gray-100 p-1 rounded-lg">
                                <button type="button" @click="lang = 'en'" :class="lang === 'en' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-xs font-bold rounded-md transition-all duration-300">
                                    EN
                                </button>
                                <button type="button" @click="lang = 'id'" :class="lang === 'id' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-xs font-bold rounded-md transition-all duration-300">
                                    ID
                                </button>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-gray-100 shadow-sm min-h-[500px] overflow-hidden relative">
                            <div x-show="lang === 'en'" 
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-x-4"
                                 x-transition:enter-end="opacity-100 transform translate-x-0"
                                 class="p-6">
                                <div class="space-y-5">
                                    <div>
                                        <x-admin.input-label value="Article Title" />
                                        <x-admin.text-input name="title[en]" x-model="form.en.title" class="text-lg font-semibold w-full" required />
                                        <x-admin.input-error :messages="$errors->get('title.en')" />
                                    </div>
                                    <div>
                                        <x-admin.input-label value="Content" />
                                        <div wire:ignore class="mt-1">
                                            <textarea id="content_en" name="content[en]" rows="10">{{ old('content.en', $post->content['en'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div x-show="lang === 'id'" 
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0 transform translate-x-4"
                                 x-transition:enter-end="opacity-100 transform translate-x-0"
                                 class="p-6">
                                <div class="space-y-5">
                                    <div>
                                        <x-admin.input-label value="Judul" />
                                        <x-admin.text-input name="title[id]" x-model="form.id.title" class="text-lg font-semibold w-full" />
                                    </div>
                                    <div>
                                        <x-admin.input-label value="Konten" />
                                        <div wire:ignore class="mt-1">
                                            <textarea id="content_id" name="content[id]" rows="10">{{ old('content.id', $post->content['id'] ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <h3 class="font-bold text-gray-700">SEO Configuration</h3>
                            </div>

                            <div class="relative">
                                <div x-show="lang === 'en'" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="space-y-4">
                                    <div>
                                        <x-admin.input-label value="Meta Title" />
                                        <x-admin.text-input name="meta_title[en]" x-model="form.en.meta_title" class="w-full" />
                                    </div>
                                    <div>
                                        <x-admin.input-label value="Meta Description" />
                                        <textarea name="meta_description[en]" x-model="form.en.meta_desc" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 text-sm"></textarea>
                                    </div>
                                </div>

                                <div x-show="lang === 'id'" 
                                     x-cloak
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     class="space-y-4">
                                    <div>
                                        <x-admin.input-label value="Meta Title" />
                                        <x-admin.text-input name="meta_title[id]" x-model="form.id.meta_title" class="w-full" />
                                    </div>
                                    <div>
                                        <x-admin.input-label value="Meta Description" />
                                        <textarea name="meta_description[id]" x-model="form.id.meta_desc" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 text-sm"></textarea>
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
                                    <h3 class="text-[20px] text-[#1a0dab] font-normal leading-snug hover:underline truncate mb-1" 
                                        x-text="lang === 'en' ? (form.en.meta_title || form.en.title || 'Title') : (form.id.meta_title || form.id.title || 'Judul')"></h3>
                                    <div class="text-sm text-[#4d5156] leading-relaxed line-clamp-2">
                                        <span class="text-gray-400 text-xs mr-1">{{ $post->updated_at->format('M d, Y') }}</span> — 
                                        <span x-text="lang === 'en' ? (form.en.meta_desc || 'Description...') : (form.id.meta_desc || 'Deskripsi...')"></span>
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
                                    <x-admin.input-label for="is_active" value="Status" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1" {{ old('is_active', $post->is_active) == true ? 'selected' : '' }}>Published</option>
                                        <option value="0" {{ old('is_active', $post->is_active) == false ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>
                                <div>
                                    <x-admin.input-label for="published_at" value="Schedule" />
                                    <input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" class="block w-full border-gray-300 rounded-lg shadow-sm mt-1 text-sm">
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">Update Post</x-admin.primary-button>
                                <a href="{{ route('admin.posts.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>

                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Meta Data</h3>
                            <div class="mb-4">
                                <x-admin.input-label for="post_type_id" value="Post Type" />
                                <select name="post_type_id" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                    @foreach($types as $type)
                                        <option value="{{ $type->id }}" {{ old('post_type_id', $post->post_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->getTranslation('name') }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-admin.input-error :messages="$errors->get('post_type_id')" class="mt-1" />
                            </div>
                            <div>
                                <x-admin.input-label for="thumbnail" value="Thumbnail" />
                                <div class="mt-2 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-2 hover:bg-gray-50 transition" onclick="document.getElementById('thumbnail').click()">
                                    <div class="w-full h-40 bg-gray-100 rounded-md flex items-center justify-center overflow-hidden">
                                        <template x-if="!imgPreview">
                                            @if($post->thumbnail)
                                                <img src="{{ asset('storage/' . $post->thumbnail) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="text-center text-gray-400">
                                                    <span class="text-xs">Click to upload</span>
                                                </div>
                                            @endif
                                        </template>
                                        <template x-if="imgPreview">
                                            <img :src="imgPreview" class="w-full h-full object-cover">
                                        </template>
                                    </div>
                                    <input id="thumbnail" type="file" name="thumbnail" class="hidden" accept="image/*" @change="previewImage">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Rec: 800x600px. Max 1MB.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    @include('admin.plugins.ckeditor')

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('postEditor', (initialForm) => ({
                    lang: 'en',
                    imgPreview: null,
                    form: initialForm,

                    previewImage(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => { this.imgPreview = e.target.result; }
                            reader.readAsDataURL(file);
                        }
                    }
                }));
            });
        </script>
    @endpush

</x-admin.app-layout>