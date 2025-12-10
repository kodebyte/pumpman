<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('General Settings') }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Settings' => '#'
                    ]" />
                </div>
            </div>
        </div>
    </x-slot>

    <div class="pb-12" x-data="{ 
        logoPreview: null,
        favPreview: null,
        
        previewImage(event, type) {
            const file = event.target.files[0];
            if(file) {
                const reader = new FileReader();
                reader.onload = (e) => { 
                    if(type === 'logo') this.logoPreview = e.target.result;
                    if(type === 'fav') this.favPreview = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.flash-message />
            
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <h3 class="font-bold text-gray-700">Website Identity</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="site_name" :value="__('Site Name')" />
                                    <x-admin.text-input name="site_name" :value="$settings['site_name'] ?? ''" class="w-full text-lg font-semibold" placeholder="e.g. Aiwa Indonesia" />
                                </div>
                                
                                <div>
                                    <x-admin.input-label for="site_description" :value="__('Meta Description (SEO)')" />
                                    <textarea name="site_description" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm" placeholder="Short description for search engines...">{{ $settings['site_description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <h3 class="font-bold text-gray-700">Brand Visuals</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-admin.input-label :value="__('Website Logo')" />
                                    <div class="mt-2 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-2 hover:bg-gray-50 transition h-40 flex items-center justify-center overflow-hidden" onclick="document.getElementById('site_logo').click()">
                                        <template x-if="!logoPreview">
                                            @if(!empty($settings['site_logo']))
                                                <img src="{{ asset('storage/'.$settings['site_logo']) }}" class="w-full h-full object-contain">
                                            @else
                                                <div class="text-center text-gray-400">
                                                    <span class="text-xs">Upload Logo</span>
                                                </div>
                                            @endif
                                        </template>
                                        <template x-if="logoPreview">
                                            <img :src="logoPreview" class="w-full h-full object-contain">
                                        </template>
                                        <input id="site_logo" type="file" name="site_logo" class="hidden" accept="image/*" @change="previewImage($event, 'logo')">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Recommended: PNG/SVG (Transparent)</p>
                                </div>

                                <div>
                                    <x-admin.input-label :value="__('Favicon (Browser Tab)')" />
                                    <div class="mt-2 relative group cursor-pointer border-2 border-dashed border-gray-300 rounded-lg p-2 hover:bg-gray-50 transition h-40 flex items-center justify-center overflow-hidden" onclick="document.getElementById('site_favicon').click()">
                                        <template x-if="!favPreview">
                                            @if(!empty($settings['site_favicon']))
                                                <img src="{{ asset('storage/'.$settings['site_favicon']) }}" class="w-12 h-12 object-contain">
                                            @else
                                                <div class="text-center text-gray-400">
                                                    <span class="text-xs">Upload Icon</span>
                                                </div>
                                            @endif
                                        </template>
                                        <template x-if="favPreview">
                                            <img :src="favPreview" class="w-12 h-12 object-contain">
                                        </template>
                                        <input id="site_favicon" type="file" name="site_favicon" class="hidden" accept="image/*" @change="previewImage($event, 'fav')">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Recommended: 32x32px or 64x64px</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b pb-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <h3 class="font-bold text-gray-700">Contact Information</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-admin.input-label for="contact_email" :value="__('Support Email')" />
                                    <x-admin.text-input name="contact_email" :value="$settings['contact_email'] ?? ''" class="w-full" placeholder="support@domain.com" />
                                </div>
                                <div>
                                    <x-admin.input-label for="contact_phone" :value="__('WhatsApp / Phone')" />
                                    <x-admin.text-input name="contact_phone" :value="$settings['contact_phone'] ?? ''" class="w-full" placeholder="6281234..." />
                                </div>
                                <div class="md:col-span-2">
                                    <x-admin.input-label for="contact_address" :value="__('Office Address')" />
                                    <textarea name="contact_address" rows="2" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">{{ $settings['contact_address'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Actions</h3>
                            <div class="flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    {{ __('Save Settings') }}
                                </x-admin.primary-button>
                                <p class="text-xs text-gray-400 text-center">Last updated: {{ now()->format('d M Y') }}</p>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Social Media</h3>
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="social_facebook" :value="__('Facebook URL')" />
                                    <x-admin.text-input name="social_facebook" :value="$settings['social_facebook'] ?? ''" class="w-full text-xs" placeholder="https://facebook.com/..." />
                                </div>
                                <div>
                                    <x-admin.input-label for="social_instagram" :value="__('Instagram URL')" />
                                    <x-admin.text-input name="social_instagram" :value="$settings['social_instagram'] ?? ''" class="w-full text-xs" placeholder="https://instagram.com/..." />
                                </div>
                                <div>
                                    <x-admin.input-label for="social_linkedin" :value="__('LinkedIn URL')" />
                                    <x-admin.text-input name="social_linkedin" :value="$settings['social_linkedin'] ?? ''" class="w-full text-xs" placeholder="https://linkedin.com/..." />
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>
</x-admin.app-layout>