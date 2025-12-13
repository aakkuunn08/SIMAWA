{{-- File: resources/views/components/sidebar.blade.php --}}
<aside id="sidebar-menu"
       class="hidden md:flex fixed top-0 left-0 w-64 h-screen bg-white border-r border-gray-200 flex flex-col z-40">

    {{-- Header kecil di sidebar --}}
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <span class="font-semibold text-sm tracking-wide">SIMAWA ITH</span>
    </div>
    
{{-- LOGIC PHP UNTUK MENENTUKAN MENU AKTIF --}}
    @php
        // 1. Cek Halaman Utama
        $isHome = Request::routeIs('home') || Request::is('/'); 
        
        // 2. Cek apakah sedang di halaman Ormawa (apapun slugnya)
        $isOrmawaPage = Request::routeIs('ormawa*'); 

        // 3. Ambil Slug dari URL untuk membedakan BEM vs UKM lain
        // Jika URL: domain.com/ormawa/bem, maka segment(2) adalah 'bem'
        $currentSlug = request()->segment(2); 

        // 4. Cek halaman Akun dan Panduan
        $isAccountPage = Request::routeIs('adminbem.accounts*') || Request::routeIs('profile*');
        $isPanduanPage = Request::is('panduan') || Request::is('panduan/*');

        // 5. Style Class (Sesuai request warna oranye sebelumnya)
        $activeClass = 'border-l-4 border-orange-500 bg-orange-50 text-gray-900 font-medium'; 
        $inactiveClass = 'border-l-4 border-transparent hover:bg-gray-100 text-gray-600';

        // 6. LOGIKA KUNCI:
        // Menu BEM aktif JIKA halaman ormawa DAN slug-nya 'bem'
        $isBemActive = $isOrmawaPage && $currentSlug == 'bem';

        // Menu UKM aktif JIKA halaman ormawa TAPI slug-nya BUKAN 'bem'
        $isUkmActive = $isOrmawaPage && $currentSlug != 'bem';
    @endphp

    <nav class="flex-1 pt-4 text-sm overflow-y-auto" id="nav-container">
        
        {{-- Kalender --}}
        <a href="{{ $isHome ? '#kalender' : url('/#kalender') }}" 
           class="nav-link flex items-center px-6 py-2 {{ $inactiveClass }}">
            Kalender Kegiatan
        </a>

        {{-- MENU BEM (Hanya nyala jika slug == bem) --}}
        <a href="{{ $isHome ? '#bem' : url('/#bem') }}" 
           class="nav-link flex items-center px-6 py-2 {{ $isBemActive ? $activeClass : $inactiveClass }}">
            Badan Eksekutif Mahasiswa
        </a>

        {{-- NEWS --}}
        <a href="{{ $isHome ? '#news' : url('/#news') }}" 
           class="nav-link flex items-center px-6 py-2 {{ $inactiveClass }}">
            NEWS
        </a>

        {{-- MENU UKM (Nyala jika slug != bem, misal: hero, hcc, seni, olahraga) --}}
        <a href="{{ $isHome ? '#ukm' : url('/#ukm') }}" 
           class="nav-link flex items-center px-6 py-2 {{ $isUkmActive ? $activeClass : $inactiveClass }}">
            Daftar UKM/SC
        </a>

        {{-- Tes Minat --}}
        @auth
            @if(auth()->user()->hasRole('adminbem'))
                {{-- Admin BEM: Jika di dashboard/home gunakan anchor, jika tidak langsung ke menu --}}
                <a href="{{ $isHome ? '#tes-minat' : route('tesminatbem.menu') }}" 
                   class="nav-link flex items-center px-6 py-2 {{ Request::routeIs('tesminatbem*') ? $activeClass : $inactiveClass }}">
                    Tes Minat
                </a>
            @else
                {{-- User biasa: Jika di home gunakan anchor, jika tidak ke halaman tes minat --}}
                <a href="{{ $isHome ? '#tes-minat' : route('tesminat.index') }}" 
                   class="nav-link flex items-center px-6 py-2 {{ Request::routeIs('tesminat*') ? $activeClass : $inactiveClass }}">
                    Tes Minat
                </a>
            @endif
        @else
            {{-- Guest: Jika di home gunakan anchor, jika tidak ke halaman tes minat --}}
            <a href="{{ $isHome ? '#tes-minat' : route('tesminat.index') }}" 
               class="nav-link flex items-center px-6 py-2 {{ Request::routeIs('tesminat*') ? $activeClass : $inactiveClass }}">
                Tes Minat
            </a>
        @endauth
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
            @else
                {{-- Other users see Profile --}}
                <a href="{{ route('profile.edit') }}" 
                   class="nav-link no-highlight flex items-center px-6 py-2 {{ $isAccountPage ? $activeClass : $inactiveClass }}">
                    Akun
                </a>
            @endif
            
            <a href="{{ url('/panduan') }}" 
               class="nav-link no-highlight flex items-center px-6 py-2 {{ $isPanduanPage ? $activeClass : $inactiveClass }}">
                Panduan
            </a>

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
