<x-admin.app-layout pageTitle="Edit SEO">
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit SEO: {{ $setting->page }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'SEO Settings' => route('admin.seo.index'),
                        'Edit' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="seoEditor({
        en: { 
            title: '{{ old('meta_title.en', $setting->getTranslation('meta_title', 'en')) }}', 
            desc: '{{ old('meta_description.en', $setting->getTranslation('meta_description', 'en')) }}' 
        },
        id: { 
            title: '{{ old('meta_title.id', $setting->getTranslation('meta_title', 'id')) }}', 
            desc: '{{ old('meta_description.id', $setting->getTranslation('meta_description', 'id')) }}' 
        }
    })">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.seo.update', $setting->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        
                        {{-- Language Switcher & Fields --}}
                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                            <div class="flex justify-between items-center mb-6 border-b pb-4">
                                <h3 class="font-bold text-gray-700 flex items-center gap-2">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Meta Configuration
                                </h3>
                                <div class="flex bg-gray-100 p-1 rounded-lg">
                                    <button type="button" @click="lang = 'en'" :class="lang === 'en' ? 'bg-white shadow text-gray-900' : 'text-gray-500'" class="px-4 py-2 text-xs font-bold rounded-md transition-all duration-300">EN</button>
                                    <button type="button" @click="lang = 'id'" :class="lang === 'id' ? 'bg-white shadow text-gray-900' : 'text-gray-500'" class="px-4 py-2 text-xs font-bold rounded-md transition-all duration-300">ID</button>
                                </div>
                            </div>

                            <div class="space-y-5 relative min-h-[300px]">
                                {{-- Tab EN --}}
                                <div x-show="lang === 'en'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                                    <div class="space-y-4">
                                        <div>
                                            <x-admin.input-label value="Meta Title (EN)" />
                                            <x-admin.text-input name="meta_title[en]" x-model="form.en.title" class="w-full" required />
                                        </div>
                                        <div>
                                            <x-admin.input-label value="Meta Description (EN)" />
                                            <textarea name="meta_description[en]" x-model="form.en.desc" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 text-sm mt-1"></textarea>
                                        </div>
                                        <div>
                                            <x-admin.input-label value="Meta Keywords (EN)" />
                                            <x-admin.text-input name="meta_keywords[en]" value="{{ old('meta_keywords.en', $setting->getTranslation('meta_keywords', 'en')) }}" class="w-full" placeholder="e.g. ac, aiwa, cooling" />
                                        </div>
                                    </div>
                                </div>

                                {{-- Tab ID --}}
                                <div x-show="lang === 'id'" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                                    <div class="space-y-4">
                                        <div>
                                            <x-admin.input-label value="Meta Title (ID)" />
                                            <x-admin.text-input name="meta_title[id]" x-model="form.id.title" class="w-full" />
                                        </div>
                                        <div>
                                            <x-admin.input-label value="Meta Description (ID)" />
                                            <textarea name="meta_description[id]" x-model="form.id.desc" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 text-sm mt-1"></textarea>
                                        </div>
                                        <div>
                                            <x-admin.input-label value="Meta Keywords (ID)" />
                                            <x-admin.text-input name="meta_keywords[id]" value="{{ old('meta_keywords.id', $setting->getTranslation('meta_keywords', 'id')) }}" class="w-full" placeholder="misal: ac, aiwa, hemat energi" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Google Preview Component --}}
                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                            <p class="text-xs font-bold text-gray-500 uppercase mb-4 border-b pb-2">Google Search Preview</p>
                            <div class="font-sans max-w-[600px]">
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-7 h-7 bg-gray-100 rounded-full border flex items-center justify-center text-xs font-bold text-gray-500">{{ substr(config('app.name'), 0, 1) }}</div>
                                    <div class="flex flex-col">
                                        <span class="text-sm text-[#202124]">{{ config('app.name') }}</span>
                                        <span class="text-xs text-[#202124]">{{ config('app.url') }} › {{ $setting->page_route }}</span>
                                    </div>
                                </div>
                                <h3 class="text-[20px] text-[#1a0dab] font-normal leading-snug hover:underline truncate mb-1" 
                                    x-text="form[lang].title || 'Page Title Placeholder'"></h3>
                                <div class="text-sm text-[#4d5156] leading-relaxed line-clamp-2">
                                    <span class="text-gray-400 text-xs mr-1">{{ now()->format('M d, Y') }}</span> — 
                                    <span x-text="form[lang].desc || 'Please enter a meta description to see how it looks in search results...'"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Actions</h3>
                            <x-admin.primary-button class="w-full justify-center">Update SEO</x-admin.primary-button>
                            <a href="{{ route('admin.seo.index') }}" class="block mt-4 text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            
                            <div class="mt-8 pt-6 border-t border-gray-100">
                                <x-admin.input-label value="OG Image (Social Share)" />
                                
                                <div class="mt-2 border-2 border-dashed border-gray-200 rounded-xl p-2 h-40 flex items-center justify-center overflow-hidden cursor-pointer hover:bg-gray-50 transition" 
                                     onclick="document.getElementById('og_image').click()">
                                    
                                    <template x-if="imgPreview">
                                        <img :src="imgPreview" class="w-full h-full object-cover rounded-lg">
                                    </template>

                                    <template x-if="!imgPreview">
                                        @if($setting->og_image)
                                            <img src="{{ asset('storage/'.$setting->og_image) }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <div class="text-center text-gray-400">
                                                <svg class="mx-auto h-8 w-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <span class="text-[10px]">Click to Upload</span>
                                            </div>
                                        @endif
                                    </template>
                                </div>

                                <input type="file" id="og_image" name="og_image" class="hidden" accept="image/*" @change="previewImage">
                                <p class="text-[10px] text-gray-400 mt-2 italic">Recommended: 1200x630px</p>
                                <x-admin.input-error :messages="$errors->get('og_image')" class="mt-1" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('seoEditor', (initialForm) => ({
                    lang: 'en',
                    form: initialForm,
                    imgPreview: null, // Properti untuk menampung base64 preview

                    // Fungsi untuk memproses file yang dipilih
                    previewImage(event) {
                        const file = event.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = (e) => { 
                                this.imgPreview = e.target.result; 
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                }));
            });
        </script>
    @endpush

</x-admin.app-layout>