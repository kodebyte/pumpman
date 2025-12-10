@props(['colspan' => 5, 'message' => 'No data found', 'href' => null, 'cta' => null])

<tr>
    <td colspan="{{ $colspan }}" class="px-6 py-6 text-center text-gray-500 bg-white">
        <div class="flex flex-col items-center justify-center">
            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <p class="text-sm text-gray-900">{{ $message }}</p>
            
            @if($href && $cta)
                <a href="{{ $href }}" class="mt-4 inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium">
                    {{ $cta }} &rarr;
                </a>
            @endif
        </div>
    </td>
</tr>