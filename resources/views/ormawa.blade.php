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

<!-- <nav class="flex-1 pt-4 text-sm"> -->

    {{-- Kalender (home) --}}
    <a href="{{ route('home') }}#kalender"
       class="nav-link flex items-center px-6 py-2 hover:bg-gray-100
       {{ request()->routeIs('home') ? 'bg-orange-50 border-l-4 border-orange-500 text-gray-900' : '' }}">
        Kalender Kegiatan
    </a>

    {{-- BEM --}}
    <a href="{{ route('ormawa.show', 'bem') }}"
       class="nav-link flex items-center px-6 py-2 hover:bg-gray-100
       {{ (isset($ormawa) && $ormawa->slug === 'bem') ? 'bg-orange-50 border-l-4 border-orange-500 text-gray-900' : '' }}">
        Badan Eksekutif Mahasiswa
    </a>

    {{-- NEWS --}}
    <a href="{{ route('home') }}#news"
       class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
        NEWS
    </a>

        {{-- UKM/SC --}}
    <a href="{{ route('home', 'ormawa') }}#ukm"
    class="nav-link flex items-center px-6 py-2 hover:bg-gray-100
    {{ (isset($ormawa) && $ormawa->tipe === 'ukm') ? 'bg-orange-50 border-l-4 border-orange-500 text-gray-900' : '' }}">
        Daftar UKM/SC
    </a>

    <!-- {{-- UKM/SC --}}
    <a href="{{ route('ormawa.show', 'ormawa') }}#ukm"
       class="nav-link flex items-center px-6 py-2 hover:bg-gray-100
       {{ (isset($ormawa) && $ormawa->tipe === 'ukm') ? 'bg-orange-50 border-l-4 border-orange-500 text-gray-900' : '' }}">
        Daftar UKM/SC
    </a> -->

    {{-- Tes Minat --}}
    <a href="{{ route('home') }}#tes-minat"
       class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
        Tes Minat
    </a>

    </nav>

        <!-- <div class="mt-auto pb-4 text-sm">
            <a href="{{ url('/akun') }}" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
                Akun
            </a>

            <a href="{{ url('/panduan') }}" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
                Panduan
            </a>

            <a href="{{ route('logout') }}" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
                Log-Out
            </a>
        </div> -->
    </aside>

    {{-- KONTEN KANAN --}}
    <div class="flex-1 flex flex-col">

        {{-- NAVBAR ATAS --}}
        <header class="fixed top-0 left-0 md:left-64 right-0 h-16 bg-white shadow flex items-center justify-between px-6 z-50">
            <div class="flex items-center gap-3">
                {{-- Tombol panah kembali --}}
                <button type="button"
                        onclick="window.location.href='{{ url('/') }}'"
                        class="p-2 rounded-full hover:bg-gray-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                         viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </button>

                <span class="font-medium text-sm md:text-base">
                    Dashboard Ormawa
                </span>
            </div>

            <button class="px-4 py-1.5 bg-orange-500 text-white text-xs font-semibold rounded-full hover:bg-orange-600"
                    onclick="window.location.href='{{ route('login') }}'">
                LOGIN
            </button>
        </header>

        {{-- KONTEN SCROLL --}}
        <main class="flex-1 overflow-y-auto pt-16">

            {{-- ================= AREA KANAN / KONTEN ================= --}}
            <div style="flex:1; display:flex; flex-direction:column;">

                {{-- =========== ISI HALAMAN ORMAWA ============ --}}
                <main style="flex:1; overflow-y:auto;">

                    @if ($ormawa->slug === 'bem')
                        {{-- ================== LAYOUT BEM (PERSIS KODE LAMA KAMU) ================== --}}

                        {{-- BAGIAN FOTO GEDUNG + TEKS WELCOME --}}
                        <div style="position:relative; height:340px; overflow:hidden; border-bottom-left-radius:20px; border-bottom-right-radius:20px;">
                            <img src="{{ asset('images/ith.jpg') }}"
                                 alt="Gedung ITH"
                                 style="width:100%; height:100%; object-fit:cover;">

                            <div style="
                                position:absolute; inset:0;
                                background:rgba(0,0,0,0.38);
                                display:flex; flex-direction:column;
                                align-items:center; justify-content:center;
                                text-align:center; padding:0 16px; color:white;">

                                <div style="font-size:22px; letter-spacing:2px; font-weight:500;">WELCOME</div>
                                <div style="font-size:15px; opacity:0.9;">TO</div>

                                <div style="font-size:30px; font-weight:800; margin-top:4px;">
                                    Badan Eksekutif Mahasiswa
                                </div>

                                <div style="font-size:15px; margin-top:6px; opacity:0.95;">
                                    Institut Teknologi Bacharuddin Jusuf Habibie
                                </div>
                            </div>
                        </div>

                        {{-- BAGIAN PUTIH --}}
                        <div style="background:white; padding:38px 24px 90px;">

                            {{-- LOGO --}}
                            <div style="display:flex; justify-content:center; margin-bottom:28px;">
                                <img src="{{ asset('images/logobem.png') }}"
                                     alt="BEM ITH 2025"
                                     style="width:120px; filter:drop-shadow(0 3px 6px rgba(0,0,0,0.15));">
                            </div>

                            {{-- CARD STRUCTURE, VISION, MISSION --}}
                            <div style="
                                display:grid;
                                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                                gap:24px;
                                max-width:1100px;
                                margin:0 auto;
                            ">

                                {{-- STRUCTURE --}}
                                <div style="
                                    background:white; padding:24px;
                                    border-radius:18px;
                                    box-shadow:0 6px 18px rgba(0,0,0,0.08);
                                ">
                                    <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:10px;">
                                        Organizational Structure
                                    </div>
                                    <div style="font-size:15px; color:#444; line-height:1.6;">
                                        The BEM consists of elected representatives...
                                    </div>
                                </div>

                                {{-- VISION --}}
                                <div style="
                                    background:white; padding:24px;
                                    border-radius:18px;
                                    box-shadow:0 6px 18px rgba(0,0,0,0.08);
                                ">
                                    <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:10px;">
                                        Vision
                                    </div>
                                    <div style="font-size:15px; color:#444; line-height:1.6;">
                                        Membuat BEM ITH menjadi organisasi yang peduli...
                                    </div>
                                </div>

                                {{-- MISSION --}}
                                <div style="
                                    background:white; padding:24px;
                                    border-radius:18px;
                                    box-shadow:0 6px 18px rgba(0,0,0,0.08);
                                ">
                                    <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:14px;">
                                        Mission
                                    </div>

                                    <div style="font-size:15px; color:#444; line-height:1.65; display:flex; flex-direction:column; gap:14px;">

                                        <div>
                                            <div style="font-weight:700; margin-bottom:4px;">Mendengar dan Menanggapi Suara Mahasiswa</div>
                                            <div>Saya ingin memastikan setiap mahasiswa merasa didengarkan baik itu Aspirasi,keluhan,
                                                 dan saran yang ada, akan saya respon dan tindaklanjuti dengan cepat dan terbuka, sehingga
                                                 BEM bisa benar-benar menjadi tempat kita menyuarakan kebutuhan bersama.</div>
                                        </div>

                                        <div>
                                            <div style="font-weight:700; margin-bottom:4px;">Mendorong Pengembangan Diri</div>
                                            <div>Mahasiswa Saya akan menyediakan ruang bagi mahasiswa untuk belajar hal-hal baru, mengasah keterampilan,
                                                 dan menemukan bakat mereka. Program pelatihan, mentoring, dan kegiatan pengembangan diri
                                                 akan saya buat agar semua mahasiswa bisa tumbuh sesuai potensinya.</div>
                                        </div>

                                        <div>
                                            <div style="font-weight:700; margin-bottom:4px;">Membangun Rasa Kebersamaan</div>
                                            <div>Saya ingin menciptakan suasana kampus yang penuh keakraban dan kekeluargaan. Melalui
                                                 kegiatan bersama antar-organisasi, saya akan memperkuat rasa saling mendukung dan kebersamaan
                                                 di antara kita, sehingga kampus menjadi lingkungan yang nyaman bagi semua.</div>
                                        </div>

                                        <div>
                                            <div style="font-weight:700; margin-bottom:4px;">Menggerakkan Aksi Sosial</div>
                                            <div>Bersama-sama, kita bisa memberi dampak positif bagi masyarakat sekitar dan lingkungan.
                                                 saya akan menginisiasi program-program yang menyentuh isu-isusosial dan lingkungan yang nyata,
                                                 agar kita bisa ikut terlibat dan berkontribusi bagi sekitar.</div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                    
                     @else
    {{-- =========== LAYOUT 3 KARTU UNTUK HERO / HCC / SENI / OLAHRAGA ============ --}}
    <div style="background:white; padding:38px 24px 90px;">

        {{-- LOGO UKM --}}
        <div style="display:flex; justify-content:center; margin-bottom:28px;">
            <img src="{{ asset($ormawa->logo) }}"
                 alt="{{ $ormawa->nama }}"
                 style="width:120px; filter:drop-shadow(0 3px 6px rgba(0,0,0,0.15));">
        </div>

        {{-- 3 KARTU: STRUCTURE, VISION, MISSION --}}
        <div style="
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap:24px;
            max-width:1100px;
            margin:0 auto;
        ">

            {{-- STRUCTURE --}}
            <div style="
                background:white; padding:24px;
                border-radius:18px;
                box-shadow:0 6px 18px rgba(0,0,0,0.08);
            ">
                <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:10px;">
                    Organizational Structure
                </div>
                <div style="font-size:15px; color:#444; line-height:1.6;">
                    @switch($ormawa->slug)
                        @case('hero')
                            Struktur organisasi UKM HERO terdiri dari ketua, wakil, sekretaris,
                            bendahara, divisi riset & pengembangan, serta divisi lomba dan pelatihan.
                            @break
                        @case('hcc')
                            Struktur HCC (Habibie Coding Club) terdiri dari ketua, wakil, sekretaris,
                            bendahara, divisi web, divisi mobile, dan divisi competitive programming.
                            @break
                        @case('seni')
                            Struktur UKM Seni mencakup ketua, wakil, sekretaris, bendahara,
                            divisi musik, divisi tari, dan divisi kreatif.
                            @break
                        @case('olahraga')
                            Struktur UKM Olahraga terdiri dari ketua, wakil, sekretaris, bendahara,
                            koordinator tiap cabang olahraga, serta divisi event.
                            @break
                        @default
                            Struktur organisasi {{ $ormawa->nama }} terdiri dari pengurus inti
                            dan beberapa divisi sesuai kebutuhan kegiatan.
                    @endswitch
                </div>
            </div>

            {{-- VISION --}}
            <div style="
                background:white; padding:24px;
                border-radius:18px;
                box-shadow:0 6px 18px rgba(0,0,0,0.08);
            ">
                <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:10px;">
                    Vision
                </div>
                <div style="font-size:15px; color:#444; line-height:1.6;">
                    @switch($ormawa->slug)
                        @case('hero')
                            Menjadi UKM robotika yang inovatif dan berprestasi di tingkat nasional,
                            serta menjadi wadah pengembangan teknologi bagi mahasiswa ITH.
                            @break
                        @case('hcc')
                            Menjadi komunitas coding yang produktif, inklusif, dan melahirkan
                            developer muda yang siap bersaing di dunia industri.
                            @break
                        @case('seni')
                            Menjadi ruang ekspresi seni mahasiswa yang kreatif, bernilai, dan
                            membawa warna positif bagi kehidupan kampus.
                            @break
                        @case('olahraga')
                            Menjadikan olahraga sebagai budaya hidup sehat di kampus dan
                            mencetak atlet-atlet berprestasi dari lingkungan ITH.
                            @break
                        @default
                            Menjadi organisasi mahasiswa yang aktif, bermanfaat, dan berdampak
                            bagi anggotanya maupun lingkungan kampus.
                    @endswitch
                </div>
            </div>

            {{-- MISSION --}}
            <div style="
                background:white; padding:24px;
                border-radius:18px;
                box-shadow:0 6px 18px rgba(0,0,0,0.08);
            ">
                <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:14px;">
                    Mission
                </div>

                <div style="font-size:15px; color:#444; line-height:1.65; display:flex; flex-direction:column; gap:14px;">
                    @switch($ormawa->slug)
                        @case('hero')
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Mengembangkan Minat Robotika</div>
                                <div>Menyelenggarakan pelatihan dasar hingga lanjutan mengenai elektronika,
                                     pemrograman, dan perakitan robot bagi mahasiswa.</div>
                            </div>
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Meningkatkan Prestasi</div>
                                <div>Mendorong anggota untuk aktif mengikuti kompetisi robotika tingkat lokal
                                     maupun nasional.</div>
                            </div>
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Membangun Komunitas</div>
                                <div>Mewujudkan suasana komunitas yang saling mendukung, belajar bersama,
                                     dan berbagi pengetahuan.</div>
                            </div>
                            @break

                        @case('hcc')
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Meningkatkan Skill Programming</div>
                                <div>Mengadakan kelas rutin tentang web, mobile, dan teknologi pemrograman lainnya.</div>
                            </div>
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Membangun Portofolio</div>
                                <div>Mendampingi anggota dalam mengerjakan project nyata yang bisa dijadikan
                                     portofolio.</div>
                            </div>
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Mendukung Kompetisi</div>
                                <div>Mempersiapkan tim untuk mengikuti lomba pemrograman dan hackathon.</div>
                            </div>
                            @break

                        @case('seni')
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Mewadahi Bakat Seni</div>
                                <div>Menyediakan ruang latihan dan penampilan bagi mahasiswa yang
                                     memiliki minat di bidang seni.</div>
                            </div>
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Mengadakan Event Seni</div>
                                <div>Menginisiasi pameran, konser, dan festival seni di lingkungan kampus.</div>
                            </div>
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Membangun Kolaborasi</div>
                                <div>Berkolaborasi dengan organisasi lain untuk menghadirkan acara seni yang
                                     lebih besar dan berdampak.</div>
                            </div>
                            @break

                        @case('olahraga')
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Mendorong Gaya Hidup Sehat</div>
                                <div>Mengajak mahasiswa rutin berolahraga melalui latihan terjadwal.</div>
                            </div>
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Meningkatkan Prestasi Olahraga</div>
                                <div>Membentuk dan melatih tim-tim olahraga untuk mewakili kampus di berbagai turnamen.</div>
                            </div>
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Mempererat Kebersamaan</div>
                                <div>Menggunakan kegiatan olahraga sebagai sarana mempererat hubungan
                                     antar mahasiswa lintas prodi.</div>
                            </div>
                            @break

                        @default
                            <div>
                                <div style="font-weight:700; margin-bottom:4px;">Mendukung Pengembangan Anggota</div>
                                <div>Menyelenggarakan program-program yang membantu anggota berkembang
                                     sesuai minat dan bakatnya.</div>
                            </div>
                    @endswitch
                </div>
            </div>

        </div>

    </div>
@endif
                </main>

            </div>

            <div style="background:white; padding:38px 24px 90px;">


                <!-- {{-- TOMBOL EDIT --}}
                <a href="#"
                    style="
                        position:fixed; right:24px; bottom:24px;
                        background:#ff7a1a; color:white;
                        border-radius:30px;
                        padding:10px 22px;
                        font-size:15px; font-weight:600;
                        text-decoration:none;
                        box-shadow:0 4px 10px rgba(0,0,0,0.2);
                    ">
                    Edit
                </a>
 -->
            </div>
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
