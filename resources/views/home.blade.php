@extends('layouts.landing')

@section('content')
    {{-- SECTION HERO --}}
    <section id="home" class="relative w-full min-h-[500px] md:min-h-[600px]">
        <img src="/images/ith.jpg" class="absolute inset-0 w-full h-full object-cover" alt="ITH">
        <div class="absolute inset-0 bg-orange-500 opacity-40"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
            <h1 style="font-family:'Playfair Display', serif; -webkit-text-stroke:0.8px rgba(0,0,0,0.12);"
                class="text-3xl md:text-5xl lg:text-6xl font-extrabold leading-tight tracking-wide drop-shadow-2xl bg-clip-text text-transparent bg-gradient-to-r from-white/95 via-white/85 to-white/95">
                WELCOME<br>TO<br>SIMAWA
            </h1>
            <h2 style="font-family:'Poppins', sans-serif;"
                class="mt-4 text-base md:text-lg lg:text-xl text-white/95 font-semibold drop-shadow">
                <span class="block text-lg md:text-xl lg:text-2xl font-bold">Sistem Informasi Organisasi Mahasiswa</span>
                Institut Teknologi Bacharuddin Jusuf Habibie
            </h2>
        </div>
    </section>

    {{-- AREA KALENDER --}}
    <section id="kalender" class="bg-gray-50 px-4 md:px-8 py-10 min-h-screen scroll-mt-16">
        <div class="max-w-7xl mx-auto">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                {{-- KOLOM 1: KALENDER (Lebar 8) --}}
                <div class="lg:col-span-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 font-playfair">Kalender Kegiatan</h2>
                        <div class="flex items-center gap-3">
                            <button id="prevBtn" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-orange-100 text-gray-600 hover:text-orange-600 transition">&lsaquo;</button>
                            <span id="monthLabel" class="font-bold text-orange-500 min-w-[120px] text-center">
                                {{ date('F, Y') }}
                            </span>
                            <button id="nextBtn" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-orange-100 text-gray-600 hover:text-orange-600 transition">&rsaquo;</button>
                        </div>
                    </div>

                    {{-- Grid Hari --}}
                    <div class="grid grid-cols-7 gap-2 mb-4 text-center border-b pb-4">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Min</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sen</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sel</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rab</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kam</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jum</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sab</div>
                    </div>

                    {{-- Grid Tanggal --}}
                    <div id="calendarGrid" class="grid grid-cols-7 gap-2 text-center text-sm"></div>
                </div>

                {{-- KOLOM 2: SIDEBAR LIST (Lebar 4) --}}
                <div class="lg:col-span-4 space-y-6">
                    
                    {{-- Pencarian (Opsional untuk guest) --}}
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                        <div class="relative w-full">
                            <input type="text" id="searchInput" onkeyup="searchEvents()" placeholder="Cari Kegiatan..."
                                class="pl-10 pr-4 py-2.5 w-full text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-0 transition-colors">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21-5.2-5.2m0 0A7 7 0 1 0 5 5a7 7 0 0 0 10.8 10.8Z" /></svg>
                        </div>
                    </div>

                    {{-- WIDGET LIST KEGIATAN --}}
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 min-h-[300px]">
                        <div class="mb-4 border-b border-gray-100 pb-3">
                            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Kegiatan Tanggal</h3>
                            <p id="selectedDateLabel" class="text-lg font-bold text-gray-800 mt-1">
                                - Pilih Tanggal -
                            </p>
                        </div>

                        <div id="dailyEventsList" class="space-y-3">
                            {{-- State Awal --}}
                            <div class="text-center py-10 text-gray-400">
                                <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <p class="text-sm">Klik tanggal di kalender<br>untuk melihat daftar kegiatan.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    {{-- BEM --}}
    <section id="bem" class="bg-white px-4 md:px-10 py-12 min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto">
            <h2 class="modern-section-title text-center">Badan Eksekutif Mahasiswa</h2>
            <div class="modern-bem-container">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    <div class="modern-bem-logo w-36 h-36 flex items-center justify-center flex-shrink-0 p-4">
                        <a href="{{ route('ormawa.show', 'bem') }}" title="BEM" aria-label="Badan Eksekutif Mahasiswa"
                            class="w-full h-full flex items-center justify-center">
                            <img src="/images/logobem.png" alt="BEM Logo" class="w-full h-full object-contain">
                        </a>
                    </div>
                    <div class="flex-1">
                        <p class="modern-bem-description max-w-3xl text-center md:text-left">
                            Badan Eksekutif Mahasiswa hadir sebagai penggerak utama dinamika kampus. Melalui nilai-nilai
                            kepemimpinan, integritas, dan pelayanan, BEM berupaya memberikan ruang bagi mahasiswa untuk tumbuh,
                            memimpin, dan berkontribusi secara nyata.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- NEWS --}}
    <section id="news" class="py-12 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-8">Berita Terbaru</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($beritas as $item)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden border">
                    <img src="{{ asset('storage/' . $item->gambar) }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-lg">{{ $item->judul_berita }}</h3>
                        <p class="text-gray-600 text-sm mt-2">
                            {{-- Memotong teks jadi 20 kata --}}
                            {{ \Illuminate\Support\Str::words(strip_tags($item->konten), 20, '...') }}
                        </p>
                        <a href="{{ route('berita.show', $item->id_berita) }}" class="text-orange-500 text-sm font-bold mt-4 inline-block">Baca Selengkapnya →</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- DAFTAR UKM --}}
    <section id="ukm" class="scroll-mt-16 bg-gradient-to-br from-orange-50 to-orange-100 px-4 md:px-10 py-12 min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto">
            <h2 class="modern-section-title text-center uppercase">Daftar UKM/SC</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($ormawas->where('tipe', 'ukm') as $item)
                    <div class="modern-ukm-card">
                        <div class="modern-ukm-logo-container">
                            <a href="{{ route('ormawa.show', $item->slug) }}" class="w-full h-full flex items-center justify-center">
                                <img src="{{ asset($item->logo) }}" alt="{{ $item->nama }}" class="max-h-full max-w-full object-contain">
                            </a>
                        </div>
                        <div class="modern-ukm-name">
                            {{ strtoupper($item->nama) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TES MINAT --}}
        <section 
        id="tes-minat" 
        class="min-h-screen flex items-center justify-center 
            bg-gradient-to-br from-orange-50 to-orange-100 px-4">
        <div class="text-center max-w-xl">
            <h2 class="text-2xl md:text-3xl font-extrabold uppercase tracking-widest text-gray-800 mb-4">
                Tes Minat
            </h2>
            <p class="text-gray-600 mb-10">
                Temukan UKM yang paling sesuai dengan minat dan bakatmu
            </p>
            <a href="{{ url('tesminat') }}"
            class="inline-block bg-orange-500 text-white 
                    px-6 py-2.5 rounded-full text-lg font-semibold
                    shadow-lg hover:bg-orange-600 hover:scale-105 
                    transition">
                Ayo Mulai Tes
            </a>
        </div>
        </section>
        @include('components.home-modals')
    
@endsection

@push('scripts')
    @include('components.home-scripts')
@endpush
