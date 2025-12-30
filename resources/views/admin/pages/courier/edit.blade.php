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

    {{-- 
        Pass URL logo yang ada ke Alpine. 
        Pastikan di Model Courier field-nya adalah 'logo' 
    --}}
    <div class="pb-12" x-data="initCourierForm('{{ $courier->logo ? Storage::url($courier->logo) : '' }}')">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.couriers.update', $courier->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- KOLOM KIRI --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Courier Details</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-admin.input-label for="name" value="Courier Name" />
                                    <x-admin.text-input name="name" :value="old('name', $courier->name)" class="w-full font-semibold" required />
                                    <x-admin.input-error :messages="$errors->get('name')" class="mt-1" />
                                </div>
                                <div>
                                    <x-admin.input-label for="code" value="Service Code (Unique)" />
                                    <x-admin.text-input name="code" :value="old('code', $courier->code)" class="w-full font-mono lowercase bg-gray-50" required />
                                    <x-admin.input-error :messages="$errors->get('code')" class="mt-1" />
                                </div>
                            </div>

                            <div class="mt-4">
                                <x-admin.input-label for="tracking_url_format" value="Tracking URL Format" />
                                <x-admin.text-input name="tracking_url_format" :value="old('tracking_url_format', $courier->tracking_url_format)" class="w-full text-sm" />
                                <p class="text-[10px] text-gray-400 mt-1">Gunakan <code>{resi}</code> sebagai placeholder nomor resi.</p>
                                <x-admin.input-error :messages="$errors->get('tracking_url_format')" class="mt-1" />
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Courier Logo</h3>
                            </div>
                            
                            <div>
                                <x-admin.input-label for="logo" value="Current Logo" />
                                
                                <div class="mt-2 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-xl p-4 hover:bg-gray-50 transition h-48 flex flex-col items-center justify-center overflow-hidden" 
                                     @click="document.getElementById('logo').click()">
                                    
                                    {{-- 
                                        Logic: 
                                        Jika imgPreview ada (baik dari DB saat init, atau upload baru), tampilkan gambar.
                                        Jika imgPreview null, tampilkan placeholder upload.
                                    --}}
                                    
                                    <template x-if="imgPreview">
                                        <img :src="imgPreview" class="w-full h-full object-contain">
                                    </template>

                                    <template x-if="!imgPreview">
                                        <div class="text-center text-gray-400 flex flex-col items-center">
                                            <svg class="mx-auto h-8 w-8 mb-2 text-gray-300" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-600">Click to replace logo</span>
                                        </div>
                                    </template>
                                    
                                    {{-- Overlay saat hover --}}
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200">
                                        <span class="text-white font-bold bg-black/50 px-3 py-1 rounded-full text-sm">Change Logo</span>
                                    </div>

                                    <input id="logo" type="file" name="logo" class="hidden" accept="image/*" @change="previewImage">
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Biarkan kosong jika tidak ingin mengubah logo.</p>
                                <x-admin.input-error :messages="$errors->get('logo')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN --}}
                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Settings</h3>
                            </div>
                            
                            <div>
                                <x-admin.input-label for="is_active" value="Status" />
                                <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                    <option value="1" {{ old('is_active', $courier->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $courier->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                </select>
                                <x-admin.input-error :messages="$errors->get('is_active')" />
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700 w-full">
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