<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMAWA ITH</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Modern Dashboard CSS --}}
    <link rel="stylesheet" href="{{ asset('css/modern-dashboard.css') }}">
    
    {{-- Google Fonts for Better Typography --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100">

    {{-- NAVBAR ATAS (selalu ada) --}}
    @include('components.navbar')

    <div class="flex pt-16">
        @include('components.sidebar')

        <main class="flex-1 ml-0 md:ml-64">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
        {{-- SCRIPT DARI @push('scripts') (dipakai di home.blade untuk kalender dll) --}}
    @stack('scripts')
</body>
</html>
