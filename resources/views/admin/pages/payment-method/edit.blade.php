<x-admin.app-layout pageTitle="Edit Payment Method">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit: {{ $paymentMethod->name }}</h2>
            <div class="mt-2">
                <x-admin.breadcrumb :links="[
                    'Payment Methods' => route('admin.payment-methods.index'),
                    'Edit' => '#'
                ]" />
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="{ 
        imgPreview: '{{ $paymentMethod->image_url }}',
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
            <form action="{{ route('admin.payment-methods.update', $paymentMethod->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- LEFT COLUMN --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                <h3 class="font-bold text-gray-700 text-lg">Payment Details</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="name" value="Payment Name" />
                                    <x-admin.text-input name="name" :value="old('name', $paymentMethod->name)" class="w-full font-semibold" required />
                                    <x-admin.input-error :messages="$errors->get('name')" class="mt-1" />
                                </div>

                                <div>
                                    <x-admin.input-label for="image" value="Logo Image" />
                                    <div class="mt-2 border-2 border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer hover:bg-gray-50 transition h-48 relative" onclick="document.getElementById('image').click()">
                                        <template x-if="!imgPreview">
                                            <div class="text-center text-gray-400">
                                                <span class="text-sm">Click to upload logo</span>
                                            </div>
                                        </template>
                                        <template x-if="imgPreview">
                                            <img :src="imgPreview" class="w-full h-full object-contain p-2">
                                        </template>
                                        
                                        <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 hover:opacity-100 transition duration-200 rounded-xl">
                                            <span class="text-white font-bold bg-black/50 px-3 py-1 rounded-full text-sm">Change Logo</span>
                                        </div>

                                        <input id="image" type="file" name="image" class="hidden" accept="image/*" @change="previewImage">
                                    </div>
                                    <x-admin.input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                <h3 class="font-bold text-gray-700 text-lg">Settings</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" value="Status" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1" {{ old('is_active', $paymentMethod->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $paymentMethod->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div>
                                    <x-admin.input-label for="order" value="Sort Order" />
                                    <x-admin.text-input type="number" name="order" :value="old('order', $paymentMethod->order)" class="w-full" min="0" />
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700 w-full">Update Method</x-admin.primary-button>
                                <a href="{{ route('admin.payment-methods.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</x-admin.app-layout>