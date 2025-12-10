@extends('layouts.main')

@section('content')
    {{-- SECTION HERO --}}
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

    {{-- SEARCH + BULAN + KALENDER --}}
    <div class="mt-10 flex flex-col items-center px-4">
        <div class="w-full max-w-4xl flex flex-col items-center">
            {{-- SEARCH --}}
            <div class="modern-search relative mx-auto w-full max-w-md">
                <input type="text" placeholder="Cari Kegiatan"
                    class="px-5 py-3 w-full text-gray-700 placeholder-gray-400">
                <button class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 hover:text-orange-500 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.2-5.2m0 0A7 7 0 1 0 5 5a7 7 0 0 0 10.8 10.8Z" />
                    </svg>
                </button>
            </div>

            {{-- NAVIGASI BULAN --}}
            <div class="modern-calendar-nav flex items-center gap-4 justify-center mt-6 mb-6">
                <button id="prevBtn" class="modern-calendar-btn text-gray-700 font-bold text-xl">&lsaquo;</button>
                <span id="monthLabel" class="font-bold text-orange-500 text-xl md:text-2xl px-4">
                    {{ date('F, Y') }}
                </span>
                <button id="nextBtn" class="modern-calendar-btn text-gray-700 font-bold text-xl">&rsaquo;</button>
            </div>
        </div>
    </div>

    {{-- AREA KALENDER --}}
    <section id="kalender" class="bg-gradient-to-br from-gray-50 to-gray-100 px-4 md:px-8 py-12 scroll-mt-16 min-h-screen flex items-center">
        <div class="w-full max-w-4xl mx-auto">
            <div class="modern-calendar-container">
                <div class="grid grid-cols-7 gap-4 mb-6 text-center">
                    <div class="modern-calendar-day">Minggu</div>
                    <div class="modern-calendar-day">Senin</div>
                    <div class="modern-calendar-day">Selasa</div>
                    <div class="modern-calendar-day">Rabu</div>
                    <div class="modern-calendar-day">Kamis</div>
                    <div class="modern-calendar-day">Jumat</div>
                    <div class="modern-calendar-day">Sabtu</div>
                </div>
                <div id="calendarGrid" class="grid grid-cols-7 gap-3 text-center text-sm"></div>
                
                {{-- TOMBOL EDIT KEGIATAN --}}
                @auth
                    @if(auth()->user()->hasRole('adminbem','adminukm'))
                    <div class="flex justify-end mt-8">
                        <button onclick="openAddModal()" class="modern-btn modern-btn-primary">
                            + Tambah Kegiatan
                        </button>
                    </div>
                    @endif
                @endauth
            </div>
        </div>
    </section>

    {{-- MODAL INPUT KEGIATAN --}}
    @auth
        @if(auth()->user()->hasRole('adminbem','adminukm'))
        <div id="addModal" class="modern-modal-overlay hidden fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="modern-modal bg-white max-w-md w-full">
                {{-- Header --}}
                <div class="modern-modal-header flex justify-between items-center">
                    <h3 class="modern-modal-title">Input Kegiatan</h3>
                    <button onclick="closeAddModal()" class="modern-modal-close">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
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

                    {{-- Buttons (Only for Admin) --}}
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                        <button type="button" onclick="closeDetailModal()" 
                            class="modern-btn modern-btn-secondary">
                            Tutup
                        </button>
                        <button type="button" onclick="editKegiatan()" 
                            class="modern-btn modern-btn-success">
                            Edit
                        </button>
                        <button type="button" onclick="deleteKegiatan()" 
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
                    <div class="modern-news-content">
                        <p class="modern-news-title">ITH Sukses Laksanakan Festival Seni...</p>
                        <p class="modern-news-description">Festival seni yang menghadirkan berbagai penampilan mahasiswa...</p>
                    </div>
                </article>
            </div>

            {{-- FITUR KHUSUS ADMIN: TOMBOL EDIT --}}
            @role('adminbem|adminukm')
            <div class="flex justify-end mt-6">
                <button class="modern-btn modern-btn-primary">
                    Edit Berita
                </button>
            </div>
            @endrole
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
    <section id="tes-minat" class="bg-white py-10 text-center">
        <h3 class="text-sm font-semibold mb-3 tracking-wide">TES MINAT</h3>
        @auth
            @if(auth()->user()->isAdminBem())
                {{-- Untuk Admin BEM: Link ke halaman kelola tes minat --}}
                <a href="{{ route('tesminatbem.results') }}"
                    class="inline-block px-6 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600">
                    Kelola Tes Minat
                </a>
            @elseif(auth()->user()->isAdminUkm())
                {{--Admin UKM: Tidak ada akses ke tes minat--}}
            @else
                {{-- Untuk user biasa/mahasiswa: Link ke halaman isi tes minat --}}
                <a href="{{ route('tesminat.index') }}"
                    class="inline-block px-6 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600">
                    Ayo Mulai Tes!
                </a>
            @endif
        @else
            {{-- Untuk guest (belum login): Link ke halaman isi tes minat --}}
            <a href="{{ route('tesminat.index') }}"
                class="inline-block px-6 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600">
                Ayo Mulai Tes!
            </a>
        @endauth
    </section>
