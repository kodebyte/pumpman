@props(['links' => []])

<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-1">
        
        <li class="inline-flex items-center">
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">
                Dashboard
            </a>
        </li>

        @foreach($links as $label => $url)
            <li>
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    
                    @if(!$loop->last)
                        <a href="{{ $url }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">
                            {{ $label }}
                        </a>
                    @else
                        <span class="ml-1 text-sm font-medium text-gray-800">
                            {{ $label }}
                        </span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>