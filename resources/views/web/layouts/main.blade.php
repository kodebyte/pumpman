<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Aiwa Indonesia') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-brand antialiased text-gray-900 bg-white selection:bg-aiwaRed selection:text-white">

    @include('web.layouts.partials.navbar')

    <main>
        {{ $slot }}
    </main>

    {{-- @include('layouts.partials.footer') --}}

    @stack('scripts')
</body>
</html>