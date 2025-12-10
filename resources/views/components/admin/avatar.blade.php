@props(['name', 'photo' => null])

@php
    // Logika: Jika ada path foto, gunakan asset storage. 
    // Jika tidak, generate inisial dari nama.
    $src = $photo 
        ? asset('storage/' . $photo) 
        : 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random&color=fff&size=128';
@endphp

<img src="{{ $src }}" 
     alt="{{ $name }}" 
     {{ $attributes->merge(['class' => 'rounded-full object-cover']) }} 
/>