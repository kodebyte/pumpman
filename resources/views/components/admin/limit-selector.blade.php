@props(['perPage' => 15])

<div class="flex items-center text-sm text-gray-500">
    <span class="mr-2">Rows:</span>
    <select onchange="updateLimit(this.value)" 
            {{ $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md text-sm py-1 pl-2 pr-8 shadow-sm cursor-pointer']) }}>
        
        @foreach ([15, 30, 50, 100] as $value)
            <option value="{{ $value }}" {{ $perPage == $value ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
</div>