<x-admin.app-layout pageTitle="General Settings">

    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    General Settings
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
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <x-admin.flash-message />
            
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    {{-- LEFT COLUMN --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                {{-- Icon: Globe --}}
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Website Identity</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="site_name" value="Site Name" />
                                    <x-admin.text-input name="site_name" :value="$settings['site_name'] ?? ''" class="w-full text-lg font-semibold" placeholder="e.g. Pumpman Indonesia" />
                                </div>
                                
                                <div>
                                    <x-admin.input-label for="site_description" value="Meta Description (SEO)" />
                                    <textarea name="site_description" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm placeholder-gray-400" placeholder="Brief description of your website...">{{ $settings['site_description'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                {{-- Icon: Image/Photo --}}
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Brand Visuals</h3>
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
                                                    <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                    <span class="text-xs block mt-1">Upload Logo</span>
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
                                                    <svg class="mx-auto h-8 w-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                                    <span class="text-xs block mt-1">Upload Icon</span>
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
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                {{-- Icon: Phone/Chat --}}
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Contact Information</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="md:col-span-2">
                                    <x-admin.input-label for="contact_company_name" value="Contact Company Name" />
                                    <x-admin.text-input name="contact_company_name" :value="$settings['contact_company_name'] ?? ''" class="w-full" placeholder="PT. Pumpman Indonesia" />
                                </div>
                                <div>
                                    <x-admin.input-label for="contact_email" value="Support Email" />
                                    <x-admin.text-input name="contact_email" :value="$settings['contact_email'] ?? ''" class="w-full" placeholder="support@pumpman.id" />
                                </div>
                                <div>
                                    <x-admin.input-label for="contact_phone" value="WhatsApp / Phone" />
                                    <x-admin.text-input name="contact_phone" :value="$settings['contact_phone'] ?? ''" class="w-full" placeholder="+62 812..." />
                                </div>
                                <div class="md:col-span-2">
                                    <x-admin.input-label for="contact_address" value="Office Address" />
                                    <textarea name="contact_address" rows="2" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm" placeholder="Full address...">{{ $settings['contact_address'] ?? '' }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <x-admin.input-label for="contact_business_hours" value="Bussiness Hours" />
                                    <textarea name="contact_business_hours" rows="2" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm" placeholder="Mon-Fri: 08:00 - 17:00">{{ $settings['contact_business_hours'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                {{-- Icon: Map/Pin --}}
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Contact Maps</h3>
                            </div>
                            
                            <div class="space-y-6">
                                <div>
                                    <x-admin.input-label for="contact_maps_embed" value="Maps Embed (Iframe Source URL)" />
                                    <x-admin.text-input name="contact_maps_embed" :value="$settings['contact_maps_embed'] ?? ''" class="w-full text-sm text-gray-600" placeholder="https://www.google.com/maps/embed?..." />
                                    <p class="text-[10px] text-gray-400 mt-1">Copy the 'src' attribute from Google Maps Embed code.</p>
                                </div>
                                <div >
                                    <x-admin.input-label for="contact_maps_link" value="Maps Direct Link" />
                                    <x-admin.text-input name="contact_maps_link" :value="$settings['contact_maps_link'] ?? ''" class="w-full text-sm text-gray-600" placeholder="https://maps.app.goo.gl/..." />
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                {{-- Icon: Share/Social --}}
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Social Media</h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <x-admin.input-label for="social_facebook" value="Facebook URL" />
                                    <x-admin.text-input name="social_facebook" :value="$settings['social_facebook'] ?? ''" class="w-full text-xs" placeholder="https://facebook.com/..." />
                                </div>
                                <div>
                                    <x-admin.input-label for="social_instagram" value="Instagram URL" />
                                    <x-admin.text-input name="social_instagram" :value="$settings['social_instagram'] ?? ''" class="w-full text-xs" placeholder="https://instagram.com/..." />
                                </div>
                                <div>
                                    <x-admin.input-label for="social_linkedin" value="LinkedIn URL" />
                                    <x-admin.text-input name="social_linkedin" :value="$settings['social_linkedin'] ?? ''" class="w-full text-xs" placeholder="https://linkedin.com/in/..." />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                {{-- Icon: Truck --}}
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Shipments & Tax</h3>
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <x-admin.input-label for="flat_shipping_fee" value="Flat Shipping Fee" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="flat_shipping_fee" id="flat_shipping_fee" value="{{ $settings['flat_shipping_fee'] ?? '' }}" class="block w-full rounded-md border-gray-300 pl-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="0">
                                    </div>
                                </div>

                                <div>
                                    <x-admin.input-label for="tax_rate" value="Tax Rate (%)" />
                                    <div class="relative mt-1 rounded-md shadow-sm">
                                        <input type="number" name="tax_rate" id="tax_rate" value="{{ $settings['tax_rate'] ?? '' }}" class="block w-full rounded-md border-gray-300 pr-10 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="11">
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                            <span class="text-gray-500 sm:text-sm">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <div class="flex items-center gap-2 mb-4 border-b border-gray-100 pb-2">
                                {{-- Icon: Save/Check --}}
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 class="font-bold text-gray-700 text-lg">Actions</h3>
                            </div>
                            
                            <div class="flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700 w-full">
                                    {{ __('Save Settings') }}
                                </x-admin.primary-button>
                                <p class="text-xs text-gray-400 text-center">Last updated: {{ now()->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-admin.app-layout>