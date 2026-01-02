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

    {{-- MODAL DETAIL (VERSI GUEST - READ ONLY) --}}
    <div id="detailModal" class="modern-modal-overlay hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="modern-modal bg-white max-w-md w-full">
            <div class="modern-modal-header flex justify-between items-center">
                <h3 class="modern-modal-title">Detail Kegiatan</h3>
                <button onclick="closeDetailModal()" class="modern-modal-close">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="modern-modal-body space-y-5">
                {{-- Info Utama --}}
                <div class="flex items-start gap-4">
                    <div class="modern-form-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg></div>
                    <div class="flex-1"><p class="text-xs font-semibold text-gray-500 mb-1">Jadwal</p><p id="detailJadwal" class="text-sm text-gray-800 font-medium"></p></div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="modern-form-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" /></svg></div>
                    <div class="flex-1"><p class="text-xs font-semibold text-gray-500 mb-1">Kegiatan</p><p id="detailKegiatan" class="text-sm text-gray-800"></p></div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="modern-form-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg></div>
                    <div class="flex-1"><p class="text-xs font-semibold text-gray-500 mb-1">Tempat</p><p id="detailTempat" class="text-sm text-gray-800"></p></div>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="modern-form-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></div>
                    <div class="flex-1"><p class="text-xs font-semibold text-gray-500 mb-1">Penyelenggara</p><p id="detailPenginput" class="text-sm text-gray-800 font-medium">-</p></div>
                </div>

                {{-- Link Download LPJ (Hanya Muncul Jika Ada File) --}}
                <div id="lpjContainer" class="hidden pt-4 mt-2 border-t border-gray-100">
                    <label class="text-xs font-bold text-gray-700 mb-2 block">Dokumen LPJ</label>
                    <div class="p-2 bg-green-50 border border-green-200 rounded-md flex justify-between items-center">
                        <a id="linkLpj" href="#" target="_blank" class="text-xs text-green-700 hover:underline flex items-center gap-1 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download File LPJ
                        </a>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeDetailModal()" class="modern-btn modern-btn-secondary">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    
@endsection

