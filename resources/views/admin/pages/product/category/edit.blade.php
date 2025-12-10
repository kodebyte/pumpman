<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Edit Category') }}: {{ $category->getTranslation('name') }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Categories' => route('admin.categories.index'),
                        'Edit' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="{ 
        lang: 'en', 
        imgPreview: null,
        // TANGKAP NILAI IS_FEATURED DARI DATABASE
        featured: {{ old('is_featured', $category->is_featured) ? '1' : '0' }},
        
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
            
            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <h3 class="font-bold text-gray-700">Category Image</h3>
                            </div>
                            
                            <div>
                                <x-admin.input-label for="image" :value="__('Thumbnail / Icon')" />
                                
                                <div class="mt-2 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-xl p-4 hover:bg-gray-50 transition h-64 flex flex-col items-center justify-center overflow-hidden" onclick="document.getElementById('image').click()">
                                    
                                    <template x-if="imgPreview">
                                        <img :src="imgPreview" class="w-full h-full object-contain">
                                    </template>

                                    <template x-if="!imgPreview">
                                        @if($category->image)
                                            <img src="{{ asset('storage/' . $category->image) }}" class="w-full h-full object-contain">
                                        @else
                                            <div class="text-center text-gray-400 flex flex-col items-center">
                                                <svg class="mx-auto h-12 w-12 mb-2 text-gray-300" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                                <span class="text-sm font-medium text-gray-600">Upload Image</span>
                                            </div>
                                        @endif
                                    </template>
                                    
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                                        <span class="text-white font-bold bg-black/50 px-3 py-1 rounded-full text-sm">Change Image</span>
                                    </div>

                                    <input id="image" type="file" name="image" class="hidden" accept="image/*" @change="previewImage">
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Leave blank to keep current image.</p>
                                <x-admin.input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            
                            <div class="flex items-center justify-between mb-6 border-b pb-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                    <h3 class="font-bold text-gray-700">Category Name</h3>
                                </div>
                                
                                <div class="flex bg-gray-100 p-1 rounded-lg">
                                    <button type="button" @click="lang = 'en'" :class="lang === 'en' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-xs font-bold rounded-md transition-all duration-200">🇺🇸 EN</button>
                                    <button type="button" @click="lang = 'id'" :class="lang === 'id' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-xs font-bold rounded-md transition-all duration-200">🇮🇩 ID</button>
                                </div>
                            </div>

                            <div class="space-y-4 min-h-[80px]">
                                <div x-show="lang === 'en'"
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0">
                                    
                                    <x-admin.input-label for="name_en" :value="__('Name (English)')" />
                                    <x-admin.text-input name="name[en]" :value="old('name.en', $category->name['en'] ?? '')" class="w-full text-lg font-semibold" required />
                                    <x-admin.input-error :messages="$errors->get('name.en')" class="mt-1" />
                                </div>

                                <div x-show="lang === 'id'" 
                                     x-transition:enter="transition ease-out duration-300"
                                     x-transition:enter-start="opacity-0 translate-y-1"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     style="display: none;">
                                     
                                    <x-admin.input-label for="name_id" :value="__('Nama (Indonesia)')" />
                                    <x-admin.text-input name="name[id]" :value="old('name.id', $category->name['id'] ?? '')" class="w-full text-lg font-semibold" />
                                    <x-admin.input-error :messages="$errors->get('name.id')" class="mt-1" />
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Publishing</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" :value="__('Visibility')" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1" {{ old('is_active', $category->is_active) == true ? 'selected' : '' }}>Visible (Active)</option>
                                        <option value="0" {{ old('is_active', $category->is_active) == false ? 'selected' : '' }}>Hidden (Draft)</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('is_active')" />
                                </div>

                                <div>
                                    <x-admin.input-label for="is_featured" :value="__('Featured?')" />
                                    <select name="is_featured" 
                                            class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm"
                                            @change="featured = $event.target.value">
                                        <option value="0" {{ old('is_featured', $category->is_featured) == false ? 'selected' : '' }}>Standard</option>
                                        <option value="1" {{ old('is_featured', $category->is_featured) == true ? 'selected' : '' }}>Featured (Highlight)</option>
                                    </select>
                                    <p class="text-xs text-gray-500 mt-1">Featured categories appear on the homepage.</p>
                                    <x-admin.input-error :messages="$errors->get('is_featured')" />
                                </div>
                                
                                <div x-show="featured == 1" x-transition>
                                    <x-admin.input-label for="order" :value="__('Order')" />
                                    <x-admin.text-input type="number" name="order" :value="old('order', $category->order)" 
                                        placeholder="e.g. 1 (First)" class="w-full text-sm" min="1" />
                                    <p class="text-xs text-gray-500 mt-1">Gunakan angka yang lebih kecil untuk prioritas lebih tinggi (misalnya: 1 adalah yang pertama).</p>
                                    <x-admin.input-error :messages="$errors->get('order')" class="mt-1" />
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    {{ __('Update Category') }}
                                </x-admin.primary-button>
                                <a href="{{ route('admin.categories.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</x-admin.app-layout>