<nav class="sticky top-0 z-50 bg-white dark:bg-gray-800/50" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- MOBILE: Burger or Back Button --}}
            <div class="flex items-center gap-3 md:hidden">
                @if(request()->routeIs('ormawa.show'))
                    {{-- Tombol Back (Sudah Berfungsi dengan native JS) --}}
                    <button onclick="window.history.back()" class="text-gray-700 text-lg hover:text-orange-500">
                        ←
                    </button>
                @else
                    {{-- Tombol Burger (Diperbaiki menggunakan Alpine.js) --}}
                    {{-- Saat diklik, nilai isOpen berubah jadi true/false --}}
                    <button @click="isOpen = !isOpen" class="text-gray-700 text-xl hover:text-orange-500 focus:outline-none">
                        <span x-show="!isOpen">☰</span>   {{-- Ikon Burger --}}
                        <span x-show="isOpen" x-cloak>✕</span>    {{-- Ikon Close (Opsional) --}}
                    </button>
                @endif
            </div>
        
            <div class="flex items-center">
                <div class="shrink-0">
                    <img src="{{ asset('images/logobem.png') }}" class="size-8">
                </div>

                @php
                    $isHome = Request::is('/'); 
                @endphp

                {{-- Menu Desktop (Hidden di Mobile) --}}
                <div class="hidden md:block ml-5 space-x-4">
                    <a href="{{ $isHome ? '#home' : url('/#home') }}" class="hover:text-orange-500 transition">Home</a>
                    <a href="{{ $isHome ? '#kalender' : url('/#kalender') }}" class="hover:text-orange-500 transition">Kalender</a>
                    <a href="{{ $isHome ? '#bem' : url('/#bem') }}" class="hover:text-orange-500 transition">BEM</a>
                    <a href="{{ $isHome ? '#news' : url('/#news') }}" class="hover:text-orange-500 transition">News</a>
                    <a href="{{ $isHome ? '#ukm' : url('/#ukm') }}" class="hover:text-orange-500 transition">UKM</a>
                    <a href="{{ $isHome ? '#tes-minat' : url('/#tes-minat') }}" class="hover:text-orange-500 transition">Tes Minat</a>
                </div>
            </div>

            <div class="flex items-center gap-4">
                {{-- LOGIN BUTTON --}}
                @guest
                    <button onclick="window.location.href='{{ route('login') }}'"
                        class="inline-block px-6 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600 transition">
                        LOGIN
                    </button>
                @endguest                    
            </div>
        </div>
    </div>

    {{-- MENU MOBILE (Akan muncul saat isOpen == true) --}}
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.away="isOpen = false"
         class="md:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg">
        
        <div class="space-y-1 px-4 py-4 pb-3 flex flex-col gap-2">
            <a href="{{ $isHome ? '#home' : url('/#home') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-orange-500 rounded-md">Home</a>
            <a href="{{ $isHome ? '#kalender' : url('/#kalender') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-orange-500 rounded-md">Kalender</a>
            <a href="{{ $isHome ? '#bem' : url('/#bem') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-orange-500 rounded-md">BEM</a>
            <a href="{{ $isHome ? '#news' : url('/#news') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-orange-500 rounded-md">News</a>
            <a href="{{ $isHome ? '#ukm' : url('/#ukm') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-orange-500 rounded-md">UKM</a>
            <a href="{{ $isHome ? '#tes-minat' : url('/#tes-minat') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 hover:text-orange-500 rounded-md">Tes Minat</a>
        </div>
    </div>
</nav>