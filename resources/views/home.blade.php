<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIMAWA ITH</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">

<div class="min-h-screen flex">

    {{-- SIDEBAR KIRI --}}
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col sticky top-0 h-screen">
        <div class="h-16 flex items-center px-6 border-b border-gray-200">
            <span class="font-semibold text-sm tracking-wide">SIMAWA ITH</span>
        </div>
        <nav class="flex-1 pt-4 text-sm">
            <a href="#kalender" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
                Kalender Kegiatan
            </a>
            <a href="#bem" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
                Badan Eksekutif Mahasiswa
            </a>
            <a href="#news" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
                NEWS
            </a>
            <a href="#ukm" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
                Daftar UKM/SC
            </a>
            <a href="#tes-minat" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
                Tes Minat
            </a>
        </nav>
    </aside>

    {{-- KONTEN KANAN --}}
    <div class="flex-1 flex flex-col">

        {{-- NAVBAR ATAS --}}
        <header class="h-16 bg-white shadow flex items-center justify-between px-6">
            <div class="font-medium text-sm">Dashboard</div>
            <button class="px-4 py-1.5 bg-orange-500 text-white text-xs font-semibold rounded-full hover:bg-orange-600"
             onclick="window.location.href='{{route('login')}}'">
                LOGIN
            </button>
        </header>

        {{-- KONTEN SCROLL --}}
        <main class="flex-1 overflow-y-auto">

            {{-- ABU-ABU + JUDUL --}}
            <section class="relative w-full">
                <img src="/images/ith.jpg" class="w-full h-56 md:h-72 lg:h-80 object-cover">
                    <div class="absolute inset-0 bg-orange-500 opacity-40"></div>

                   
                <div class="absolute inset-0 flex flex-col items-center justify-center text-white text-center">
                    <h2 class="text-3xl mt:text-4xl font-bold leading leading-tight">WELCOME<br>TO<br>SIMAWA</h2>
                    <p class="mt-2 text-sm max-w-md">Sistem Informasi Organisasi Mahasiswa<br>Institut Teknologi Bacharuddin Jusuf Habibie</p>
                </div>
            </section>

            {{-- SEARCH + BULAN + KALENDER --}}
            <div class="mt-10 flex-col items-center">
                {{-- SEARCH --}}

            <div class="mt-10 w-full flex flex-col items-center">
                <div class="w-full max-w-4xl px-4">
                    {{-- SEARCH --}}
                    <div class="relative mx-auto w-full max-w-xs">
                        <input
                            type="text"
                            placeholder="Cari Kegiatan"
                            class="px-4 py-2 w-full bg-gray-100 rounded-md border focus:outline-none focus:ring-2 focus:ring-orange-400"
                        >
                {{-- TOMBOL SEARCH (bisa diklik) --}}
                <button class="absolute right-3 top-2.5 text-gray-600 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.2-5.2m0 0A7 7 0 1 0 5 5a7 7 0 0 0 10.8 10.8Z" />
                    </svg>
                </button>
            </div>

                {{-- FILTER + BULAN --}}
                <!-- <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4"> -->
                  
                    <div class="flex items-center gap-4 text-sm justify-center mt-4 mb-4">
                        <button id="prevBtn" class="px-3 py-1 rounded hover:bg-gray-200">&lsaquo;</button>
                        <span id="monthLabel" class="font-semibold text-orange-500"><?php echo date('F, Y'); ?></span>
                        <button id="nextBtn" class="px-3 py-1 rounded hover:bg-gray-200">&rsaquo;</button>
                    </div>
                </div>

            {{-- AREA ABU-ABU TUA + KALENDER --}}
            </div>
            <section id="kalender" class="bg-gray-300 px-8 py-6 scroll-mt-16">
                <div class="w-full max-w-2xl mx-auto">
                    <div class="grid grid-cols-7 gap-4 mb-4 text-sm text-center">
                        <div class="font-semibold">Minggu</div>
                        <div class="font-semibold">Senin</div>
                        <div class="font-semibold">Selasa</div>
                        <div class="font-semibold">Rabu</div>
                        <div class="font-semibold">Kamis</div>
                        <div class="font-semibold">Jumat</div>
                        <div class="font-semibold">Sabtu</div>
                    </div>

                    <!-- calendar grid -->
                    <div id="calendarGrid" class="grid grid-cols-7 gap-y-6 gap-x-4 text-center text-sm"></div>
                </div>
            </section>

    <script>
        const events = {!! json_encode($sevents ?? []) !!};

        document.addEventListener('DOMContentLoaded', () => {
            const grid = document.getElementById('calendarGrid');
            const monthLabel = document.getElementById('monthLabel');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            const today = new Date();
            let currentMonth = today.getMonth();
            let currentYear = today.getFullYear();

            function renderCalendar(year, month) {
                if (monthLabel) monthLabel.textContent = new Date(year, month).toLocaleString('id-ID', { month: 'long', year: 'numeric' });
                grid.innerHTML = '';

                const firstDay = new Date(year, month, 1).getDay();
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                                // empty cells before first day
                for (let i = 0; i < firstDay; i++) {
                    const empty = document.createElement('div');
                    empty.className = 'h-10';
                    grid.appendChild(empty);
                }

                for (let d = 1; d <= daysInMonth; d++) {
                    const cell = document.createElement('div');
                    cell.className = 'flex flex-col items-center justify-center h-16';

                    const dateEl = document.createElement('div');
                    dateEl.textContent = d;
                    dateEl.className = 'text-sm';

                    if (year === today.getFullYear() && month === today.getMonth() && d === today.getDate()) {
                        dateEl.className += ' w-8 h-8 flex items-center justify-center rounded-full bg-orange-500 text-white';
                    }

                    cell.appendChild(dateEl);

                    const key = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                    if (events[key]) {
                        const ev = document.createElement('div');
                        ev.className = 'mt-1 text-[10px] leading-3 text-red-700 text-center';
                        ev.textContent = Array.isArray(events[key]) ? events[key][0] : events[key];
                        cell.appendChild(ev);
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
        });
        
    </script>
        
            {{-- BEM --}}
            <section id="bem" class="bg-white mt-6 px-10 pt-10 pb-8">
                <h2 class="text-center text-lg font-semibold mb-6">
                    Badan Eksekutif Mahasiswa
                </h2>

                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <div class="w-32 h-32 rounded-xl border-4 border-gray-800 flex items-center justify-center overflow-hidden flex-shrink-0">
                        <a href="{{ url('/bem') }}" title="BEM" aria-label="Badan Eksekutif Mahasiswa" class="w-full h-full flex items-center justify-center block hover:opacity-90">
                            <img src="/images/logobem.png" alt="BEM Logo" class="w-full h-full object-contain">
                        </a>
                    </div>

                    <div class="flex-1">
                        <!-- <h3 class="hidden md:block text-lg font-semibold mb-2">Badan Eksekutif Mahasiswa</h3> -->
                        <p class="max-w-3xl text-sm text-gray-700 leading-relaxed text-left">
                            Badan Eksekutif Mahasiswa hadir sebagai penggerak utama dinamika kampus. Melalui
                            nilai-nilai kepemimpinan, integritas, dan pelayanan, BEM berupaya memberikan ruang bagi
                            mahasiswa untuk tumbuh, memimpin, dan berkontribusi secara nyata.
                        </p>
                    </div>
                </div>
            </section>


            {{-- NEWS --}}
            <section id="news" class="bg-white px-10 pt-8 pb-10">
                <h2 class="text-center text-lg font-semibold mb-6 uppercase">NEWS</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
                    <article class="flex flex-col">
                        <img src="https://via.placeholder.com/350x180?text=News+1"
                             class="rounded-lg mb-2 object-cover w-full h-40" alt="">
                        <p class="font-semibold mb-1">
                            Mitraindonesia, Parepare – Habibie Robotic Competition (HRC) 2025...
                        </p>
                        <p class="text-gray-700">
                            Kegiatan tahunan Unit Kegiatan Mahasiswa yang mengasah kemampuan robotika mahasiswa.
                        </p>
                    </article>

                    <article class="flex flex-col">
                        <img src="https://via.placeholder.com/350x180?text=News+2"
                             class="rounded-lg mb-2 object-cover w-full h-40" alt="">
                        <p class="font-semibold mb-1">
                            Parepare, 29/05/2025 – ITH Futsal Cup resmi bergulir...
                        </p>
                        <p class="text-gray-700">
                            Turnamen futsal antar program studi dengan upacara pembukaan yang meriah.
                        </p>
                    </article>

                    <article class="flex flex-col">
                        <img src="https://via.placeholder.com/350x180?text=News+3"
                             class="rounded-lg mb-2 object-cover w-full h-40" alt="">
                        <p class="font-semibold mb-1">
                            ITH Sukses Laksanakan Festival Seni...
                        </p>
                        <p class="text-gray-700">
                            Festival seni yang menghadirkan berbagai penampilan mahasiswa dan kolaborasi dengan Pemkot.
                        </p>
                    </article>
                </div>
            </section>

            {{-- DAFTAR UKM --}}
            <section id="ukm" class="bg-[#edb59fc2] px-6 pt-8 pb-10 mt-2">
                <h2 class="text-center text-lg font-semibold mb-6 uppercase">DAFTAR UKM/SC</h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-start">
                    <!-- HERO -->
                        <div class="flex flex-col items-center">
                            <div class="bg-white rounded-xl border border-gray-800 w-full h-40 flex items-center justify-center overflow-hidden">
                                <a href="{{ url('/ukm/hero') }}" class="w-full h-full flex items-center justify-center">
                                    <img src="/images/logohero.jpg" alt="HERO" class="max-h-full max-w-full object-contain">
                                </a>
                            </div>
                            <span class="mt-3 text-center font-semibold text-xs">HERO</span>
                        </div>

                    <!-- HCC -->
                        <div class="flex flex-col items-center">
                            <div class="bg-white rounded-xl border border-gray-800 w-full h-40 flex items-center justify-center overflow-hidden">
                                <a href="{{ url('/ukm/hcc') }}" class="w-full h-full flex items-center justify-center">
                                    <img src="/images/logohcc.png" alt="HCC" class="max-h-full max-w-full object-contain">
                                </a>
                            </div>
                            <span class="mt-3 text-center font-semibold text-xs">HCC</span>
                        </div>

                    <!-- SENI -->
                        <div class="flex flex-col items-center">
                            <div class="bg-white rounded-xl border border-gray-800 w-full h-40 flex items-center justify-center overflow-hidden">
                                <a href="{{ url('/ukm/seni') }}" class="w-full h-full flex items-center justify-center">
                                    <img src="/images/logoseni.png" alt="SENI" class="max-h-full max-w-full object-contain">
                                </a>
                            </div>
                            <span class="mt-3 text-center font-semibold text-xs">SENI</span>
                        </div>

                    <!-- OLAHRAGA -->
                        <div class="flex flex-col items-center">
                            <div class="bg-white rounded-xl border border-gray-800 w-full h-40 flex items-center justify-center overflow-hidden">
                                <a href="{{ url('/ukm/olahraga') }}" class="w-full h-full flex items-center justify-center">
                                    <img src="/images/logo.png" alt="OLAHRAGA" class="max-h-full max-w-full object-contain">
                                </a>
                            </div>
                            <span class="mt-3 text-center font-semibold text-xs">OLAHRAGA</span>
                        </div>
                    </div>
                </div>
            </section>

            {{-- TES MINAT --}}
            <section id="tes-minat" class="bg-white py-10 text-center">
                <h3 class="text-sm font-semibold mb-3 tracking-wide">TES MINAT</h3>
                <!-- <button
                    class="px-6 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600">
                    Ayo Mulai Tes!
                </button> -->
                <a href="{{ url('tesminat') }}"
                    class="inline-block px-6 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600">
                    Ayo Mulai Tes!
                </a>
            </section>
        </main>
    </div>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const links = Array.from(document.querySelectorAll('aside .nav-link'));
        if (!links.length) return;

        const ACTIVE = ['bg-orange-50', 'border-l-4', 'border-orange-500', 'text-gray-900'];

        function clearActive() {
            links.forEach(l => {
                l.classList.remove(...ACTIVE);
                l.classList.add('hover:bg-gray-100');
            });
        }

        function setActive(el) {
            if (!el) return;
            clearActive();
            el.classList.add(...ACTIVE);
            el.classList.remove('hover:bg-gray-100');
        }

        // initial highlight: prefer hash -> existing active -> default #kalender
        const hashLink = location.hash ? document.querySelector('aside .nav-link[href="' + location.hash + '"]') : null;
        const alreadyActive = links.find(l => ACTIVE.some(c => l.classList.contains(c)));
        if (hashLink) {
            setActive(hashLink);
        } else if (alreadyActive) {
            setActive(alreadyActive);
        } else {
            const def = document.querySelector('aside .nav-link[href="#kalender"]');
            if (def) setActive(def);
        }

        // flag to ignore observer right after a click (prevents observer from immediately overriding)
        let skipObserverUntil = 0;

        // click: set active immediately (allow anchor default scroll)
        links.forEach(l => {
            l.addEventListener('click', (e) => {
                setActive(l);
                // ignore observer updates for a short time while browser scrolls
                skipObserverUntil = Date.now() + 700;
                // allow default anchor behavior (keeps native scroll) — if you use manual scroll, preventDefault here
            });
        });

        // observe sections and update active on scroll — pick most visible section
        const sections = links.map(l => document.querySelector(l.getAttribute('href'))).filter(Boolean);
        if (sections.length) {
            const observer = new IntersectionObserver((entries) => {
                // skip if recently clicked to avoid override during programmatic/anchor scroll
                if (Date.now() < skipObserverUntil) return;

                // choose entry with largest intersectionRatio
                let best = entries[0];
                for (const e of entries) {
                    if (e.intersectionRatio > (best?.intersectionRatio ?? 0)) best = e;
                }
                if (!best) return;
                // ensure it's meaningfully visible
                if (best.intersectionRatio > 0.01) {
                    const id = '#' + best.target.id;
                    const link = document.querySelector('aside .nav-link[href="' + id + '"]');
                    if (link) setActive(link);
                }
            }, { root: null, rootMargin: '-20% 0px -50% 0px', threshold: [0, 0.25, 0.5, 0.75, 1] });

            sections.forEach(s => observer.observe(s));
        }
    });
    </script>
</body>
</html>
