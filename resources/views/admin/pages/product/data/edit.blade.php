<x-admin.app-layout pageTitle="Edit Product">
    
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Edit Product: {{ $product->name }}
                </h2>
                <div class="mt-2">
                    <x-admin.breadcrumb :links="[
                        'Dashboard' => route('admin.dashboard'),
                        'Products' => route('admin.products.index'),
                        'Edit' => '#'
                    ]" />
                </div>
            </div>

            <a href="" target="_blank" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium flex items-center bg-indigo-50 px-3 py-1 rounded-full border border-indigo-100 hover:bg-indigo-100 transition">
                View in Store <span class="ml-1">&rarr;</span>
            </a>
        </div>
    </x-slot>

    @php
        $initialTab = 'general';

        if ($errors->any()) {
            if ($errors->hasAny(['name', 'category_id', 'description.*'])) $initialTab = 'general';
            elseif ($errors->hasAny(['price', 'weight', 'discount_type', 'discount_value'])) $initialTab = 'pricing';
            elseif ($errors->hasAny(['images', 'images.*', 'delete_images'])) $initialTab = 'media';
            elseif ($errors->hasAny(['has_variants', 'variants.*'])) $initialTab = 'variants';
            elseif ($errors->hasAny(['marketplaces', 'downloads', 'delete_downloads'])) $initialTab = 'links';
        }
    @endphp

    <div class="pb-12" x-data="productForm({
        initialTab: '{{ $initialTab }}',
        discountType: '{{ old('discount_type', $product->discount_type) }}',
        hasVariants: {{ old('has_variants', $product->has_variants) ? 'true' : 'false' }},
        variants: {{ old('variants') ? Js::from(old('variants')) : ($product->variants->isNotEmpty() ? Js::from($product->variants) : '[{id: null, name: "", price: "", stock: "", sku: ""}]') }}
    })">
        <div class="max-w-7xl mx-auto pt-6 px-4 sm:px-6 lg:px-8">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <template x-for="id in imagesToDelete">
                    <input type="hidden" name="delete_images[]" :value="id">
                </template>
                <template x-for="id in downloadsToDelete" :key="id">
                    <input type="hidden" name="delete_downloads[]" :value="id">
                </template>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 overflow-hidden">
                            <div class="border-b border-gray-200 bg-gray-50/50 px-6 pt-4">
                                <nav class="-mb-px flex space-x-6 overflow-x-auto" aria-label="Tabs">
                                    @php
                                        $tabClass = "whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm transition-colors duration-200 focus:outline-none flex items-center gap-2";
                                        $activeClass = "border-indigo-500 text-indigo-600";
                                        $inactiveClass = "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300";
                                    @endphp

                                    <button type="button" @click="activeTab = 'general'" :class="activeTab === 'general' ? '{{ $activeClass }}' : '{{ $inactiveClass }}'" class="{{ $tabClass }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        General
                                        @if($errors->hasAny(['name', 'category_id', 'description'])) <span class="ml-1 w-2 h-2 bg-red-500 rounded-full"></span> @endif
                                    </button>

                                    <button type="button" @click="activeTab = 'pricing'" :class="activeTab === 'pricing' ? '{{ $activeClass }}' : '{{ $inactiveClass }}'" class="{{ $tabClass }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Pricing
                                        @if($errors->hasAny(['price', 'weight', 'discount_type'])) <span class="ml-1 w-2 h-2 bg-red-500 rounded-full"></span> @endif
                                    </button>

                                    <button type="button" @click="activeTab = 'media'" :class="activeTab === 'media' ? '{{ $activeClass }}' : '{{ $inactiveClass }}'" class="{{ $tabClass }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Media
                                    </button>

                                    <button type="button" @click="activeTab = 'variants'" :class="activeTab === 'variants' ? '{{ $activeClass }}' : '{{ $inactiveClass }}'" class="{{ $tabClass }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                        Variants
                                    </button>

                                    <button type="button" @click="activeTab = 'links'" :class="activeTab === 'links' ? '{{ $activeClass }}' : '{{ $inactiveClass }}'" class="{{ $tabClass }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                        Links
                                    </button>
                                </nav>
                            </div>

                            <div class="p-6 sm:p-8 min-h-[500px]">
                                <div x-show="activeTab === 'general'" x-transition:enter.duration.300ms>
                                    <div class="space-y-6">
                                        <div>
                                            <x-admin.input-label for="name" value="Product Name" />
                                            <x-admin.text-input name="name" :value="old('name', $product->name)" required class="w-full text-lg font-semibold" />
                                            <x-admin.input-error :messages="$errors->get('name')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-admin.input-label for="category_id" value="Category" />
                                            <select name="category_id" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>
                                                        {{ $cat->getTranslation('name') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <x-admin.input-error :messages="$errors->get('category_id')" class="mt-2" />
                                        </div>

                                        <div x-data="{ lang: 'en' }" class="bg-gray-50 p-5 rounded-xl border border-gray-100 mt-6">
                                            <div class="flex items-center justify-between mb-6 border-b border-gray-200 pb-4">
                                                <h3 class="font-bold text-gray-700 flex items-center gap-2">
                                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                                    Product Descriptions
                                                </h3>
                                                <div class="flex bg-white p-1 rounded-lg border border-gray-200 shadow-sm">
                                                    <button type="button" @click="lang = 'en'" :class="lang === 'en' ? 'bg-indigo-50 text-indigo-700 font-bold shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-1.5 text-xs rounded transition-all">
                                                        EN
                                                    </button>
                                                    <button type="button" @click="lang = 'id'" :class="lang === 'id' ? 'bg-indigo-50 text-indigo-700 font-bold shadow-sm' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-1.5 text-xs rounded transition-all">
                                                        ID
                                                    </button>
                                                </div>
                                            </div>

                                            <div x-show="lang === 'en'" x-transition:enter.duration.300ms>
                                                <div class="mb-6">
                                                    <x-admin.input-label value="Short Description" class="mb-1" />
                                                    <textarea name="short_description[en]" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 text-sm">{{ old('short_description.en', $product->getTranslation('short_description', 'en') ?? $product->short_description['en'] ?? '') }}</textarea>
                                                </div>
                                                <div wire:ignore>
                                                    <x-admin.input-label value="Full Description" class="mb-1" />
                                                    <textarea id="description_en" name="description[en]" rows="8" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">{{ old('description.en', $product->getTranslation('description', 'en') ?? $product->description['en'] ?? '') }}</textarea>
                                                </div>
                                            </div>

                                            <div x-show="lang === 'id'" x-transition:enter.duration.300ms style="display: none;">
                                                <div class="mb-6">
                                                    <x-admin.input-label value="Deskripsi Singkat" class="mb-1" />
                                                    <textarea name="short_description[id]" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 text-sm">{{ old('short_description.id', $product->getTranslation('short_description', 'id') ?? $product->short_description['id'] ?? '') }}</textarea>
                                                </div>
                                                <div wire:ignore>
                                                    <x-admin.input-label value="Deskripsi Lengkap" class="mb-1" />
                                                    <textarea id="description_id" name="description[id]" rows="8" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500">{{ old('description.id', $product->getTranslation('description', 'id') ?? $product->description['id'] ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="activeTab === 'pricing'" x-transition:enter.duration.300ms style="display: none;">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <x-admin.input-label for="sku" value="SKU" />
                                            <x-admin.text-input type="text" name="sku" :value="old('sku', $product->sku)" class="w-full font-mono uppercase" />
                                            <p class="text-xs text-gray-500 mt-1">Kode unik produk induk.</p>
                                            <x-admin.input-error :messages="$errors->get('sku')" class="mt-2" />
                                        </div>

                                        <div x-show="!hasVariants" x-transition>
                                            <x-admin.input-label for="stock" value="Stock Qty" />
                                            <x-admin.text-input type="number" name="stock" :value="old('stock', $product->stock)" class="w-full" />
                                            <p class="text-xs text-gray-500 mt-1">Stok untuk produk single (tanpa varian).</p>
                                            <x-admin.input-error :messages="$errors->get('stock')" class="mt-2" />
                                        </div>
                                        
                                        <div>
                                            <x-admin.input-label for="price" value="Base Price (Rp)" />
                                            <x-admin.text-input type="number" name="price" :value="old('price', $product->price)" required class="w-full font-mono text-lg" />
                                            <p class="text-xs text-gray-500 mt-1">Harga ini akan digunakan apabila produk tidak memiliki varian.</p>
                                            <x-admin.input-error :messages="$errors->get('price')" class="mt-2" />
                                        </div>

                                        <div>
                                            <x-admin.input-label for="weight" value="Weight (Gram)" />
                                            <x-admin.text-input type="number" name="weight" :value="old('weight', $product->weight)" required class="w-full" />
                                            <x-admin.input-error :messages="$errors->get('weight')" class="mt-2" />
                                        </div>

                                        <div class="md:col-span-2 bg-gray-50 p-6 rounded-xl border border-gray-100 mt-4">
                                            <h3 class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                                Discount Settings (Optional)
                                            </h3>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                <div>
                                                    <x-admin.input-label value="Discount Type" />
                                                    <select name="discount_type" x-model="discountType" class="block w-full border-gray-300 rounded-lg shadow-sm mt-1 text-sm">
                                                        <option value="">None</option>
                                                        <option value="fixed">Fixed Amount (Rp)</option>
                                                        <option value="percent">Percentage (%)</option>
                                                    </select>
                                                </div>
                                                <div x-show="discountType !== ''">
                                                    <x-admin.input-label value="Discount Value" />
                                                    <x-admin.text-input type="number" name="discount_value" :value="old('discount_value', $product->discount_value)" class="w-full mt-1" />
                                                </div>
                                                
                                                <div x-show="discountType !== ''" class="grid grid-cols-2 gap-2">
                                                    <div>
                                                        <x-admin.input-label value="Start Date" />
                                                        <input type="date" name="discount_start_date" value="{{ $product->discount_start_date ? $product->discount_start_date->format('Y-m-d') : '' }}" class="block w-full border-gray-300 rounded-lg text-sm mt-1">
                                                    </div>
                                                    <div>
                                                        <x-admin.input-label value="End Date" />
                                                        <input type="date" name="discount_end_date" value="{{ $product->discount_end_date ? $product->discount_end_date->format('Y-m-d') : '' }}" class="block w-full border-gray-300 rounded-lg text-sm mt-1">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="activeTab === 'media'" x-transition:enter.duration.300ms style="display: none;">
                                    <div class="space-y-8">
                                        
                                        @if($product->images->count() > 0)
                                            <div>
                                                <div class="flex items-center justify-between mb-4">
                                                    <h3 class="text-sm font-bold text-gray-700 flex items-center gap-2">
                                                        <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                        Current Images
                                                    </h3>
                                                    <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">Click trash icon to mark for deletion</span>
                                                </div>
                                                
                                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                                    @foreach($product->images as $img)
                                                        <div class="relative group border rounded-xl overflow-hidden bg-white shadow-sm transition-all duration-200"
                                                            :class="isDeleted({{ $img->id }}) ? 'opacity-40 ring-2 ring-red-500' : ''">
                                                            
                                                            <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-32 object-cover">
                                                            
                                                            @if($img->is_primary)
                                                                <span class="absolute top-2 left-2 bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow">Primary</span>
                                                            @endif

                                                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-colors flex items-center justify-center">
                                                                <button type="button" 
                                                                        @click="toggleDeleteImage({{ $img->id }})"
                                                                        class="absolute top-2 right-2 p-1.5 rounded-full shadow-sm transition-colors duration-200"
                                                                        :class="isDeleted({{ $img->id }}) ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-white text-gray-500 hover:text-red-600 opacity-0 group-hover:opacity-100'">
                                                                    
                                                                    <svg x-show="!isDeleted({{ $img->id }})" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                                    <svg x-show="isDeleted({{ $img->id }})" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                                                                </button>

                                                                <span x-show="isDeleted({{ $img->id }})" class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded shadow-lg">Deleted</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="border-t border-gray-200"></div>
                                        @endif

                                        <div>
                                            <h3 class="text-sm font-bold text-gray-700 mb-3">Upload New Images</h3>
                                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-10 text-center hover:bg-gray-50 transition relative cursor-pointer group">
                                                <input type="file" id="images" name="images[]" multiple accept="image/png, image/jpeg, image/webp" 
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                                    @change="handleFileSelect" />
                                                
                                                <div class="flex flex-col items-center pointer-events-none">
                                                    <div class="p-3 bg-indigo-50 rounded-full mb-3 group-hover:scale-110 transition">
                                                        <svg class="h-8 w-8 text-indigo-500" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                                    </div>
                                                    <p class="mt-2 text-sm text-gray-700 font-medium">Click to upload or drag and drop</p>
                                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP up to 2MB</p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4" x-show="imgPreviews.length > 0" x-transition>
                                                <template x-for="(img, index) in imgPreviews" :key="index">
                                                    <div class="relative group border rounded-xl overflow-hidden bg-white shadow-sm aspect-square">
                                                        <img :src="img.url" class="w-full h-full object-cover">
                                                        <span class="absolute top-2 left-2 bg-green-500 text-white text-[10px] font-bold px-2 py-0.5 rounded shadow">New</span>
                                                        <button type="button" @click="removeNewImage(index)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 shadow-md opacity-0 group-hover:opacity-100 transition hover:bg-red-600">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        </button>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div x-show="activeTab === 'variants'" x-transition:enter.duration.300ms style="display: none;">
                                    <div class="flex items-center mb-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                        <input type="checkbox" id="has_variants" name="has_variants" value="1" x-model="hasVariants" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 h-5 w-5">
                                        <label for="has_variants" class="ml-3 block text-sm font-bold text-gray-800">Enable Product Variants (Size, Color, etc.)</label>
                                    </div>

                                    <div x-show="!hasVariants" class="text-center py-12 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <p>Simple product mode enabled.</p>
                                    </div>

                                    <div x-show="hasVariants">
                                        <div class="space-y-3">
                                            <template x-for="(variant, index) in variants" :key="index">
                                                <div class="flex flex-col md:flex-row gap-3 items-start border p-4 rounded-xl bg-white shadow-sm hover:shadow-md transition">
                                                    <input type="hidden" :name="`variants[${index}][id]`" :value="variant.id">
                                                    
                                                    <div class="flex-1 w-full">
                                                        <label class="text-xs text-gray-500 font-bold uppercase mb-1 block">Variant Name</label>
                                                        <input type="text" :name="`variants[${index}][name]`" x-model="variant.name" placeholder="Name" class="block w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500" :required="hasVariants" :disabled="!hasVariants"> 
                                                    </div>
                                                    <div class="w-full md:w-32">
                                                        <label class="text-xs text-gray-500 font-bold uppercase mb-1 block">Price (Rp)</label>
                                                        <input type="number" :name="`variants[${index}][price]`" x-model="variant.price" class="block w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500" :disabled="!hasVariants">
                                                    </div>
                                                    <div class="w-full md:w-24">
                                                        <label class="text-xs text-gray-500 font-bold uppercase mb-1 block">Stock</label>
                                                        <input type="number" :name="`variants[${index}][stock]`" x-model="variant.stock" class="block w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500" :disabled="!hasVariants">
                                                    </div>
                                                    <div class="w-full md:w-40">
                                                        <label class="text-xs text-gray-500 font-bold uppercase mb-1 block">SKU</label>
                                                        <input type="text" :name="`variants[${index}][sku]`" x-model="variant.sku" placeholder="SKU" class="block w-full border-gray-300 rounded-lg text-sm focus:ring-indigo-500" :disabled="!hasVariants">
                                                    </div>
                                                    <div class="pt-6">
                                                        <button type="button" @click="variants.splice(index, 1)" class="text-red-400 hover:text-red-600 p-1 rounded-full hover:bg-red-50 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <button type="button" @click="variants.push({id: null, name: '', price: '', stock: '', sku: ''})" class="mt-4 flex items-center gap-2 text-sm text-indigo-600 font-bold hover:text-indigo-800 transition">
                                            + Add Variant
                                        </button>
                                    </div>
                                </div>

                                <div x-show="activeTab === 'links'" x-transition:enter.duration.300ms style="display: none;">
                                    <div class="space-y-8">
                                        
                                        <div>
                                            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                                Marketplace Integration
                                            </h3>
                                            <div class="space-y-3 bg-gray-50 p-6 rounded-xl border border-gray-100">
                                                @foreach($marketplaces as $index => $mp)
                                                    @php $existingLink = $product->marketplaces->find($mp->id)->pivot->link ?? ''; @endphp
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-8 flex justify-center">
                                                            @if($mp->icon) <img src="{{ asset('storage/'.$mp->icon) }}" class="w-6 h-6 object-contain"> @else <span class="w-6 h-6 bg-gray-200 rounded-full block"></span> @endif
                                                        </div>
                                                        <span class="w-24 text-sm font-bold text-gray-700">{{ $mp->name }}</span>
                                                        <input type="hidden" name="marketplaces[{{ $index }}][id]" value="{{ $mp->id }}">
                                                        <x-admin.text-input name="marketplaces[{{ $index }}][link]" :value="$existingLink" class="flex-1 text-sm" placeholder="Paste product URL here..." />
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>

                                        <div>
                                            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                Support Files
                                            </h3>
                                            
                                            @if($product->downloads->count() > 0)
                                                <div class="grid grid-cols-1 gap-2 mb-4">
                                                    @foreach($product->downloads as $file)
                                                        <div class="flex items-center justify-between p-3 border rounded-lg transition-colors duration-200"
                                                            :class="isDownloadDeleted({{ $file->id }}) ? 'bg-red-50 border-red-200' : 'bg-gray-50 border-gray-200'">
                                                            
                                                            <div class="flex items-center overflow-hidden">
                                                                <svg class="w-5 h-5 mr-3 flex-shrink-0" :class="isDownloadDeleted({{ $file->id }}) ? 'text-red-400' : 'text-gray-500'" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                                                                <div class="flex flex-col">
                                                                    <a href="{{ asset('storage/'.$file->file_path) }}" target="_blank" 
                                                                    class="text-sm font-medium hover:underline truncate"
                                                                    :class="isDownloadDeleted({{ $file->id }}) ? 'text-red-800 line-through' : 'text-gray-700'">
                                                                        {{ $file->title }}
                                                                    </a>
                                                                    <span x-show="isDownloadDeleted({{ $file->id }})" class="text-[10px] text-red-600 font-bold">Marked for deletion</span>
                                                                </div>
                                                            </div>

                                                            <button type="button" @click="toggleDeleteDownload({{ $file->id }})"
                                                                    class="p-1.5 rounded-full transition-colors focus:outline-none ml-2"
                                                                    :class="isDownloadDeleted({{ $file->id }}) ? 'bg-white text-gray-500 hover:bg-gray-200' : 'bg-white text-red-500 hover:bg-red-50 border border-red-100'">
                                                                <svg x-show="!isDownloadDeleted({{ $file->id }})" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                                <svg x-show="isDownloadDeleted({{ $file->id }})" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" /></svg>
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 hover:bg-gray-50 transition text-center">
                                                <input type="file" name="downloads[]" multiple accept=".pdf" class="hidden" id="file-upload">
                                                <label for="file-upload" class="cursor-pointer block">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48"><path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
                                                    <p class="mt-2 text-sm text-gray-600 font-medium">Upload Manual Book / Datasheet (PDF)</p>
                                                    <p class="text-xs text-gray-500 mt-1">Max 5MB per file</p>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 p-6 sticky top-6">
                            <h3 class="font-bold text-gray-700 mb-4 border-b pb-2">Publishing</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <x-admin.input-label for="is_active" value="Status" />
                                    <select name="is_active" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="1" {{ old('is_active', $product->is_active) == true ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $product->is_active) == false ? 'selected' : '' }}>Draft</option>
                                    </select>
                                </div>

                                <div>
                                    <x-admin.input-label for="is_featured" value="Is Featured" />
                                    <select name="is_featured" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 mt-1 text-sm">
                                        <option value="0" {{ old('is_featured', $product->is_featured) == false ? 'selected' : '' }}>No</option>
                                        <option value="1" {{ old('is_featured', $product->is_featured) == true ? 'selected' : '' }}>Yes</option>
                                    </select>
                                </div>

                                <div>
                                    <x-admin.input-label for="order" value="Sort Order" />
                                    <x-admin.text-input type="number" name="order" :value="old('order', $product->order)" class="w-full text-sm mt-1" />
                                    <p class="text-xs text-gray-500 mt-1">Lower number appears first.</p>
                                </div>
                            </div>

                             <div class="mt-6 flex flex-col gap-3">
                                <x-admin.primary-button class="justify-center bg-gray-800 hover:bg-gray-700">
                                    {{ __('Update Product') }}
                                </x-admin.primary-button>
                                <a href="{{ route('admin.products.index') }}" class="text-center text-sm text-gray-600 hover:text-gray-900 underline">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @include('admin.plugins.ckeditor')

</x-admin.app-layout>