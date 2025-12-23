<x-admin.app-layout pageTitle="Add Marketplace">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Add Marketplace
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Marketplaces' => route('admin.marketplaces.index'),
                        'Create' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="{ 
        imgPreview: null,
        
        previewImage(event) {
            const file = event.target.files[0];
            if(file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.imgPreview = e.target.result; }
                reader.readAsDataURL(file);
            }
        }
    }">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.marketplaces.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                <h3 class="font-bold text-gray-700">Marketplace Details & Icon</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="md:col-span-3">
                                    <x-admin.input-label for="name" value="Platform Name" />
                                    <x-admin.text-input name="name" :value="old('name')" required autofocus class="w-full text-lg font-semibold" />
                                    <x-admin.input-error :messages="$errors->get('name')" />
                                </div>
                                
                                <div class="md:col-span-3">
                                    <x-admin.input-label for="icon" value="Logo / Icon" />
                                    
                                    <div class="mt-2 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-2 hover:bg-gray-50 transition h-40 flex flex-col items-center justify-center overflow-hidden" onclick="document.getElementById('icon').click()">
                                        <template x-if="!imgPreview">
                                            <div class="text-center text-gray-400">
                                                <svg class="mx-auto h-10 w-10 mb-1" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                                <span class="text-xs">Click to upload icon</span>
                                            </div>
                                        </template>
                                        <template x-if="imgPreview">
                                            <img :src="imgPreview" class="w-20 h-20 object-contain rounded">
                                        </template>
                                        <input id="icon" type="file" name="icon" class="hidden" accept="image/*" @change="previewImage">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Recommended: Square icon (e.g., 100x100px).</p>
                                    <x-admin.input-error :messages="$errors->get('icon')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Control</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" value="Visibility" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1">Visible</option>
                                        <option value="0">Hidden</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('is_active')" />
                                </div>

                                <div>
                                    <x-admin.input-label for="order" value="Sort Order" />
                                    <x-admin.text-input type="number" name="order" :value="old('order', 0)" class="w-full text-sm" />
                                    <p class="text-xs text-gray-500 mt-1">Lower number = higher priority.</p>
                                    <x-admin.input-error :messages="$errors->get('order')" />
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    Save Marketplace
                                </x-admin.primary-button>
                                <a href="{{ route('admin.marketplaces.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-admin.app-layout>