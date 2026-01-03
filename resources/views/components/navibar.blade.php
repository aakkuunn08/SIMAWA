<nav class="sticky top-0 z-50 bg-white dark:bg-gray-800/50" x-data="{ isOpen: false }">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">

            {{-- MOBILE: Burger or Back Button --}}
            <div class="flex items-center gap-3 md:hidden">
                @if(request()->routeIs('ormawa.show'))
                    <button onclick="window.history.back()" class="text-gray-700 text-lg hover:text-orange-500">←</button>
                @else
                    <button onclick="toggleSidebar()" class="text-gray-700 text-xl hover:text-orange-500">☰</button>
                @endif
            </div>
        
            <!-- Left nav -->
            <div class="flex items-center">
                <div class="shrink-0">
                    <img src="{{ asset('images/logobem.png') }}" class="size-8">
                </div>

                @php
                    // Cek apakah kita sedang berada di halaman utama (Home)
                    $isHome = Request::is('/'); 
                @endphp

                <div class="hidden md:block ml-5 space-x-4">
                    <a href="{{ $isHome ? '#home' : url('/#home') }}">Home</a>
                    <a href="{{ $isHome ? '#kalender' : url('/#kalender') }}">Kalender</a>
                    <a href="{{ $isHome ? '#bem' : url('/#bem') }}">BEM</a>
                    <a href="{{ $isHome ? '#news' : url('/#news') }}">News</a>
                    <a href="{{ $isHome ? '#ukm' : url('/#ukm') }}">UKM</a>
                    <a href="{{ $isHome ? '#tes-minat' : url('/#tes-minat') }}">Tes Minat</a>
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
</nav>
