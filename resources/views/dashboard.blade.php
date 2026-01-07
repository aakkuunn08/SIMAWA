@extends('layouts.main')

@section('content')

    {{-- 1. SECTION BANNER (Full Screen) --}}
    <section class="relative w-full h-screen flex items-center justify-center overflow-hidden">
        <img src="/images/ith.jpg" class="absolute inset-0 w-full h-full object-cover" alt="ITH">
        <div class="absolute inset-0 bg-orange-500 opacity-40"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 z-10">
            <h1 style="font-family:'Playfair Display', serif; -webkit-text-stroke:0.8px rgba(0,0,0,0.12);"
                class="text-4xl md:text-6xl lg:text-7xl font-extrabold leading-tight tracking-wide drop-shadow-2xl bg-clip-text text-transparent bg-gradient-to-r from-white/95 via-white/85 to-white/95">
                WELCOME<br>TO<br>SIMAWA
            </h1>
            <h2 style="font-family:'Poppins', sans-serif;"
                class="mt-4 text-lg md:text-xl lg:text-2xl text-white/95 font-semibold drop-shadow">
                <span class="block text-xl md:text-2xl lg:text-3xl font-bold">Sistem Informasi Organisasi Mahasiswa</span>
                Institut Teknologi Bacharuddin Jusuf Habibie
            </h2>
        </div>
    </section>

    {{-- 2. AREA KALENDER --}}
    <section id="kalender" class="bg-orange-50 px-4 md:px-8 min-h-screen flex flex-col justify-center scroll-mt-10">
        <div class="max-w-7xl mx-auto w-full py-10">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                {{-- KOLOM 1: KALENDER --}}
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

                    <div class="grid grid-cols-7 gap-2 mb-4 text-center border-b pb-4">
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Min</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sen</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sel</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Rab</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kam</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jum</div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sab</div>
                    </div>

                    <div id="calendarGrid" class="grid grid-cols-7 gap-2 text-center text-sm"></div>
                </div>

                {{-- KOLOM 2: SIDEBAR --}}
                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                        <div class="relative w-full mb-4">
                            <input type="text" id="searchInput" onkeyup="searchEvents()" placeholder="Cari Kegiatan..."
                                 class="pl-10 pr-4 py-2.5 w-full text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-0 transition-colors">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        
                        @auth
                            @if(auth()->user()->hasAnyRole(['adminbem','adminukm']))
                            <button onclick="openAddModal()" class="w-full py-2.5 bg-pink-500 hover:bg-pink-600 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-orange-200">
                                + Tambah Kegiatan Baru
                            </button>
                            @endif
                        @endauth
                    </div>

                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 min-h-[300px]">
                        <div class="mb-4 border-b border-gray-100 pb-3">
                            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Kegiatan Tanggal</h3>
                            <p id="selectedDateLabel" class="text-lg font-bold text-gray-800 mt-1">
                                - Pilih Tanggal -
                            </p>
                        </div>
                        <div id="dailyEventsList" class="space-y-3">
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

    {{-- 3. LPJ --}}
    <section id="lpj" class="bg-white px-4 md:px-8 min-h-screen flex flex-col justify-center scroll-mt-0">
        <div class="max-w-7xl mx-auto w-full py-10">
            <div class="flex items-center justify-between mb-8 px-1">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 flex items-center">
                        <span class="bg-orange-100 text-orange-600 p-2 rounded-lg mr-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 01-2-2V7a2 2 0 012-2h4l2 2h4a2 2 0 012 2v1M5 19h14a2 2 0 002-2v-5a2 2 0 00-2-2H9a2 2 0 00-2 2v5a2 2 0 01-2 2z"></path></svg>
                        </span>
                        Status Laporan Pertanggungjawaban
                    </h3>
                    <p class="text-gray-500 mt-2 ml-14">Pantau status dokumen kegiatan organisasi terbaru</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                                <th class="px-6 py-4">Nama Kegiatan</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-right">Tanggal Upload</th>
                                <th class="px-6 py-4 text-center">Download</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($lpjTerbaru as $lpj)
                            <tr class="group hover:bg-orange-50/30 transition duration-150 ease-in-out">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center mr-3 group-hover:bg-white group-hover:shadow-sm transition">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-orange-600 transition">
                                                {{ $lpj->kegiatan->nama_kegiatan ?? 'Nama Kegiatan Hilang' }}
                                            </div>
                                            <div class="text-xs text-gray-500 flex items-center mt-0.5">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                {{ $lpj->kegiatan->tempat ?? 'Tempat tidak diketahui' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php $status = $lpj->status_lpj; @endphp
                                    @if($status == 'disetujui' || $status == 'Diterima' || $status == 'approved')
                                        <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span> Diterima
                                        </span>
                                    @elseif($status == 'revisi' || $status == 'Revisi' || $status == 'rejected')
                                        <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-red-100 text-red-800 border border-red-200 shadow-sm">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-2"></span> Revisi
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full animate-pulse mr-2"></span> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-700">{{ $lpj->created_at->format('d M Y') }}</div>
                                    <div class="text-xs text-gray-400">{{ $lpj->created_at->format('H:i') }} WITA</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('kegiatan.download_lpj', $lpj->id_kegiatan) }}" 
                                    class="text-gray-400 hover:text-blue-600 transition p-2 hover:bg-blue-50 rounded-full inline-block" 
                                    title="Download Dokumen">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-100 p-4 rounded-full mb-3">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <h4 class="text-gray-900 font-medium mb-1">Tidak ada LPJ Baru</h4>
                                        <p class="text-sm text-gray-500">Belum ada dokumen yang diupload belakangan ini.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex justify-between items-center">
                    <span class="text-xs text-gray-500 font-medium">5 Dokumen Terakhir</span>
                    <a href="{{ route('lpj') }}" class="text-xs text-orange-500 hover:text-orange-700 font-bold hover:underline">
                        Lihat Arsip Lengkap &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. BEM --}}
    <section id="bem" class="bg-orange-50 px-4 md:px-8 min-h-screen flex items-center justify-center scroll-mt-0">
        <div class="max-w-6xl mx-auto w-full">
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-10 tracking-wide uppercase">Badan Eksekutif Mahasiswa</h2>
            <div class="modern-bem-container">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    <div class="modern-bem-logo  w-36 h-36 flex items-center justify-center flex-shrink-0 p-4">
                        <a href="{{ route('ormawa.show', 'bem') }}" title="BEM"
                            class="w-full h-full items-center justify-center block">
                            <img src="/images/logobem.png" alt="BEM Logo" class="w-full h-full object-contain">
                        </a>
                    </div>
                    <div class="flex-1">
                        <p class="modern-bem-description max-w-3xl text-center md:text-left">
                            Badan Eksekutif Mahasiswa hadir sebagai penggerak utama dinamika kampus...
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. NEWS --}}
    <section id="news" class="bg-white px-4 md:px-8 min-h-screen flex flex-col justify-center scroll-mt-10">
        <div class="max-w-7xl mx-auto w-full py-10">
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-10 tracking-wide uppercase">News</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($beritas as $item)
                    <article class="modern-news-card relative group">
                        <a href="{{ route('berita.show', $item->id_berita) }}" class="flex flex-col h-full">
                            <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://via.placeholder.com/350' }}" 
                                 class="w-full h-48 object-cover">
                            <div class="p-5 flex flex-col flex-1">
                                <p class="font-bold text-gray-800 line-clamp-2 text-lg mb-2 group-hover:text-orange-600 transition">
                                    {{ $item->judul_berita }}
                                </p>
                                <p class="text-sm text-gray-600 mt-2 line-clamp-3 flex-1">
                                    {{ \Illuminate\Support\Str::words(strip_tags($item->konten), 20, '...') }}
                                </p>
                                <p class="text-[10px] text-gray-400 mt-3 italic">Oleh: {{ $item->user->name ?? 'Admin' }}</p>
                            </div>
                        </a>

                        @auth
                            @can('update', $item)
                            <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2 z-10">
                                <button onclick="editBerita('{{ $item->id_berita }}')" 
                                        class="bg-orange-500 text-white p-2 rounded-full shadow-lg hover:bg-orange-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <button type="button" 
                                        onclick="openDeleteModalBerita('{{ route('berita.destroy', $item->id_berita) }}')" 
                                        class="bg-red-500 text-white p-2 rounded-full shadow-lg hover:bg-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </div>
                            @endcan
                        @endauth
                    </article>
                @endforeach
            </div>

            @auth
                @if(auth()->user()->hasAnyRole(['adminbem','adminukm']))
                    <div class="flex justify-end mt-6">
                    <button onclick="openModalBerita()" class="px-6 py-2 bg-orange-500 text-white font-semibold rounded-lg hover:bg-orange-600 transition shadow-sm">
                        + Tambah Berita
                    </button>
                    </div>
                @endif
            @endauth
        </div>
    </section>

    {{-- 6. DAFTAR UKM --}}
    <section id="ukm" class="bg-orange-50 px-4 md:px-8 min-h-screen flex items-center justify-center scroll-mt-0">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-center text-3xl font-bold text-gray-800 mb-10 tracking-wide uppercase">Daftar UKM/SC</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($ormawas->filter(fn($ormawa) => optional($ormawa->tipe)->nama_tipe !== 'BEM (Badan Eksekutif Mahasiswa)') as $item)
                    <div class="modern-ukm-card">
                        <div class="modern-ukm-logo-container">
                            <a href="{{ route('ormawa.show', $item->slug) }}" class="w-full h-full flex items-center justify-center">
                                <img src="{{ asset($item->logo) }}" alt="{{ $item->nama }}" class="max-h-full max-w-full object-contain">
                            </a>
                        </div>
                        <div class="modern-ukm-name">{{ strtoupper($item->nama) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- 7. TES MINAT --}}
    @if(auth()->guest() || !auth()->user()->hasRole('adminukm'))
        <section id="tes-minat" class="bg-white min-h-screen flex items-center justify-center px-4 md:px-8">
            <div class="text-center max-w-xl">
                <h2 class="text-2xl md:text-3xl font-extrabold uppercase tracking-widest text-gray-800 mb-4">
                    Tes Minat
                </h2>
                <p class="text-gray-600 mb-10">
                    Kelola Pertanyaan dan Hasil Tes Minat Mahasiswa
                </p>
                <a href="{{ route('tesminatbem.menu') }}"
                class="inline-block bg-orange-500 text-white px-8 py-3 rounded-full text-lg font-semibold shadow-lg hover:bg-orange-600 hover:scale-105 transition">
                    Kelola Tes Minat
                </a>
            </div>
        </section>
    @endif

    @include('components.dashboard-modals')

@endsection

@push('scripts')
    @include('components.dashboard-scripts')
@endpush