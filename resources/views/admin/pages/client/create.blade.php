<x-admin.app-layout pageTitle="Add Client">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Add Client
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Clients' => route('admin.clients.index'),
                        'Create' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    {{-- Panggil x-data dari script di bawah --}}
    <div class="pb-12" x-data="clientForm()">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.clients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- LEFT COLUMN --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white p-6 shadow-sm sm:rounded-xl border border-gray-100">
                            {{-- Header dengan Icon --}}
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Client Information</h3>
                            </div>
                            
                            <div class="space-y-4">
                                {{-- Name Input --}}
                                <div>
                                    <x-admin.input-label for="name" value="Client Name" />
                                    <x-admin.text-input id="name" name="name" :value="old('name')" class="w-full mt-1" placeholder="e.g., PT. Maju Mundur" required />
                                    <x-admin.input-error :messages="$errors->get('name')" class="mt-1" />
                                </div>

                                {{-- URL Input --}}
                                <div>
                                    <x-admin.input-label for="url" value="Website URL (Optional)" />
                                    <x-admin.text-input type="url" id="url" name="url" :value="old('url')" class="w-full mt-1" placeholder="https://example.com" />
                                    <x-admin.input-error :messages="$errors->get('url')" class="mt-1" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-6 shadow-sm sm:rounded-xl border border-gray-100">
                            {{-- Header dengan Icon --}}
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Client Logo</h3>
                            </div>
                            
                            <div class="flex flex-col items-center justify-center border-2 border-dashed border-gray-300 rounded-lg p-6 bg-gray-50 hover:bg-gray-100 transition relative min-h-[200px]">
                                <input type="file" name="logo" id="logo" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" @change="previewImage" required accept="image/*">
                                
                                {{-- Default State --}}
                                <div x-show="!imgPreview" class="text-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-gray-400">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">Click to upload logo</p>
                                    <p class="text-xs text-gray-500">PNG, JPG up to 2MB</p>
                                </div>

                                {{-- Preview State --}}
                                <div x-show="imgPreview" style="display: none;" class="relative z-0">
                                    <img :src="imgPreview" class="max-h-48 rounded shadow-sm object-contain">
                                    <p class="text-xs text-center text-gray-500 mt-2">Click area to change</p>
                                </div>
                            </div>
                            <x-admin.input-error :messages="$errors->get('logo')" class="mt-1" />
                        </div>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-white p-6 shadow-sm sm:rounded-xl border border-gray-100 sticky top-6">
                            {{-- Header dengan Icon --}}
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Settings</h3>
                            </div>
                            
                            <div class="space-y-4">
                                {{-- Active Status --}}
                                <div>
                                    <x-admin.input-label for="is_active" value="Status" />
                                    <select name="is_active" id="is_active" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 text-sm">
                                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    <x-admin.input-error :messages="$errors->get('is_active')" class="mt-1" />
                                </div>

                                {{-- Order --}}
                                <div>
                                    <x-admin.input-label for="order" value="Sort Order" />
                                    <x-admin.text-input type="number" name="order" id="order" :value="old('order', 0)" class="w-full mt-1" min="0" />
                                    <p class="text-xs text-gray-500 mt-1">Lower numbers appear first.</p>
                                    <x-admin.input-error :messages="$errors->get('order')" class="mt-1" />
                                </div>
                            </div>

                            <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    Save Client
                                </x-admin.primary-button>
                                <a href="{{ route('admin.clients.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
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
            Alpine.data('clientForm', () => ({
                imgPreview: null,
                previewImage(event) {
                    const file = event.target.files[0];
                    if(file) {
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