@push('scripts')
<script>
    // 1. Variabel Global & Data
    const events = JSON.parse(`{!! json_encode($sevents ?? []) !!}`);
    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    const grid = document.getElementById('calendarGrid');
    const monthLabel = document.getElementById('monthLabel');

    // 2. Fungsi Helper: Bikin Pill Oranye (Sama dengan Dashboard)
    function createEventPill(parent, text) {
        const ev = document.createElement('div');
        ev.className = 'w-full bg-orange-100 text-orange-700 text-[10px] px-1 py-0.5 rounded truncate mt-0.5 font-medium border border-orange-200/50';
        ev.textContent = text;
        parent.appendChild(ev);
    }

    // 3. Render Calendar (Versi Home dengan LIMIT 2)
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
            
            // ONCLICK: Panggil updateSidebarList (Khusus Tamu)
            cell.onclick = () => updateSidebarList(year, month, d);
            
            cell.className = 'flex flex-col items-center justify-start cursor-pointer hover:bg-orange-50 transition p-1 min-h-[80px] rounded-lg border border-transparent hover:border-orange-100 relative';

            // Angka Tanggal
            const dateEl = document.createElement('div');
            dateEl.textContent = d;
            dateEl.className = 'text-sm mb-1 font-medium text-gray-700';
            
            if (year === today.getFullYear() && month === today.getMonth() && d === today.getDate()) {
                dateEl.className = 'w-7 h-7 flex items-center justify-center bg-orange-500 text-white rounded-full text-xs font-bold shadow-md mb-1';
            }
            cell.appendChild(dateEl);

            // --- LOGIKA LIMIT 2 BARIS (SAMA PERSIS DASHBOARD) ---
            const key = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            
            if (events[key]) {
                const eventList = Array.isArray(events[key]) ? events[key] : [events[key]];
                const maxDisplay = 2; // Batas tampil
                
                eventList.forEach((event, index) => {
                    // Kalau total <= 3, tampilkan semua
                    if (eventList.length <= 3) {
                         createEventPill(cell, event.nama);
                    } 
                    // Kalau > 3, tampilkan 2 saja + sisanya
                    else {
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

    // 4. Update Sidebar (Versi Guest)
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
                item.onclick = () => openDetailModal(event.id);
                
                item.innerHTML = `
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="font-bold text-gray-800 text-sm group-hover:text-orange-600 line-clamp-2">${event.nama}</h4>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>${event.waktu_mulai ? event.waktu_mulai.substring(0,5) : '-'}</span>
                    </div>
                `;
                listContainer.appendChild(item);
            });
        } else {
            listContainer.innerHTML = `
                <div class="text-center py-8 text-gray-400 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <p class="text-sm font-medium">Tidak ada kegiatan</p>
                    <p class="text-xs">pada tanggal ini</p>
                </div>
            `;
        }
    }

    // 5. Modal Detail (Versi Guest & AES Check)
    function openDetailModal(eventId) {
        fetch(`/kegiatan/${eventId}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('detailKegiatan').textContent = data.nama_kegiatan;
                document.getElementById('detailTempat').textContent = data.tempat;
                
                const penginput = (data.user && data.user.name) ? data.user.name : 'Admin';
                document.getElementById('detailPenginput').textContent = penginput;

                const date = new Date(data.tanggal_kegiatan);
                const hari = date.toLocaleDateString('id-ID', { weekday: 'long' });
                const tgl = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                const jam = (data.waktu_mulai && data.waktu_selesai) ? `${data.waktu_mulai.substring(0,5)} - ${data.waktu_selesai.substring(0,5)}` : '';
                document.getElementById('detailJadwal').textContent = `${hari}, ${tgl}, ${jam}`;

                // Logika LPJ Tamu
                const lpjContainer = document.getElementById('lpjContainer');
                const linkLpj = document.getElementById('linkLpj');
                
                if (data.lpj && data.lpj.file_lpj) {
                    lpjContainer.classList.remove('hidden');
                    // Cek login via blade
                    const isGuest = {{ auth()->check() ? 'false' : 'true' }};

                    if (isGuest) {
                        linkLpj.href = "{{ route('login') }}";
                        linkLpj.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> Login untuk Download (AES)`;
                        linkLpj.onclick = (e) => {
                            if(!confirm('File ini terenkripsi. Silakan login untuk mengunduh.')) e.preventDefault();
                        };
                        linkLpj.parentElement.className = "p-2 bg-gray-100 border border-gray-200 rounded-md flex justify-between items-center text-gray-500 cursor-not-allowed";
                    } else {
                        linkLpj.href = `/kegiatan/${eventId}/download-lpj`;
                        linkLpj.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download LPJ`;
                        linkLpj.parentElement.className = "p-2 bg-green-50 border border-green-200 rounded-md flex justify-between items-center";
                        linkLpj.onclick = null;
                    }
                } else {
                    lpjContainer.classList.add('hidden');
                }
                document.getElementById('detailModal').classList.remove('hidden');
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // ==========================================
    // FUNGSI PENCARIAN KEGIATAN (GLOBAL)
    // ==========================================
    window.searchEvents = function() {
        const keyword = document.getElementById('searchInput').value.toLowerCase();
        const listContainer = document.getElementById('dailyEventsList');
        const label = document.getElementById('selectedDateLabel');

        if (keyword.length < 1) {
            // Jika kolom pencarian kosong, kembalikan ke instruksi pilih tanggal
            label.textContent = "- Pilih Tanggal -";
            listContainer.innerHTML = `
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-sm">Klik tanggal di kalender<br>untuk melihat daftar kegiatan.</p>
                </div>`;
            return;
        }

        label.textContent = "Hasil Pencarian: " + keyword;
        listContainer.innerHTML = ''; // Kosongkan list

        let found = false;

        // Iterasi melalui semua data events yang ada di variabel global 'events'
        for (let dateKey in events) {
            const dailyEvents = Array.isArray(events[dateKey]) ? events[dateKey] : [events[dateKey]];

            dailyEvents.forEach(event => {
                if (event.nama.toLowerCase().includes(keyword)) {
                    found = true;
                    const item = document.createElement('div');
                    item.className = 'group p-3 rounded-xl border border-orange-100 bg-orange-50/30 hover:bg-orange-50 cursor-pointer transition-all duration-200 mb-3';

                    // Tetap memfungsikan klik detail untuk Guest
                    item.onclick = () => openDetailModal(event.id);

                    item.innerHTML = `
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-gray-800 text-sm group-hover:text-orange-600 line-clamp-2">${event.nama}</h4>
                            <span class="text-[10px] px-2 py-0.5 bg-white border border-orange-200 rounded-full text-orange-500">${dateKey}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>${event.waktu_mulai ? event.waktu_mulai.substring(0,5) : '-'}</span>
                        </div>
                    `;
                    listContainer.appendChild(item);
                }
            });
        }

        if (!found) {
            listContainer.innerHTML = `
                <div class="text-center py-8 text-gray-400">
                    <p class="text-sm font-medium">Kegiatan "${keyword}" tidak ditemukan.</p>
                </div>`;
        }
    }

    // Init
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

        // Render Awal
        renderCalendar(currentYear, currentMonth);

        // --- SCROLLSPY (Biar Navigasi Oranye jalan) ---
        const navLinks = document.querySelectorAll('nav a[href^="#"]');
        const sections = document.querySelectorAll('section[id]');

        if(navLinks.length > 0 && sections.length > 0) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        navLinks.forEach(link => {
                            link.classList.remove('text-orange-500', 'font-bold');
                            if(link.getAttribute('href') === '#' + entry.target.id) {
                                link.classList.add('text-orange-500', 'font-bold');
                            }
                        });
                    }
                });
            }, { rootMargin: '-50% 0px -50% 0px' });

            sections.forEach(section => observer.observe(section));
        }
    });
</script>
@endpush
