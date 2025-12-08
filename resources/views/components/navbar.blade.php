<header class="fixed top-0 left-0 right-0 md:left-64 md:w-[calc(100%-16rem)] 
               h-16 bg-white shadow-sm flex items-center justify-between 
               px-6 z-50 transition-all">

    {{-- MOBILE: Burger or Back Button --}}
    <div class="flex items-center gap-3 md:hidden">
        @if(request()->routeIs('ormawa.show'))
            <button onclick="window.history.back()" class="text-gray-700 text-lg hover:text-orange-500">←</button>
        @else
            <button onclick="toggleSidebar()" class="text-gray-700 text-xl hover:text-orange-500">☰</button>
        @endif
    </div>

    {{-- TITLE --}}
    <div class="font-medium text-sm md:text-base">
        @guest
            Selamat Datang di SIMAWA
        @else
            @if(auth()->user()->hasRole('adminbem'))
                Dashboard Admin BEM
            @else
                Dashboard Admin UKM
            @endif 
        @endguest
    </div>

    {{-- LOGIN BUTTON --}}
    @guest
        <button onclick="window.location.href='{{ route('login') }}'"
            class="inline-block px-6 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600 transition">
            LOGIN
        </button>
    @endguest
</header>

<script>
    function toggleSidebar() {
        let sb = document.getElementById('sidebar-menu');
        if (sb) sb.classList.toggle('hidden');
    }
</script>
