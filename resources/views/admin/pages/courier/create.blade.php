<x-admin.app-layout pageTitle="Add Courier">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Add Courier
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Couriers' => route('admin.couriers.index'),
                        'Create' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Inisialisasi x-data dari Script Terpisah --}}
    <div class="pb-12" x-data="initCourierCreateForm()">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.couriers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- KOLOM KIRI: LOGO & DETAIL --}}
                    <div class="lg:col-span-2 space-y-6">
                        {{-- CARD LOGO --}}
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <i data-lucide="image" class="w-5 h-5 text-indigo-500"></i>
                                <h3 class="font-bold text-gray-700">Courier Logo</h3>
                            </div>
                            <div>
                                <x-admin.input-label for="logo" value="Thumbnail / Icon" />

                                <div class="mt-2 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-xl p-4 hover:bg-gray-50 transition h-40 flex flex-col items-center justify-center overflow-hidden" 
                                     @click="document.getElementById('logo').click()">
                                    
                                    {{-- Placeholder --}}
                                    <template x-if="!imgPreview">
                                        <div class="text-center text-gray-400 flex flex-col items-center">
                                            <i data-lucide="upload-cloud" class="w-8 h-8 mb-2"></i>
                                            <span class="text-sm font-medium text-gray-600">Click to upload logo</span>
                                            <span class="text-xs text-gray-400 mt-1">SVG, PNG, JPG (Max 1MB)</span>
                                        </div>
                                    </template>

                                    {{-- Preview --}}
                                    <template x-if="imgPreview">
                                        <img :src="imgPreview" class="w-full h-full object-contain">
                                    </template>
                                    
                                    {{-- Overlay Hover --}}
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                                        <span class="text-white font-bold bg-black/50 px-3 py-1 rounded-full text-sm">Select Image</span>
                                    </div>

                                    <input id="logo" type="file" name="logo" class="hidden" accept="image/*" @change="previewImage">
                                </div>
                                <x-admin.input-error :messages="$errors->get('logo')" class="mt-2" />
                            </div>
                        </div>

                        {{-- CARD DETAIL --}}
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-6 border-b pb-2">
                                <i data-lucide="file-text" class="w-5 h-5 text-indigo-500"></i>
                                <h3 class="font-bold text-gray-700">Courier Details</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-admin.input-label for="name" value="Courier Name" />
                                    <x-admin.text-input name="name" :value="old('name')" placeholder="e.g. JNE Express" class="w-full" required />
                                    <x-admin.input-error :messages="$errors->get('name')" class="mt-1" />
                                </div>
                                <div>
                                    <x-admin.input-label for="code" value="Service Code (Unique)" />
                                    <x-admin.text-input name="code" :value="old('code')" placeholder="e.g. jne" class="w-full font-mono lowercase" required />
                                    <x-admin.input-error :messages="$errors->get('code')" class="mt-1" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-admin.input-label for="tracking_url_format" value="Tracking URL Format" />
                                <x-admin.text-input name="tracking_url_format" :value="old('tracking_url_format')" placeholder="https://cekresi.com/?no={resi}" class="w-full" />
                                <p class="text-xs text-gray-500 mt-1">Gunakan <code>{resi}</code> sebagai placeholder nomor resi.</p>
                                <x-admin.input-error :messages="$errors->get('tracking_url_format')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: STATUS --}}
                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Publishing</h3>
                            
                            <div>
                                <x-admin.input-label for="is_active" value="Active" />
                                <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                    <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-admin.input-error :messages="$errors->get('is_active')" />
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    Save Courier
                                </x-admin.primary-button>
                                <a href="{{ route('admin.couriers.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- SCRIPT TERPISAH --}}
    @push('scripts')
        <script>
            function initCourierCreateForm() {
                return {
                    imgPreview: null,

                    previewImage(event) {
                        const file = event.target.files[0];
                        if(file) {
                            const reader = new FileReader();
                            reader.onload = (e) => { 
                                this.imgPreview = e.target.result; 
                            }
                            reader.readAsDataURL(file);
                        }
                    }
                }
            }
        </script>
    @endpush
    
</x-admin.app-layout>