@endsection

@push('scripts')
<script>
    // Data Events
    const events = JSON.parse(`{!! json_encode($sevents ?? []) !!}`);
    let currentEventId = null;
    let isEditMode = false;

    // Custom Alert Functions for Katalon
    function showCustomAlert(message, type = 'success', callback = null) {
        const modal = document.getElementById('customAlertModal');
        const icon = document.getElementById('alertIcon');
        const title = document.getElementById('alertTitle');
        const messageEl = document.getElementById('alertMessage');
        const okBtn = document.getElementById('alertOkBtn');
        const cancelBtn = document.getElementById('alertCancelBtn');
        
        // Set message
        messageEl.textContent = message;
        
        // Configure based on type
        if (type === 'success') {
            title.textContent = 'Berhasil';
            icon.className = 'w-16 h-16 rounded-full flex items-center justify-center bg-green-100';
            icon.innerHTML = '<svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
            okBtn.className = 'px-6 py-2 bg-green-500 text-white rounded-lg font-semibold hover:bg-green-600 transition-colors';
            cancelBtn.classList.add('hidden');
        } else if (type === 'error') {
            title.textContent = 'Error';
            icon.className = 'w-16 h-16 rounded-full flex items-center justify-center bg-red-100';
            icon.innerHTML = '<svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';
            okBtn.className = 'px-6 py-2 bg-red-500 text-white rounded-lg font-semibold hover:bg-red-600 transition-colors';
            cancelBtn.classList.add('hidden');
        } else if (type === 'confirm') {
            title.textContent = 'Konfirmasi';
            icon.className = 'w-16 h-16 rounded-full flex items-center justify-center bg-orange-100';
            icon.innerHTML = '<svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>';
            okBtn.className = 'px-6 py-2 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition-colors';
            cancelBtn.classList.remove('hidden');
        }
        
        // Show modal
        modal.classList.remove('hidden');
        
        // Handle OK button
        okBtn.onclick = function() {
            hideCustomAlert();
            if (callback && type === 'confirm') {
                callback(true);
            }
        };
        
        // Handle Cancel button
        cancelBtn.onclick = function() {
            hideCustomAlert();
            if (callback && type === 'confirm') {
                callback(false);
            }
        };
    }
    
    function hideCustomAlert() {
        const modal = document.getElementById('customAlertModal');
        modal.classList.add('hidden');
    }

    // Modal Functions
    function openAddModal() {
        document.getElementById('addModal').classList.remove('hidden');
        document.getElementById('kegiatanForm').reset();
        document.getElementById('kegiatan_id').value = '';
        isEditMode = false;
    }

    function closeAddModal() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('kegiatanForm').reset();
        isEditMode = false;
    }

    function openDetailModal(eventId) {
        currentEventId = eventId;
        
        // Fetch event details
        fetch(`/kegiatan/${eventId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('detailTitle').textContent = data.nama_kegiatan;
                
                // Format date
                const date = new Date(data.tanggal_kegiatan);
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                const dayName = days[date.getDay()];
                const dateStr = `${dayName}, ${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
                
                // Format time
                const waktuMulai = data.waktu_mulai ? data.waktu_mulai.substring(0, 5).replace(':', '.') : '';
                const waktuSelesai = data.waktu_selesai ? data.waktu_selesai.substring(0, 5).replace(':', '.') : '';
                const timeStr = waktuMulai && waktuSelesai ? `, ${waktuMulai} >> ${waktuSelesai}` : '';
                
                document.getElementById('detailJadwal').textContent = dateStr + timeStr;
                document.getElementById('detailKegiatan').textContent = data.nama_kegiatan;
                document.getElementById('detailTempat').textContent = data.tempat;
                
                document.getElementById('detailModal').classList.remove('hidden');
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert('Gagal memuat detail kegiatan', 'error');
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
        currentEventId = null;
    }

    function editKegiatan() {
        if (!currentEventId) return;
        
        // Fetch event details and populate form
        fetch(`/kegiatan/${currentEventId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('kegiatan_id').value = data.id_kegiatan;
                document.getElementById('tanggal_kegiatan').value = data.tanggal_kegiatan;
                document.getElementById('waktu_mulai').value = data.waktu_mulai;
                document.getElementById('waktu_selesai').value = data.waktu_selesai;
                document.getElementById('nama_kegiatan').value = data.nama_kegiatan;
                document.getElementById('tempat').value = data.tempat;
                
                isEditMode = true;
                closeDetailModal();
                openAddModal();
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert('Gagal memuat data kegiatan', 'error');
            });
    }

    function deleteKegiatan() {
        if (!currentEventId) return;
        
        showCustomAlert('Apakah Anda yakin ingin menghapus kegiatan ini?', 'confirm', function(confirmed) {
            if (!confirmed) return;
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            
            fetch(`/kegiatan/${currentEventId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showCustomAlert('Kegiatan berhasil dihapus', 'success');
                    closeDetailModal();
                    setTimeout(() => location.reload(), 1500);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showCustomAlert('Gagal menghapus kegiatan', 'error');
            });
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Form Submit Handler
        const kegiatanForm = document.getElementById('kegiatanForm');
        if (kegiatanForm) {
            kegiatanForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form values directly from inputs
                const nama_kegiatan = document.getElementById('nama_kegiatan').value;
                const tanggal_kegiatan = document.getElementById('tanggal_kegiatan').value;
                const tempat = document.getElementById('tempat').value;
                const waktu_mulai = document.getElementById('waktu_mulai').value;
                const waktu_selesai = document.getElementById('waktu_selesai').value;
                const kegiatan_id = document.getElementById('kegiatan_id').value;
                
                // Create data object
                const data = {
                    nama_kegiatan: nama_kegiatan,
                    tanggal_kegiatan: tanggal_kegiatan,
                    tempat: tempat,
                    waktu_mulai: waktu_mulai,
                    waktu_selesai: waktu_selesai
                };
                
                console.log('Sending data:', data);
                
                // Determine URL and method
                let url = kegiatan_id ? `/kegiatan/${kegiatan_id}` : '/kegiatan';
                let method = kegiatan_id ? 'PUT' : 'POST';
                
                fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        return response.text().then(text => {
                            console.error('Error response:', text);
                            throw new Error(`HTTP error! status: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success data:', data);
                    if (data.success) {
                        showCustomAlert(data.message, 'success');
                        closeAddModal();
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        showCustomAlert('Error: ' + (data.message || 'Unknown error'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    showCustomAlert('Gagal menyimpan kegiatan: ' + error.message, 'error');
                });
            });
        }

        // --- 1. LOGIKA KALENDER ---
        const grid = document.getElementById('calendarGrid');
        const monthLabel = document.getElementById('monthLabel');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();

        function renderCalendar(year, month) {
            if (monthLabel) monthLabel.textContent = new Date(year, month).toLocaleString('id-ID', { month: 'long', year: 'numeric' });
            if (grid) grid.innerHTML = '';

            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                const empty = document.createElement('div');
                empty.className = 'h-10';
                grid.appendChild(empty);
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const cell = document.createElement('div');
                cell.className = 'modern-calendar-cell flex flex-col items-center justify-start';

                const dateEl = document.createElement('div');
                dateEl.textContent = d;
                dateEl.className = 'modern-calendar-date text-sm mb-2';

                if (year === today.getFullYear() && month === today.getMonth() && d === today.getDate()) {
                    dateEl.className = 'modern-calendar-today mb-2';
                }
                cell.appendChild(dateEl);

                const key = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                if (events[key]) {
                    const eventList = Array.isArray(events[key]) ? events[key] : [events[key]];
                    eventList.forEach(event => {
                        const ev = document.createElement('div');
                        ev.className = 'modern-calendar-event w-full';
                        
                        if (typeof event === 'object') {
                            ev.textContent = event.nama;
                            ev.onclick = () => openDetailModal(event.id);
                        } else {
                            ev.textContent = event;
                        }
                        
                        cell.appendChild(ev);
                    });
                }
                grid.appendChild(cell);
            }
        }

        if (prevBtn) prevBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            renderCalendar(currentYear, currentMonth);
        });
        if (nextBtn) nextBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            renderCalendar(currentYear, currentMonth);
        });
        renderCalendar(currentYear, currentMonth);


        // --- 2. LOGIKA SCROLLSPY (KHUSUS DASHBOARD) ---
        // Kita hanya mengambil link yang punya href diawali '#' (anchor link)
        // Link seperti /logout atau /akun akan diabaikan
        const allLinks = Array.from(document.querySelectorAll('aside .nav-link'));
        const links = allLinks.filter(l => {
            const href = l.getAttribute('href') || '';
            return href.startsWith('#');
        });

        if (!links.length) return;

        const ACTIVE = ['bg-orange-50', 'border-l-4', 'border-orange-500', 'text-gray-900'];

        function setActive(el) {
            // Bersihkan semua highlight dulu
            links.forEach(l => {
                l.classList.remove(...ACTIVE);
                l.classList.add('hover:bg-gray-100');
            });
            // Aktifkan yang dipilih
            if (el) {
                el.classList.add(...ACTIVE);
                el.classList.remove('hover:bg-gray-100');
            }
        }

        let skipObserverUntil = 0;
        
        // Klik Handler
        links.forEach(l => {
            l.addEventListener('click', () => {
                setActive(l);
                skipObserverUntil = Date.now() + 700;
            });
        });

        // Observer Handler
        const sections = links.map(l => document.querySelector(l.getAttribute('href'))).filter(Boolean);
        
        if (sections.length) {
            const observer = new IntersectionObserver((entries) => {
                if (Date.now() < skipObserverUntil) return;
                let best = entries[0];
                for (const e of entries) {
                    if (e.intersectionRatio > (best?.intersectionRatio ?? 0)) best = e;
                }
                if (best && best.intersectionRatio > 0.01) {
                    const id = '#' + best.target.id;
                    const link = links.find(l => l.getAttribute('href') === id);
                    if (link) setActive(link);
                }
            }, { root: null, rootMargin: '-20% 0px -50% 0px', threshold: [0, 0.25, 0.5, 0.75, 1] });

            sections.forEach(s => observer.observe(s));
        }
    });
</script>
@endpush