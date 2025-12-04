<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIMAWA ITH</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- NAVBAR ATAS (selalu ada) --}}
    @include('components.navbar')

    <div class="flex pt-16 min-h-[calc(100vh-4rem)]">
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
