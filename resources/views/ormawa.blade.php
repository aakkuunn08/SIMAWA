{{-- resources/views/ormawa.blade.php --}}
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
    <a href="{{ route('home') }}#kalender" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
        Kalender Kegiatan
    </a>
    <a href="{{ route('home') }}#bem" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
        Badan Eksekutif Mahasiswa
    </a>
    <a href="{{ route('home') }}#news" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
        NEWS
    </a>
    <a href="{{ route('home') }}#ukm" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
        Daftar UKM/SC
    </a>
    <a href="{{ route('home') }}#tes-minat" class="nav-link flex items-center px-6 py-2 hover:bg-gray-100">
        Tes Minat
    </a>
</nav>

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
        <main class="flex-1 overflow-y-auto">

            {{-- ================= AREA KANAN / KONTEN ================= --}}
            <div style="flex:1; display:flex; flex-direction:column;">

                {{-- =========== ISI HALAMAN ORMAWA (kode lama kamu) ============ --}}
                <main style="flex:1; overflow-y:auto;">

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

                </main>

            </div>

        </main>

    </div>

</div>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const links = Array.from(document.querySelectorAll("aside .nav-link"));
    let skipObserverUntil = 0; // disable observer briefly after clicking
    const setActive = (link) => {
        links.forEach(l => l.classList.remove("bg-gray-200"));
        link.classList.add("bg-gray-200");
    };

    // scroll to section smoothly on click
    links.forEach(link => {
        link.addEventListener("click", (e) => {
            const target = document.querySelector(link.getAttribute("href"));
            if (target) {
                e.preventDefault();
                skipObserverUntil = Date.now() + 800;
                setActive(link);
                target.scrollIntoView({ behavior: "smooth", block: "start" });
            }
        });
    });

    // observe section visibility to highlight active
    const sections = links
        .map(l => document.querySelector(l.getAttribute("href")))
        .filter(Boolean);

    if (sections.length) {
        const observer = new IntersectionObserver((entries) => {
            if (Date.now() < skipObserverUntil) return;

            let best = entries[0];
            for (const e of entries) {
                if (e.intersectionRatio > (best?.intersectionRatio ?? 0)) best = e;
            }
            if (!best) return;

            if (best.intersectionRatio > 0.01) {
                const id = "#" + best.target.id;
                const link = document.querySelector(`aside .nav-link[href="${id}"]`);
                if (link) setActive(link);
            }
        }, {
            root: null,
            rootMargin: "-20% 0px -50% 0px",
            threshold: [0, 0.25, 0.5, 0.75, 1]
        });

        sections.forEach(section => observer.observe(section));
    }
});
</script>
</body>
</html>
