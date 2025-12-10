<x-admin.app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Products') }}</h2>
                <div class="mt-2"><x-admin.breadcrumb :links="['Products' => '#']" /></div>
            </div>
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md text-xs uppercase hover:bg-gray-700 transition">+ Add Product</a>
        </div>
    </x-slot>

    <div class="pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-admin.flash-message />

            <div class="bg-white shadow-sm sm:rounded-xl border border-gray-100 flex flex-col">
                
                <div class="p-6 border-b border-gray-100">
                    <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-col md:flex-row gap-4">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="hidden" name="direction" value="{{ request('direction') }}">
                        <input type="hidden" name="limit" value="{{ request('limit') }}">

                        <div class="flex-1 relative">
                            <input type="text" name="search" value="{{ request('search') }}" class="pl-3 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" placeholder="Search product name or SKU...">
                        </div>
                        
                        <div class="w-full md:w-48">
                            <select name="category_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Categories</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->getTranslation('name') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full md:w-40">
                            <select name="is_active" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 sm:text-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-gray-100 rounded-lg text-xs uppercase font-bold hover:bg-gray-200">Search</button>
                        
                        @if(request()->hasAny(['search', 'category_id', 'is_active', 'sort']))
                            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs font-semibold text-red-500 uppercase hover:bg-red-50 flex items-center justify-center">Clear</a>
                        @endif
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <x-admin.th-sortable name="name" label="Product Info" />
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                                <x-admin.th-sortable name="price" label="Price" />
                                <x-admin.th-sortable name="is_active" label="Status" />
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 h-12 w-12 border rounded-lg overflow-hidden bg-gray-50">
                                                @if($product->thumbnail)
                                                    <img src="{{ asset('storage/' . $product->thumbnail) }}" class="h-full w-full object-cover">
                                                @else
                                                    <div class="h-full w-full flex items-center justify-center text-xs text-gray-400">No IMG</div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-gray-900 line-clamp-1">{{ $product->name }}</div>
                                                <div class="flex items-center gap-2 mt-1">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-gray-100 text-gray-800">
                                                        {{ $product->variants_count > 0 ? $product->variants_count . ' Variants' : 'Single Item' }}
                                                    </span>
                                                    @if($product->is_featured)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-amber-100 text-amber-800 border border-amber-200">Featured</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            {{ $product->category ? $product->category->getTranslation('name') : 'Uncategorized' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-mono text-gray-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                        @if($product->has_discount)
                                            <div class="text-xs text-red-600 font-bold bg-red-50 inline-block px-1 rounded mt-0.5">
                                                {{ $product->discount_label }} OFF
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <x-admin.status-badge :active="$product->is_active" true-text="Published" false-text="Draft" />
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <x-admin.btn-edit :href="route('admin.products.edit', $product->id)" />
                                            <x-admin.btn-delete :action="route('admin.products.destroy', $product->id)" :item="$product->name" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-admin.empty-state colspan="5" message="No products found in catalog." />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($products->hasPages() || $products->count() > 0)
                    <div class="bg-white px-6 py-4 border-t border-gray-200 flex justify-between items-center">
                        <div class="flex-1 flex justify-start">{{ $products->appends(request()->all())->links() }}</div>
                        <x-admin.limit-selector :per-page="$perPage" />
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin.app-layout>