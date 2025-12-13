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
    <section id="news" class="bg-gradient-to-br from-gray-50 to-white px-4 md:px-10 py-12 min-h-screen flex items-center">
        <div class="max-w-6xl mx-auto">
            <h2 class="modern-section-title text-center uppercase">News</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <article class="modern-news-card">
                    <img src="https://via.placeholder.com/350x180?text=News+1" class="modern-news-image" alt="News 1">
                    <div class="modern-news-content">
                        <p class="modern-news-title">Mitraindonesia, Parepare – Habibie Robotic Competition (HRC) 2025...</p>
                        <p class="modern-news-description">Kegiatan tahunan Unit Kegiatan Mahasiswa yang mengasah kemampuan robotika mahasiswa.</p>
                    </div>
                </article>
                <article class="modern-news-card">
                    <img src="https://via.placeholder.com/350x180?text=News+2" class="modern-news-image" alt="News 2">
                    <div class="modern-news-content">
                        <p class="modern-news-title">Parepare, 29/05/2025 – ITH Futsal Cup resmi bergulir...</p>
                        <p class="modern-news-description">Turnamen futsal antar program studi dengan upacara pembukaan yang meriah.</p>
                    </div>
                </article>
                <article class="modern-news-card">
                    <img src="https://via.placeholder.com/350x180?text=News+3" class="modern-news-image" alt="News 3">
                    <div class="modern-news-content">
                        <p class="modern-news-title">ITH Sukses Laksanakan Festival Seni...</p>
                        <p class="modern-news-description">Festival seni yang menghadirkan berbagai penampilan mahasiswa dan kolaborasi dengan Pemkot.</p>
                    </div>
                </article>
            </div>
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
                        <div class="modern-ukm-name">
                            {{ strtoupper($item->nama) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- TES MINAT - Hanya tampil untuk non-admin BEM --}}
    @auth
        @if(!auth()->user()->hasRole('adminbem'))
        <section id="tes-minat" class="bg-white py-12 min-h-screen flex items-center justify-center">
            <div class="w-full max-w-4xl mx-auto px-4">
                <div class="modern-tes-minat text-center">
                    <h3 class="modern-tes-minat-title">TES MINAT</h3>
                    <a href="{{ url('tesminat') }}"
                        class="modern-btn modern-btn-primary inline-block">
                        Ayo Mulai Tes!
                    </a>
                </div>
            </div>
        </section>
        @endif
    @else
        {{-- Guest bisa lihat tes minat --}}
        <section id="tes-minat" class="bg-white py-12 min-h-screen flex items-center justify-center">
            <div class="w-full max-w-4xl mx-auto px-4">
                <div class="modern-tes-minat text-center">
                    <h3 class="modern-tes-minat-title">TES MINAT</h3>
                    <a href="{{ url('tesminat') }}"
                        class="modern-btn modern-btn-primary inline-block">
                        Ayo Mulai Tes!
                    </a>
                </div>
            </div>
        </section>
    @endauth

    {{-- Modal Detail Kegiatan --}}
    <div id="detailModal" class="modern-modal-overlay hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="modern-modal bg-white max-w-md w-full">
            {{-- Header --}}
            <div class="modern-modal-header flex justify-between items-center">
                <h3 id="detailTitle" class="modern-modal-title"></h3>
                <button onclick="closeDetailModal()" class="modern-modal-close">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            {{-- Body --}}
            <div class="modern-modal-body space-y-5">
                {{-- Jadwal --}}
                <div class="flex items-start gap-4">
                    <div class="modern-form-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-semibold text-gray-500 mb-1">Tempat</p>
                        <p id="detailTempat" class="text-sm text-gray-800"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Data Events dari Controller
    const events = JSON.parse(`{!! json_encode($sevents ?? []) !!}`);

    document.addEventListener('DOMContentLoaded', () => {
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
                if (events[key] && Array.isArray(events[key])) {
                    events[key].forEach(event => {
                        const ev = document.createElement('div');
                        ev.className = 'modern-calendar-event w-full';
                        ev.textContent = event.nama;
                        ev.onclick = () => showEventDetail(event);
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

        // Show Event Detail Function
        window.showEventDetail = function(event) {
            const date = new Date(event.tanggal_kegiatan);
            const hari = date.toLocaleDateString('id-ID', { weekday: 'long' });
            const tanggal = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            const waktu = event.waktu_mulai && event.waktu_selesai ? `${event.waktu_mulai} >> ${event.waktu_selesai}` : '';
            
            // Set modal content
            document.getElementById('detailTitle').textContent = event.nama;
            document.getElementById('detailJadwal').textContent = `${hari}, ${tanggal}${waktu ? ', ' + waktu : ''}`;
            document.getElementById('detailKegiatan').textContent = event.nama;
            document.getElementById('detailTempat').textContent = event.tempat || '-';
            
            // Show modal
            document.getElementById('detailModal').classList.remove('hidden');
        }

        // Close Detail Modal Function
        window.closeDetailModal = function() {
            document.getElementById('detailModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('detailModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        // --- 2. LOGIKA SCROLLSPY ---
        const links = Array.from(document.querySelectorAll('aside .nav-link'));
        if (!links.length) return;

        const ACTIVE = ['bg-orange-50', 'border-l-4', 'border-orange-500', 'text-gray-900'];
        function setActive(el) {
            links.forEach(l => {
                l.classList.remove(...ACTIVE);
                l.classList.add('hover:bg-gray-100');
            });
            if(el) {
                el.classList.add(...ACTIVE);
                el.classList.remove('hover:bg-gray-100');
            }
        }
        
        let skipObserverUntil = 0;
        links.forEach(l => {
            l.addEventListener('click', () => {
                setActive(l);
                skipObserverUntil = Date.now() + 700;
            });
        });

        // Setup Intersection Observer
        const sections = links.map(l => {
            const href = l.getAttribute('href');
            return href && href.startsWith('#') ? document.querySelector(href) : null;
        }).filter(Boolean);

        if (sections.length) {
            const observer = new IntersectionObserver((entries) => {
                if (Date.now() < skipObserverUntil) return;
                let best = entries[0];
                for (const e of entries) {
                    if (e.intersectionRatio > (best?.intersectionRatio ?? 0)) best = e;
                }
                if (best && best.intersectionRatio > 0.01) {
                    const id = '#' + best.target.id;
                    const link = document.querySelector('aside .nav-link[href="' + id + '"]');
                    if (link) setActive(link);
                }
            }, { root: null, rootMargin: '-20% 0px -50% 0px', threshold: [0, 0.25, 0.5, 0.75, 1] });
            sections.forEach(s => observer.observe(s));
        }
    });
</script>
@endpush
