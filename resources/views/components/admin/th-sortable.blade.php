@props(['name', 'label'])

<th scope="col" 
    {{ $attributes->merge(['class' => 'px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider cursor-pointer group']) }}
    onclick="window.location.href='{{ route(request()->route()->getName(), array_merge(request()->all(), ['sort' => $name, 'direction' => request('direction') == 'asc' ? 'desc' : 'asc'])) }}'">
    
    <div class="flex items-center gap-1">
        {{ $label }}
        
        <svg class="w-3 h-3 {{ request('sort') == $name ? (request('direction') == 'asc' ? 'rotate-180' : '') : 'text-gray-300 opacity-0 group-hover:opacity-100' }}" 
             fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
    </div>
</th>