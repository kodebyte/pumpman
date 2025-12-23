<x-admin.app-layout pageTitle="Edit Banner">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Banner
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Banners' => route('admin.banners.index'),
                        'Edit' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="{ 
        lang: 'en',
        bgType: '{{ $banner->background_type }}',
        imgPreviewDesktop: null,
        imgPreviewMobile: null,
        
        previewImage(event, type) {
            const file = event.target.files[0];
            if(file) {
                const reader = new FileReader();
                reader.onload = (e) => { 
                    if(type === 'desktop') this.imgPreviewDesktop = e.target.result;
                    if(type === 'mobile') this.imgPreviewMobile = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        },

        getSeoTitle() {
            if(this.lang === 'en') return document.getElementsByName('title[en]')[0]?.value || '{{ $banner->title['en'] ?? 'Banner Title' }}';
            return document.getElementsByName('title[id]')[0]?.value || '{{ $banner->title['id'] ?? 'Judul Banner' }}';
        },
        getSeoDesc() {
            if(this.lang === 'en') return document.getElementsByName('subtitle[en]')[0]?.value || '{{ $banner->subtitle['en'] ?? 'Banner description...' }}';
            return document.getElementsByName('subtitle[id]')[0]?.value || '{{ $banner->subtitle['id'] ?? 'Deskripsi banner...' }}';
        }
    }">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <h3 class="font-bold text-gray-700">Visual Media</h3>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <x-admin.input-label for="background_type" :value="__('Background Type')" />
                                    <select name="background_type" x-model="bgType" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm bg-gray-50">
                                        <option value="image">Static Image</option>
                                        <option value="video">Video Loop</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('background_type')" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <x-admin.input-label for="image_desktop" value="Desktop Image (1920x600)" />
                                        <div class="mt-2 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-2 hover:bg-gray-50 transition h-40 flex items-center justify-center overflow-hidden" onclick="document.getElementById('image_desktop').click()">
                                            
                                            <template x-if="imgPreviewDesktop">
                                                <img :src="imgPreviewDesktop" class="w-full h-full object-cover rounded">
                                            </template>

                                            <template x-if="!imgPreviewDesktop">
                                                @if($banner->image_desktop)
                                                    <img src="{{ asset('storage/' . $banner->image_desktop) }}" class="w-full h-full object-cover rounded">
                                                @else
                                                    <div class="text-center text-gray-400"><span class="text-xs">Upload Desktop</span></div>
                                                @endif
                                            </template>
                                            
                                            <input id="image_desktop" type="file" name="image_desktop" class="hidden" accept="image/*" @change="previewImage($event, 'desktop')">
                                        </div>
                                        <p x-show="bgType == 'video'" class="text-xs text-amber-600 mt-1">Used as video poster.</p>
                                        <x-admin.input-error :messages="$errors->get('image_desktop')" />
                                    </div>

                                    <div>
                                        <x-admin.input-label for="image_mobile" value="Mobile Image (600x600)" />
                                        <div class="mt-2 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-2 hover:bg-gray-50 transition h-40 flex items-center justify-center overflow-hidden" onclick="document.getElementById('image_mobile').click()">
                                            
                                            <template x-if="imgPreviewMobile">
                                                <img :src="imgPreviewMobile" class="w-full h-full object-cover rounded">
                                            </template>

                                            <template x-if="!imgPreviewMobile">
                                                @if($banner->image_mobile)
                                                    <img src="{{ asset('storage/' . $banner->image_mobile) }}" class="w-full h-full object-cover rounded">
                                                @else
                                                    <div class="text-center text-gray-400"><span class="text-xs">Upload Mobile</span></div>
                                                @endif
                                            </template>

                                            <input id="image_mobile" type="file" name="image_mobile" class="hidden" accept="image/*" @change="previewImage($event, 'mobile')">
                                        </div>
                                        <x-admin.input-error :messages="$errors->get('image_mobile')" />
                                    </div>
                                </div>
                                
                                <div x-show="bgType === 'video'" x-transition class="pt-4 border-t border-gray-100">
                                    <x-admin.input-label for="video" value="Change Video (.mp4, Max 2MB)" />
                                    @if($banner->video_path)
                                        <p class="text-xs text-green-600 mb-2 font-bold">✓ Video currently uploaded.</p>
                                    @endif
                                    <input type="file" name="video" accept="video/mp4,video/webm" class="block w-full text-sm border border-gray-300 rounded-lg p-2 bg-gray-50 mt-1">
                                    <x-admin.input-error :messages="$errors->get('video')" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center justify-between mb-6 border-b pb-2">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2h-1m-1-4l-4-4a1 1 0 00-1.414 0l-4 4a1 1 0 001.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414z"></path></svg>
                                    <h3 class="font-bold text-gray-700">Text Content</h3>
                                </div>
                                <div class="flex bg-gray-100 p-1 rounded-lg">
                                    <button type="button" @click="lang = 'en'" :class="lang === 'en' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-xs font-bold rounded-md transition-all duration-200">
                                        EN
                                    </button>
                                    <button type="button" @click="lang = 'id'" :class="lang === 'id' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700'" class="px-3 py-1 text-xs font-bold rounded-md transition-all duration-200">
                                        ID
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-5 min-h-[300px]">
                                <div x-show="lang === 'en'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                    <div class="space-y-5">
                                        <div>
                                            <x-admin.input-label value="Tagline" />
                                            <x-admin.text-input name="tagline[en]" :value="old('tagline.en', $banner->tagline['en'] ?? '')" class="w-full text-sm" />
                                        </div>
                                        <div>
                                            <x-admin.input-label value="Title" />
                                            <x-admin.text-input name="title[en]" :value="old('title.en', $banner->title['en'] ?? '')" class="w-full text-lg font-bold" x-on:input="$refresh" />
                                        </div>
                                        <div>
                                            <x-admin.input-label value="Subtitle" />
                                            <textarea name="subtitle[en]" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm" rows="3" x-on:input="$refresh">{{ old('subtitle.en', $banner->subtitle['en'] ?? '') }}</textarea>
                                        </div>
                                        <div>
                                            <x-admin.input-label value="Button Text" />
                                            <x-admin.text-input name="cta_text[en]" :value="old('cta_text.en', $banner->cta_text['en'] ?? '')" class="w-full" />
                                        </div>
                                    </div>
                                </div>

                                <div x-show="lang === 'id'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                                    <div class="space-y-5">
                                        <div>
                                            <x-admin.input-label value="Tagline" />
                                            <x-admin.text-input name="tagline[id]" :value="old('tagline.id', $banner->tagline['id'] ?? '')" class="w-full text-sm" />
                                        </div>
                                        <div>
                                            <x-admin.input-label value="Judul" />
                                            <x-admin.text-input name="title[id]" :value="old('title.id', $banner->title['id'] ?? '')" class="w-full text-lg font-bold" x-on:input="$refresh" />
                                        </div>
                                        <div>
                                            <x-admin.input-label value="Deskripsi" />
                                            <textarea name="subtitle[id]" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm" rows="3" x-on:input="$refresh">{{ old('subtitle.id', $banner->subtitle['id'] ?? '') }}</textarea>
                                        </div>
                                        <div>
                                            <x-admin.input-label value="Teks Tombol" />
                                            <x-admin.text-input name="cta_text[id]" :value="old('cta_text.id', $banner->cta_text['id'] ?? '')" class="w-full" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <p class="text-xs font-bold text-gray-500 uppercase mb-2">Banner Text Preview</p>
                                <div class="text-center p-6 bg-gray-900 rounded-xl text-white shadow-inner">
                                    <h2 class="text-2xl font-bold tracking-tight" x-text="getSeoTitle()"></h2>
                                    <p class="text-sm mt-2 opacity-80 leading-relaxed" x-text="getSeoDesc()"></p>
                                    <div class="mt-4 inline-block px-4 py-2 bg-white text-gray-900 rounded text-xs font-bold uppercase tracking-wider">Button</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Publishing</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" value="Status" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1" {{ old('is_active', $banner->is_active) == true ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $banner->is_active) == false ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div>
                                    <x-admin.input-label for="order" value="Sort Order" />
                                    <x-admin.text-input type="number" name="order" :value="old('order', $banner->order)" class="w-full" />
                                </div>
                                <div>
                                    <x-admin.input-label for="start_date" value="Start Date" />
                                    <input type="datetime-local" name="start_date" value="{{ $banner->start_date ? $banner->start_date->format('Y-m-d\TH:i') : '' }}" class="block w-full border-gray-300 rounded-lg shadow-sm mt-1 text-sm">
                                </div>
                                <div>
                                    <x-admin.input-label for="end_date" value="End Date" />
                                    <input type="datetime-local" name="end_date" value="{{ $banner->end_date ? $banner->end_date->format('Y-m-d\TH:i') : '' }}" class="block w-full border-gray-300 rounded-lg shadow-sm mt-1 text-sm">
                                </div>
                            </div>
                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    Update Banner
                                </x-admin.primary-button>
                                <a href="{{ route('admin.banners.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Target Link</h3>
                            <div>
                                <x-admin.input-label for="target_url" :value="__('Target URL')" />
                                <x-admin.text-input name="target_url" :value="old('target_url', $banner->target_url)" required class="w-full text-sm" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-admin.app-layout>