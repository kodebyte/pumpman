<x-admin.app-layout pageTitle="Edit Courier">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Courier: {{ $courier->name }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Couriers' => route('admin.couriers.index'),
                        'Edit' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Inisialisasi x-data menggunakan function dari script terpisah --}}
    <div class="pb-12" x-data="initCourierForm('{{ $courier->logo ? Storage::url($courier->logo) : '' }}')">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.couriers.update', $courier->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
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
                                    
                                    {{-- Tampilkan Placeholder jika belum ada gambar --}}
                                    <template x-if="!imgPreview">
                                        <div class="text-center text-gray-400 flex flex-col items-center">
                                            <i data-lucide="upload-cloud" class="w-8 h-8 mb-2"></i>
                                            <span class="text-sm font-medium text-gray-600">Click to replace logo</span>
                                        </div>
                                    </template>
                                    
                                    {{-- Tampilkan Preview Gambar --}}
                                    <template x-if="imgPreview">
                                        <img :src="imgPreview" class="w-full h-full object-contain">
                                    </template>
                                    
                                    {{-- Overlay Hover --}}
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                                        <span class="text-white font-bold bg-black/50 px-3 py-1 rounded-full text-sm">Change Logo</span>
                                    </div>

                                    <input id="logo" type="file" name="logo" class="hidden" accept="image/*" @change="previewImage">
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah logo.</p>
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
                                    <x-admin.text-input name="name" :value="old('name', $courier->name)" class="w-full" required />
                                    <x-admin.input-error :messages="$errors->get('name')" class="mt-1" />
                                </div>
                                <div>
                                    <x-admin.input-label for="code" value="Service Code (Unique)" />
                                    <x-admin.text-input name="code" :value="old('code', $courier->code)" class="w-full font-mono lowercase" required />
                                    <x-admin.input-error :messages="$errors->get('code')" class="mt-1" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-admin.input-label for="tracking_url_format" value="Tracking URL Format" />
                                <x-admin.text-input name="tracking_url_format" :value="old('tracking_url_format', $courier->tracking_url_format)" class="w-full" />
                                <p class="text-xs text-gray-500 mt-1">Gunakan <code>{resi}</code> sebagai placeholder nomor resi.</p>
                                <x-admin.input-error :messages="$errors->get('tracking_url_format')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: STATUS & ACTION --}}
                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Publishing</h3>
                            
                            <div>
                                <x-admin.input-label for="is_active" value="Active Status" />
                                <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                    <option value="1" {{ old('is_active', $courier->is_active) == true ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $courier->is_active) == false ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    Update Courier
                                </x-admin.primary-button>
                                <a href="{{ route('admin.couriers.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function initCourierForm(existingImageUrl) {
                return {
                    imgPreview: existingImageUrl || null,

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