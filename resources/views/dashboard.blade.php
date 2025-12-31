@extends('layouts.main')

@section('content')
    {{-- SECTION BANNER --}}
    <section class="relative w-full min-h-[500px] md:min-h-[600px]">
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

    {{-- AREA KALENDER UTAMA + SIDEBAR --}}
    <section id="kalender" class="bg-gray-50 px-4 md:px-8 py-10 min-h-screen scroll-mt-16">
        <div class="max-w-7xl mx-auto">
            
            {{-- GRID LAYOUT: Kiri Kalender, Kanan Sidebar --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                {{-- KOLOM 1: KALENDER (Lebar 8 kolom dari 12) --}}
                <div class="lg:col-span-8 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    {{-- Header Kalender di dalam Card --}}
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 font-playfair">Kalender Kegiatan</h2>
                        {{-- Tombol Navigasi Bulan Pindah Sini Biar Rapi --}}
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

                    {{-- Grid Tanggal (Isi Kalender) --}}
                    <div id="calendarGrid" class="grid grid-cols-7 gap-2 text-center text-sm"></div>
                </div>

                {{-- KOLOM 2: SIDEBAR INFORMASI (Lebar 4 kolom dari 12) --}}
                <div class="lg:col-span-4 space-y-6">
                    
                    {{-- WIDGET 1: PENCARIAN & TAMBAH --}}
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                        <div class="relative w-full mb-4">
                            <input type="text" placeholder="Cari Kegiatan..."
                                class="pl-10 pr-4 py-2.5 w-full text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-0 transition-colors">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21-5.2-5.2m0 0A7 7 0 1 0 5 5a7 7 0 0 0 10.8 10.8Z" /></svg>
                        </div>
                        
                        @auth
                            @if(auth()->user()->hasAnyRole(['adminbem','adminukm']))
                            <button onclick="openAddModal()" class="w-full py-2.5 bg-orange-500 hover:bg-orange-600 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-orange-200">
                                + Tambah Kegiatan Baru
                            </button>
                            @endif
                        @endauth
                    </div>

                    {{-- WIDGET 2: LIST KEGIATAN PER TANGGAL (PENGGANTI DETAIL) --}}
                    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 min-h-[300px]">
                        {{-- Judul Tanggal yang dipilih --}}
                        <div class="mb-4 border-b border-gray-100 pb-3">
                            <h3 class="text-gray-500 text-xs font-bold uppercase tracking-wider">Kegiatan Tanggal</h3>
                            <p id="selectedDateLabel" class="text-lg font-bold text-gray-800 mt-1">
                                - Pilih Tanggal -
                            </p>
                        </div>

                        {{-- Container List --}}
                        <div id="dailyEventsList" class="space-y-3">
                            {{-- State Awal: Kosong --}}
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

    {{-- MODAL INPUT/EDIT KEGIATAN --}}
    @auth
        @if(auth()->user()->hasAnyRole(['adminbem','adminukm']))
        <div id="addModal" class="modern-modal-overlay hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="modern-modal bg-white max-w-md w-full">
                {{-- Header --}}
                <div class="modern-modal-header flex justify-between items-center">
                    <h3 id="modalTitle" class="modern-modal-title">Input Kegiatan</h3>
                    <button onclick="closeAddModal()" class="modern-modal-close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                {{-- Edit Mode Indicator --}}
                <div id="editModeIndicator" class="hidden px-6 py-3 bg-blue-50 border-l-4 border-blue-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Mode Edit</p>
                            <p class="text-xs text-blue-600">Ubah data yang ingin Anda edit, field lainnya akan tetap sama</p>
                        </div>
                    </div>
                </div>
                
                {{-- Form --}}
                <form id="kegiatanForm" class="modern-modal-body space-y-5">
                    @csrf
                    <input type="hidden" id="kegiatan_id" name="kegiatan_id">
                    
                    {{-- Jadwal (Tanggal) --}}
                    <div class="flex items-start gap-4">
                        <div class="modern-form-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <label class="modern-label">Jadwal</label>
                            <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" required
                                class="modern-input">
                        </div>
                    </div>

                    {{-- Waktu --}}
                    <div class="flex items-start gap-4">
                        <div class="modern-form-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1 grid grid-cols-2 gap-3">
                            <div>
                                <label class="modern-label text-xs">Waktu Mulai</label>
                                <input type="time" id="waktu_mulai" name="waktu_mulai" required
                                    class="modern-input">
                            </div>
                            <div>
                                <label class="modern-label text-xs">Waktu Selesai</label>
                                <input type="time" id="waktu_selesai" name="waktu_selesai" required
                                    class="modern-input">
                            </div>
                        </div>
                    </div>

                    {{-- Kegiatan --}}
                    <div class="flex items-start gap-4">
                        <div class="modern-form-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <label class="modern-label">Kegiatan</label>
                            <input type="text" id="nama_kegiatan" name="nama_kegiatan" required
                                placeholder="Nama kegiatan"
                                class="modern-input">
                        </div>
                    </div>

                    {{-- Tempat --}}
                    <div class="flex items-start gap-4">
                        <div class="modern-form-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <label class="modern-label">Tempat</label>
                            <input type="text" id="tempat" name="tempat" required
                                placeholder="Lokasi kegiatan"
                                class="modern-input">
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-3 pt-4">
                        <button type="button" onclick="closeAddModal()" 
                            class="modern-btn modern-btn-secondary">
                            Batal
                        </button>
                        <button type="submit" 
                            class="modern-btn modern-btn-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    {{-- CUSTOM ALERT MODAL FOR KATALON --}}
        <div id="customAlertModal" class="modern-modal-overlay hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-2xl max-w-md w-full transform transition-all">
                <div class="p-6">
                    {{-- Icon Container --}}
                    <div class="flex justify-center mb-4">
                        <div id="alertIcon" class="w-16 h-16 rounded-full flex items-center justify-center">
                            {{-- Icon will be inserted by JavaScript --}}
                        </div>
                    </div>
                    
                    {{-- Title --}}
                    <h3 id="alertTitle" class="text-xl font-bold text-center mb-2 text-gray-800"></h3>
                    
                    {{-- Message --}}
                    <p id="alertMessage" class="text-center text-gray-600 mb-6"></p>
                    
                    {{-- Buttons --}}
                    <div id="alertButtons" class="flex justify-center gap-3">
                        <button id="alertCancelBtn" class="hidden px-6 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors">
                            Batal
                        </button>
                        <button id="alertOkBtn" class="px-6 py-2 rounded-lg font-semibold transition-colors">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>

    {{-- MODAL DETAIL KEGIATAN --}}
        <div id="detailModal" class="modern-modal-overlay hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="modern-modal bg-white max-w-md w-full">
                {{-- Header --}}
                <div class="modern-modal-header flex justify-between items-center">
                    <h3 id="detailTitle" class="modern-modal-title">Detail Kegiatan</h3>
                    <button onclick="closeDetailModal()" class="modern-modal-close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                {{-- Content --}}
                <div class="modern-modal-body space-y-5">
                    {{-- Jadwal --}}
                    <div class="flex items-start gap-4">
                        <div class="modern-form-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Jadwal</p>
                            <p id="detailJadwal" class="text-sm text-gray-800 font-medium"></p>
                        </div>
                    </div>

                    {{-- Kegiatan --}}
                    <div class="flex items-start gap-4">
                        <div class="modern-form-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Kegiatan</p>
                            <p id="detailKegiatan" class="text-sm text-gray-800"></p>
                        </div>
                    </div>

                    {{-- Tempat --}}
                    <div class="flex items-start gap-4">
                        <div class="modern-form-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Tempat</p>
                            <p id="detailTempat" class="text-sm text-gray-800"></p>
                        </div>
                    </div>
                    
                    {{-- INFO PENGINPUT --}}
                    <div class="flex items-start gap-4">
                        <div class="modern-form-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Diinput Oleh</p>
                            <p id="detailPenginput" class="text-sm text-gray-800 font-medium">-</p>
                        </div>
                    </div>

                    <!-- UPLOAD LPJ -->
                    <div class="pt-4 mt-2 border-t border-gray-100">
                        <label class="text-xs font-bold text-gray-700 mb-2 block">Dokumen LPJ</label>
                        
                        {{-- Form Upload --}}
                        <form id="formUploadLPJ" class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <input type="file" id="file_lpj" name="file_lpj" accept=".pdf,.doc,.docx"
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-xs file:font-semibold
                                    file:bg-orange-50 file:text-orange-700
                                    hover:file:bg-orange-100 cursor-pointer">
                                
                                <button type="button" onclick="uploadFileLpj()" id="btnSubmitLpj" class="px-3 py-2 bg-orange-500 text-white text-xs font-semibold rounded-lg hover:bg-orange-600 transition shadow-sm">
                                    Upload
                                </button>
                            </div>
                            <small class="text-gray-400 text-[10px]">Format: PDF/Docx. Maks 2MB.</small>
                        </form>

                        {{-- Tampilan jika file sudah ada (Diatur via JS) --}}
                        <div id="existingLpjAlert" class="hidden mt-2 p-2 bg-green-50 border border-green-200 rounded-md flex justify-between items-center">
                            <a id="linkLpj" href="#" target="_blank" class="text-xs text-green-700 hover:underline flex items-center gap-1 font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Lihat File LPJ Terupload
                            </a>
                        </div>
                    </div>

                    {{-- Buttons (Only for Admin) --}}
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" id="btnTutupDetail" onclick="closeDetailModal()" 
                            class="modern-btn modern-btn-secondary">
                            Tutup
                        </button>
                        <button type="button" id="btnEditKegiatan" onclick="editKegiatan()" 
                            class="modern-btn modern-btn-success">
                            Edit
                        </button>
                        <button type="button" id="btnHapusKegiatan" onclick="deleteKegiatan()" 
                            class="modern-btn modern-btn-danger">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endauth

    {{-- BEM --}}
    <section id="bem" class="bg-white px-4 md:px-10 py-12 min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto">
            <h2 class="modern-section-title text-center">Badan Eksekutif Mahasiswa</h2>
            <div class="modern-bem-container">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                    <div class="modern-bem-logo w-36 h-36 flex items-center justify-center flex-shrink-0 p-4">
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

    {{-- NEWS --}}
    <section id="news" class="bg-gradient-to-br from-gray-50 to-white px-4 md:px-10 py-12 min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto">
            <h2 class="modern-section-title text-center uppercase">News</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Contoh Berita --}}
                <article class="modern-news-card">
                    <img src="https://via.placeholder.com/350x180?text=News+1" class="modern-news-image" alt="News 1">
                    <div class="modern-news-content">
                        <p class="modern-news-title">Mitraindonesia, Parepare – Habibie Robotic Competition (HRC) 2025...</p>
                        <p class="modern-news-description">Kegiatan tahunan Unit Kegiatan Mahasiswa...</p>
                    </div>
                </article>
                <article class="modern-news-card">
                    <img src="https://via.placeholder.com/350x180?text=News+2" class="modern-news-image" alt="News 2">
                    <div class="modern-news-content">
                        <p class="modern-news-title">Parepare, 29/05/2025 – ITH Futsal Cup resmi bergulir...</p>
                        <p class="modern-news-description">Turnamen futsal antar program studi...</p>
                    </div>
                </article>
                <article class="modern-news-card">
                    <img src="https://via.placeholder.com/350x180?text=News+3" class="modern-news-image" alt="News 3">
                    <div class="modern-news-content">                    <p class="modern-news-title">ITH Sukses Laksanakan Festival Seni...</p>
                        <p class="modern-news-description">Festival seni yang menghadirkan berbagai penampilan mahasiswa...</p>
                    </div>
                </article>
            </div>

            {{-- FITUR KHUSUS ADMIN: TOMBOL EDIT --}}
            @auth
                @if(auth()->user()->hasAnyRole(['adminbem','adminukm']))
                <div class="flex justify-end mt-6">
                   <button onclick="openModalBerita()" class="modern-btn modern-btn-primary">
                     + Tambah Berita
                  </button>
                </div>
                @endif
            @endauth
        </div>
    </section>

    {{-- DAFTAR UKM --}}
    <section id="ukm" class="bg-gradient-to-br from-orange-50 to-orange-100 px-4 md:px-10 py-12 min-h-screen flex items-center">
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
                        <div class="modern-ukm-name">{{ strtoupper($item->nama) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TES MINAT --}}
    @if(auth()->guest() || !auth()->user()->hasRole('adminukm'))
        <section 
        id="tes-minat" 
        class="min-h-screen flex items-center justify-center 
            bg-gradient-to-br from-orange-50 to-orange-100 px-4">
        <div class="text-center max-w-xl">
            <h2 class="text-2xl md:text-3xl font-extrabold uppercase tracking-widest text-gray-800 mb-4">
                Tes Minat
            </h2>
            <p class="text-gray-600 mb-10">
                Kelola Pertanyaan dan Hasil Tes Minat Mahasiswa
            </p>
            <a href="{{ route('tesminatbem.menu') }}"
            class="inline-block bg-orange-500 text-white 
                    px-6 py-2.5 rounded-full text-lg font-semibold
                    shadow-lg hover:bg-orange-600 hover:scale-105 
                    transition">
                Kelola Tes Minat
            </a>
            </div>
        </section>
    @endif

    {{-- MODAL POPUP EDIT/TAMBAH BERITA --}}
    <div id="modalBerita" class="modern-modal-overlay hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50">
        <div class="modern-modal bg-white max-w-2xl w-full rounded-xl shadow-2xl overflow-hidden">
            <div class="modern-modal-header bg-orange-500 p-4 flex justify-between items-center text-white">
                <h3 id="modalBeritaTitle" class="font-bold text-lg">Tambah Berita</h3>
                <button onclick="closeModalBerita()" class="hover:rotate-90 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <form id="formBerita" action="{{ route('berita.index') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <div id="beritaMethod"></div> {{-- Untuk @method('PUT') --}}
                
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Berita</label>
                    <input type="text" name="judul" id="berita_judul" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konten Berita</label>
                    <textarea name="konten" id="berita_konten" rows="5" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500" required></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Upload Gambar</label>
                    <input type="file" name="gambar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeModalBerita()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 shadow-md">Simpan Berita</button>
                </div>
            </form>
        </div>
    </div>
    
@endsection

@push('scripts')
<script>
    // ==========================================
    // 1. SETUP DATA & VARIABEL GLOBAL
    // ==========================================
    const events = JSON.parse(`{!! json_encode($sevents ?? []) !!}`); 
    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    let activeKegiatanId = null; // Menyimpan ID kegiatan yang sedang dibuka
    
    const grid = document.getElementById('calendarGrid');
    const monthLabel = document.getElementById('monthLabel');

    // ==========================================
    // 2. FUNGSI RENDER KALENDER (Gaya Baru + Limit)
    // ==========================================
    function renderCalendar(year, month) {
        if(monthLabel) monthLabel.textContent = new Date(year, month).toLocaleString('id-ID', { month: 'long', year: 'numeric' });
        if(grid) grid.innerHTML = '';
        
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Kotak Kosong
        for (let i = 0; i < firstDay; i++) {
            grid.appendChild(document.createElement('div'));
        }

        // Tanggal
        for (let d = 1; d <= daysInMonth; d++) {
            const cell = document.createElement('div');
            cell.onclick = () => updateSidebarList(year, month, d);
            cell.className = 'flex flex-col items-center justify-start cursor-pointer hover:bg-orange-50 transition p-1 min-h-[80px] rounded-lg border border-transparent hover:border-orange-100 relative';

            const dateEl = document.createElement('div');
            dateEl.textContent = d;
            dateEl.className = 'text-sm mb-1 font-medium text-gray-700';
            
            if (year === today.getFullYear() && month === today.getMonth() && d === today.getDate()) {
                dateEl.className = 'w-7 h-7 flex items-center justify-center bg-orange-500 text-white rounded-full text-xs font-bold shadow-md mb-1';
            }
            cell.appendChild(dateEl);

            // LOGIKA LIMIT 3 ITEM
            const key = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            if (events[key]) {
                const eventList = Array.isArray(events[key]) ? events[key] : [events[key]];
                const maxDisplay = 2; // Tampilkan 2 + sisa
                
                eventList.forEach((event, index) => {
                    if (eventList.length <= 3) {
                         createEventPill(cell, event.nama);
                    } else {
                        if (index < maxDisplay) {
                            createEventPill(cell, event.nama);
                        } else if (index === maxDisplay) {
                            const more = document.createElement('div');
                            more.className = 'text-[10px] text-gray-400 font-bold mt-0.5';
                            more.textContent = `+ ${eventList.length - maxDisplay} lagi...`;
                            cell.appendChild(more);
                        }
                    }
                });
            }
            grid.appendChild(cell);
        }
    }

    function createEventPill(parent, text) {
        const ev = document.createElement('div');
        ev.className = 'w-full bg-orange-100 text-orange-700 text-[10px] px-1 py-0.5 rounded truncate mt-0.5 font-medium border border-orange-200/50';
        ev.textContent = text;
        parent.appendChild(ev);
    }

    // ==========================================
    // 3. FUNGSI UPDATE SIDEBAR (Klik Tanggal)
    // ==========================================
    function updateSidebarList(year, month, day) {
        const key = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const dateObj = new Date(year, month, day);
        
        const label = document.getElementById('selectedDateLabel');
        if(label) label.textContent = dateObj.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

        const listContainer = document.getElementById('dailyEventsList');
        if(!listContainer) return;
        
        listContainer.innerHTML = ''; 

        if (events[key]) {
            const eventList = Array.isArray(events[key]) ? events[key] : [events[key]];
            
            eventList.forEach(event => {
                const item = document.createElement('div');
                item.className = 'group p-3 rounded-xl border border-gray-100 bg-gray-50 hover:bg-orange-50 hover:border-orange-200 cursor-pointer transition-all duration-200';
                
                // KLIK LIST DI SIDEBAR -> BUKA MODAL DETAIL ADMIN
                item.onclick = () => showSideDetail(event.id);
                
                item.innerHTML = `
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="font-bold text-gray-800 text-sm group-hover:text-orange-600 line-clamp-2">${event.nama}</h4>
                        <span class="text-[10px] px-2 py-0.5 bg-gray-50 border border-gray-200 rounded-full text-gray-500 group-hover:bg-white">Detail</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>${event.waktu_mulai ? event.waktu_mulai.substring(0,5) : '-'}</span>
                    </div>
                `;
                listContainer.appendChild(item);
            });
        } else {
            listContainer.innerHTML = `<div class="text-center py-8 text-gray-400 bg-gray-50 rounded-xl border border-dashed border-gray-200"><p class="text-sm font-medium">Tidak ada kegiatan</p><p class="text-xs">Klik tombol (+) di atas untuk menambah</p></div>`;
        }
    }

    // ==========================================
    // 4. FUNGSI ADMIN: MODAL INPUT (Tambah/Edit)
    // ==========================================
    window.openAddModal = function() {
        document.getElementById('kegiatanForm').reset();
        document.getElementById('kegiatan_id').value = ''; // Kosongkan ID (Mode Tambah)
        document.getElementById('modalTitle').textContent = 'Input Kegiatan';
        document.getElementById('editModeIndicator').classList.add('hidden');
        document.getElementById('addModal').classList.remove('hidden');
    }

    window.closeAddModal = function() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('kegiatanForm').reset();
    }

    // Submit Form Tambah/Edit
    document.getElementById('kegiatanForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const id = document.getElementById('kegiatan_id').value;
        const url = id ? `/kegiatan/${id}` : '/kegiatan';
        const method = id ? 'PUT' : 'POST';
        
        // Ambil Data Form Manual (Biar aman)
        const data = {
            nama_kegiatan: document.getElementById('nama_kegiatan').value,
            tanggal_kegiatan: document.getElementById('tanggal_kegiatan').value,
            tempat: document.getElementById('tempat').value,
            waktu_mulai: document.getElementById('waktu_mulai').value,
            waktu_selesai: document.getElementById('waktu_selesai').value
        };

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                alert('Berhasil menyimpan kegiatan!');
                location.reload();
            } else {
                alert('Gagal: ' + (res.message || 'Error validasi'));
            }
        })
        .catch(err => alert('Terjadi kesalahan sistem'));
    });

    // ==========================================
    // 5. FUNGSI ADMIN: MODAL DETAIL & LPJ
    // ==========================================
    
    // Fungsi Buka Modal Detail (Dipanggil saat klik list sidebar)
    window.showSideDetail = function(eventId) {
        activeKegiatanId = eventId; // Simpan ID aktif

        fetch(`/kegiatan/${eventId}`)
            .then(res => res.json())
            .then(data => {
                // Isi Info Dasar
                document.getElementById('detailTitle').textContent = data.nama_kegiatan;
                document.getElementById('detailKegiatan').textContent = data.nama_kegiatan;
                document.getElementById('detailTempat').textContent = data.tempat;
                
                // Isi Penginput
                const penginput = (data.user && data.user.name) ? data.user.name : 'Admin';
                document.getElementById('detailPenginput').textContent = penginput;

                // Format Jadwal
                const date = new Date(data.tanggal_kegiatan);
                const hari = date.toLocaleDateString('id-ID', { weekday: 'long' });
                const tgl = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                const jam = (data.waktu_mulai && data.waktu_selesai) ? `${data.waktu_mulai.substring(0,5)} - ${data.waktu_selesai.substring(0,5)}` : '';
                document.getElementById('detailJadwal').textContent = `${hari}, ${tgl}, ${jam}`;

                // --- LOGIKA LPJ (ADMIN) ---
                const existingAlert = document.getElementById('existingLpjAlert');
                const linkLpj = document.getElementById('linkLpj');
                const btnSubmitLpj = document.getElementById('btnSubmitLpj');

                if (data.lpj && data.lpj.file_lpj) {
                    existingAlert.classList.remove('hidden');
                    // Link Download (Admin langsung download AES Decrypt)
                    linkLpj.href = `/kegiatan/${eventId}/download-lpj`; 
                    if(btnSubmitLpj) btnSubmitLpj.textContent = "Ganti File";
                } else {
                    existingAlert.classList.add('hidden');
                    if(btnSubmitLpj) btnSubmitLpj.textContent = "Upload";
                }

                // Reset Input File
                const fileInput = document.getElementById('file_lpj');
                if(fileInput) fileInput.value = '';

                // Tampilkan Modal
                document.getElementById('detailModal').classList.remove('hidden');
            })
            .catch(err => console.error(err));
    }

    window.closeDetailModal = function() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Fungsi Upload LPJ
    window.uploadFileLpj = function() {
        if (!activeKegiatanId) return;

        const fileInput = document.getElementById('file_lpj');
        if (!fileInput || fileInput.files.length === 0) {
            alert('Pilih file dulu bos!');
            return;
        }

        const formData = new FormData();
        formData.append('file_lpj', fileInput.files[0]);
        const btn = document.getElementById('btnSubmitLpj');
        const oldText = btn.textContent;
        btn.textContent = 'Uploading...';
        btn.disabled = true;

        fetch(`/kegiatan/${activeKegiatanId}/upload-lpj`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        })
        .then(res => res.json())
        .then(res => {
            btn.textContent = oldText;
            btn.disabled = false;
            if(res.success) {
                alert('LPJ Berhasil Diupload!');
                // Refresh modal detail untuk lihat perubahan
                showSideDetail(activeKegiatanId);
            } else {
                alert('Gagal: ' + res.message);
            }
        })
        .catch(err => {
            btn.textContent = oldText;
            btn.disabled = false;
            alert('Error Upload');
        });
    }

    // Fungsi Edit (Buka Modal Input dengan Data)
    window.editKegiatan = function() {
        if (!activeKegiatanId) return;
        
        // Fetch ulang data lengkap biar aman
        fetch(`/kegiatan/${activeKegiatanId}`)
            .then(res => res.json())
            .then(data => {
                // Isi Form Input
                document.getElementById('kegiatan_id').value = data.id_kegiatan; // ID untuk update
                document.getElementById('nama_kegiatan').value = data.nama_kegiatan;
                document.getElementById('tanggal_kegiatan').value = data.tanggal_kegiatan;
                document.getElementById('tempat').value = data.tempat;
                document.getElementById('waktu_mulai').value = data.waktu_mulai;
                document.getElementById('waktu_selesai').value = data.waktu_selesai;

                // Ganti Tampilan jadi Mode Edit
                document.getElementById('modalTitle').textContent = 'Edit Kegiatan';
                document.getElementById('editModeIndicator').classList.remove('hidden');
                
                // Tutup modal detail, buka modal edit
                closeDetailModal();
                document.getElementById('addModal').classList.remove('hidden');
            });
    }

    // Fungsi Hapus
    window.deleteKegiatan = function() {
        if (!activeKegiatanId) return;
        
        if(confirm('Yakin ingin menghapus kegiatan ini?')) {
            fetch(`/kegiatan/${activeKegiatanId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(res => {
                if(res.success) {
                    alert('Terhapus!');
                    location.reload();
                } else {
                    alert('Gagal menghapus');
                }
            });
        }
    }

    // ==========================================
    // 6. INIT LISTENER
    // ==========================================
    document.addEventListener('DOMContentLoaded', () => {
        const pBtn = document.getElementById('prevBtn');
        const nBtn = document.getElementById('nextBtn');
        
        if(pBtn) pBtn.onclick = () => {
            currentMonth--;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            renderCalendar(currentYear, currentMonth);
        };
        
        if(nBtn) nBtn.onclick = () => {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            renderCalendar(currentYear, currentMonth);
        };

        renderCalendar(currentYear, currentMonth);
    });
    // --- FUNGSI MODAL BERITA ---
    window.openModalBerita = function(id = null, judul = '', konten = '') {
        const modal = document.getElementById('modalBerita');
        const form = document.getElementById('formBerita');
        const title = document.getElementById('modalBeritaTitle');
        const methodDiv = document.getElementById('beritaMethod');

        if (id) {
            // Jika Mode Edit
            title.textContent = 'Edit Berita';
            form.action = `/berita/${id}`;
            methodDiv.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('berita_judul').value = judul;
            document.getElementById('berita_konten').value = konten;
        } else {
            // Jika Mode Tambah
            title.textContent = 'Tambah Berita';
            form.action = "{{ route('berita.store') }}";
            methodDiv.innerHTML = '';
            form.reset();
        }
        modal.classList.remove('hidden');
    }

    window.closeModalBerita = function() {
        document.getElementById('modalBerita').classList.add('hidden');
    }
</script>
@endpush