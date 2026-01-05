{{-- File: resources/views/components/sidebar.blade.php --}}
<aside id="sidebar-menu"
       class="hidden md:flex fixed top-0 left-0 w-64 h-screen bg-white border-r border-gray-200 flex flex-col z-40">

    {{-- Header kecil di sidebar --}}
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <span class="font-semibold text-sm tracking-wide">SIMAWA ITH</span>
    </div>
    
{{-- LOGIC PHP UNTUK MENENTUKAN MENU AKTIF --}}
    @php
        // 1. Cek Halaman Utama dan Dashboard
        $isHome = Request::routeIs('home') || Request::is('/'); 
        $isDashboard = Request::routeIs('dashboard');
        
        // 2. Cek apakah sedang di halaman Ormawa (apapun slugnya)
        $isOrmawaPage = Request::routeIs('ormawa*'); 

        // 3. Ambil Slug dari URL untuk membedakan BEM vs UKM lain
        // Jika URL: domain.com/ormawa/bem, maka segment(2) adalah 'bem'
        $currentSlug = request()->segment(2); 

        // 4. Cek halaman Akun dan Panduan
        $isAccountPage = Request::routeIs('adminbem.accounts*') || Request::routeIs('profile*');
        $isPanduanPage = Request::is('panduan') || Request::is('panduan/*');

        // 5. Cek halaman Tes Minat (untuk highlighting)
        $isTesMinatPage = Request::routeIs('tesminatbem*') || Request::routeIs('tesminat*');

        // 6. Style Class (Sesuai request warna oranye sebelumnya)
        $activeClass = 'border-l-4 border-orange-500 bg-orange-50 text-gray-900 font-medium'; 
        $inactiveClass = 'border-l-4 border-transparent hover:bg-gray-100 text-gray-600';

        // 7. LOGIKA KUNCI:
        // Menu BEM aktif JIKA halaman ormawa DAN slug-nya 'bem'
        $isBemActive = $isOrmawaPage && $currentSlug == 'bem';

        // Menu UKM aktif JIKA halaman ormawa TAPI slug-nya BUKAN 'bem'
        $isUkmActive = $isOrmawaPage && $currentSlug != 'bem';
    @endphp

    <nav class="flex-1 pt-4 text-sm overflow-y-auto" id="nav-container">
        
        {{-- Kalender --}}
        {{-- LOGIKA BARU: Cek apakah URL adalah '/' (Home) ATAU 'dashboard' --}}
        <a href="{{ url('/dashboard#kalender') }}" 
        class="nav-link flex items-center px-6 py-2 {{ $inactiveClass }}">
            Kalender Kegiatan
        </a>
        
        {{-- LPJ --}}
        <a href="{{ url('/dashboard#lpj') }}" 
        class="nav-link flex items-center px-6 py-2 {{ $isBemActive ? $activeClass : $inactiveClass }}">
            LPJ
        </a>

        {{-- MENU BEM --}}
        <a href="{{ url('/dashboard#bem') }}" 
        class="nav-link flex items-center px-6 py-2 {{ $isBemActive ? $activeClass : $inactiveClass }}">
            Badan Eksekutif Mahasiswa
        </a>

        {{-- NEWS --}}
        <a href="{{ url('/dashboard#news') }}" 
        class="nav-link flex items-center px-6 py-2 {{ $inactiveClass }}">
            NEWS
        </a>      

        {{-- MENU UKM --}}
        <a href="{{ url('/dashboard#ukm') }}" 
        class="nav-link flex items-center px-6 py-2 {{ $isUkmActive ? $activeClass : $inactiveClass }}">
            Daftar UKM/SC
        </a>

        {{-- Tes Minat --}}
        @if(auth()->guest() || !auth()->user()->hasRole('adminukm'))
            <a href="{{ url('/dashboard#tes-minat') }}" 
                class="nav-link flex items-center px-6 py-2 {{ $inactiveClass }}">
                Tes Minat
            </a>
        @endif
    </nav>

    {{-- AREA KHUSUS LOGGED IN USER - DI BAWAH --}}
    @auth
        <div class="border-t border-gray-200 text-sm">
            @if(auth()->user()->hasRole('adminbem'))
                {{-- AdminBEM sees Account Management --}}
                <a href="{{ route('adminbem.accounts.index') }}" 
                   class="nav-link no-highlight flex items-center px-6 py-2 {{ $isAccountPage ? $activeClass : $inactiveClass }}">
                    Akun
                </a>
            @endif
            
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit"
                        class="nav-link no-highlight flex w-full items-center px-6 py-2 hover:bg-gray-100 text-gray-700">
                    Logout
                </button>
            </form>
        </div>
    @endauth
</aside>
