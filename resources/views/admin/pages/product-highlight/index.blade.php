<x-admin.app-layout pageTitle="Product Highlight Settings">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Product Highlight Settings
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Highlight' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="highlightForm()">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />
            
            <form action="{{ route('admin.product-highlights.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex gap-4 mb-6 border-b">
                                <button type="button" @click="tab = 'en'" :class="tab === 'en' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500'" class="pb-2 px-1 border-b-2 font-bold text-sm transition">EN</button>
                                <button type="button" @click="tab = 'id'" :class="tab === 'id' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500'" class="pb-2 px-1 border-b-2 font-bold text-sm transition">ID</button>
                            </div>

                            <div class="space-y-4">
                                <div x-show="tab === 'en'" class="space-y-4">
                                    <div>
                                        <x-admin.input-label value="Tagline" />
                                        <x-admin.text-input name="tagline[en]" :value="$highlight->getTranslation('tagline', 'en')" class="w-full" />
                                    </div>
                                    <div>
                                        <x-admin.input-label value="Title" />
                                        <x-admin.text-input name="title[en]" :value="$highlight->getTranslation('title', 'en')" class="w-full" />
                                    </div>
                                    <div>
                                        <x-admin.input-label value="Description" />
                                        <textarea name="description[en]" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">{{ $highlight->getTranslation('description', 'en') }}</textarea>
                                    </div>
                                </div>

                                <div x-show="tab === 'id'" class="space-y-4">
                                    <div>
                                        <x-admin.input-label value="Tagline" />
                                        <x-admin.text-input name="tagline[id]" :value="$highlight->getTranslation('tagline', 'id')" class="w-full" />
                                    </div>
                                    <div>
                                        <x-admin.input-label value="Judul" />
                                        <x-admin.text-input name="title[id]" :value="$highlight->getTranslation('title', 'id')" class="w-full" />
                                    </div>
                                    <div>
                                        <x-admin.input-label value="Deskripsi" />
                                        <textarea name="description[id]" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">{{ $highlight->getTranslation('description', 'id') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex justify-between items-center mb-4 border-b pb-2">
                                <h3 class="font-bold text-gray-700">Product Features (JSON)</h3>
                                <button type="button" @click="addFeature()" class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-lg text-xs font-bold hover:bg-indigo-100 transition">+ Add Feature</button>
                            </div>

                            <div class="space-y-4">
                                <template x-for="(f, index) in features" :key="index">
                                    <div class="p-4 border border-gray-100 rounded-xl bg-gray-50/50 relative">
                                        <button type="button" @click="removeFeature(index)" class="absolute top-2 right-2 text-gray-400 hover:text-red-500 transition">&times;</button>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Icon (Lucide)</label>
                                                <input type="text" :name="`features[${index}][icon]`" x-model="f.icon" class="w-full text-xs border-gray-300 rounded-lg shadow-sm">
                                            </div>
                                            <div class="grid grid-cols-2 gap-2">
                                                <div>
                                                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Title (ID)</label>
                                                    <input type="text" :name="`features[${index}][title][id]`" x-model="f.title.id" class="w-full text-xs border-gray-300 rounded-lg shadow-sm">
                                                </div>
                                                <div>
                                                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Title (EN)</label>
                                                    <input type="text" :name="`features[${index}][title][en]`" x-model="f.title.en" class="w-full text-xs border-gray-300 rounded-lg shadow-sm">
                                                </div>
                                            </div>
                                            <div class="md:col-span-2 grid grid-cols-2 gap-2">
                                                <div>
                                                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Desc (ID)</label>
                                                    <input type="text" :name="`features[${index}][desc][id]`" x-model="f.desc.id" class="w-full text-xs border-gray-300 rounded-lg shadow-sm">
                                                </div>
                                                <div>
                                                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Desc (EN)</label>
                                                    <input type="text" :name="`features[${index}][desc][en]`" x-model="f.desc.en" class="w-full text-xs border-gray-300 rounded-lg shadow-sm">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Actions</h3>
                            <x-admin.primary-button class="w-full justify-center bg-gray-800 hover:bg-gray-700 mb-6">
                                Save Changes
                            </x-admin.primary-button>

                            <x-admin.input-label value="Hero Image" />
                            <div class="mt-2 border-2 border-dashed border-gray-200 rounded-xl p-2 h-48 flex items-center justify-center overflow-hidden">
                                @if($highlight->image)
                                    <img src="{{ asset('storage/'.$highlight->image) }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <span class="text-xs text-gray-400">No Image Uploaded</span>
                                @endif
                            </div>
                            <input type="file" name="image" class="mt-4 text-xs block w-full text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <script>
        function highlightForm() {
            return {
                tab: 'en',
                features: @json($highlight->features ?? []),
                addFeature() {
                    this.features.push({
                        icon: 'star',
                        title: { id: '', en: '' },
                        desc: { id: '', en: '' }
                    });
                },
                removeFeature(index) {
                    this.features.splice(index, 1);
                }
            }
        }
    </script>
    
</x-admin.app-layout>