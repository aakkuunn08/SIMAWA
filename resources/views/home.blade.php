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
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
        <div class="h-16 flex items-center px-6 border-b border-gray-200">
            <span class="font-semibold text-sm tracking-wide">SIMAWA ITH</span>
        </div>

        <nav class="flex-1 pt-4 text-sm">
            <a href="#kalender"
               class="flex items-center px-6 py-2 bg-orange-50 border-l-4 border-orange-500 text-gray-900">
                Kalender Kegiatan
            </a>
            <a href="#bem" class="flex items-center px-6 py-2 hover:bg-gray-100">
                Badan Eksekutif Mahasiswa
            </a>
            <a href="#news" class="flex items-center px-6 py-2 hover:bg-gray-100">
                NEWS
            </a>
            <a href="#ukm" class="flex items-center px-6 py-2 hover:bg-gray-100">
                Daftar UKM
            </a>
            <a href="#tes-minat" class="flex items-center px-6 py-2 hover:bg-gray-100">
                Tes Minat
            </a>
        </nav>
    </aside>

    {{-- KONTEN KANAN --}}
    <div class="flex-1 flex flex-col">

        {{-- NAVBAR ATAS --}}
        <header class="h-16 bg-white shadow flex items-center justify-between px-6">
            <div class="font-medium text-sm">Dashboard</div>
            <button class="px-4 py-1.5 bg-orange-500 text-white text-xs font-semibold rounded-full hover:bg-orange-600">
                LOGIN
            </button>
        </header>

        {{-- KONTEN SCROLL --}}
        <main class="flex-1 overflow-y-auto">

            {{-- HERO ABU-ABU + JUDUL --}}
            <section id="kalender" class="bg-gray-600 text-white text-center py-16">
                <p class="text-xs tracking-[0.3em] mb-2">WELCOME TO</p>
                <h1 class="text-4xl font-bold mb-2">SIMAWA</h1>
                <p class="text-sm">
                    Institut Teknologi Bacharuddin Jusuf Habibie — Sistem Informasi Organisasi Mahasiswa
                </p>
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
                        <button class="px-3 py-1 rounded hover:bg-gray-200">&lsaquo;</button>
                        <span class="font-semibold text-orange-500">November, 2022</span>
                        <button class="px-3 py-1 rounded hover:bg-gray-200">&rsaquo;</button>
                    </div>
                </div>

            {{-- AREA ABU-ABU TUA + KALENDER --}}
    <div class="bg-gray-300 px-8 py-6">
    <div class="bg-gray-300 px-8 py-6 w-full max-w-2xl mx-auto">
    <!-- <table class="w-full text-sm border-separate border-spacing-y-10"> -->
        <div class="grid grid-cols-7 gap-4 mb-4 text-sm text-center"
                    <div class="grid grid-cols-7 gap-4 mb-4 text-sm text-center">
                        <div class="font-semibold">Minggu</div>
                        <div class="font-semibold">Senin</div>
                        <div class="font-semibold">Selasa</div>
                        <div class="font-semibold">Rabu</div>
                        <div class="font-semibold">Kamis</div>
                        <div class="font-semibold">Jumat</div>
                        <div class="font-semibold">Sabtu</div>
                    </div>

        <tbody>
            {{-- baris 1 --}}
            <tr>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center">1</td>
                <td class="text-center">2</td>
                <td class="text-center">3</td>
                <td class="text-center">4</td>
            </tr>

            {{-- baris 2 --}}
            <tr>
                <td class="text-center"></td>
                <td class="text-center">6</td>
                <td class="text-center">7</td>
                <td class="text-center">8</td>
                <td class="text-center">9</td>
                <td class="text-center">10</td>
                <td class="text-center">11</td>
            </tr>

            {{-- baris 3 (tanggal 16 ada event) --}}
            <tr>
                <td class="text-center">13</td>
                <td class="text-center">14</td>
                <td class="text-center">15</td>
                <td class="text-center">
                    <div class="flex flex-col items-center">
                        <div
                            class="w-8 h-8 flex items-center justify-center rounded-full bg-orange-500 text-white text-xs">
                            16
                        </div>
                        <span class="mt-1 text-[10px] leading-3 text-red-700 text-center">
                            Seminar
                        </span>
                    </div>
                </td>
                <td class="text-center">17</td>
                <td class="text-center">18</td>
                <td class="text-center">19</td>
            </tr>

            {{-- baris 4 --}}
            <tr>
                <td class="text-center">20</td>
                <td class="text-center">21</td>
                <td class="text-center">22</td>
                <td class="text-center">23</td>
                <td class="text-center">24</td>
                <td class="text-center">25</td>
                <td class="text-center">26</td>
            </tr>

            {{-- baris 5 --}}
            <tr>
                <td class="text-center">27</td>
                <td class="text-center">28</td>
                <td class="text-center">29</td>
                <td class="text-center">30</td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
            </tr>
        </tbody>
    </table>
</div>


            {{-- BEM --}}
            <section id="bem" class="bg-white mt-6 px-10 pt-10 pb-8">
                <h2 class="text-center text-lg font-semibold mb-6">
                    Badan Eksekutif Mahasiswa
                </h2>

                <div class="flex flex-col items-center gap-6">
                    <div
                        class="w-32 h-32 rounded-xl border-4 border-gray-800 flex items-center justify-center overflow-hidden">
                        {{-- ganti src logo sesuai file kamu --}}
                        <img src="https://via.placeholder.com/120x120?text=BEM"
                             alt="Logo BEM" class="object-cover w-full h-full">
                    </div>

                    <p class="max-w-3xl text-sm text-gray-700 leading-relaxed text-center">
                        Badan Eksekutif Mahasiswa hadir sebagai penggerak utama dinamika kampus. Melalui
                        nilai-nilai kepemimpinan, integritas, dan pelayanan, BEM berupaya memberikan ruang bagi
                        mahasiswa untuk tumbuh, memimpin, dan berkontribusi secara nyata.
                    </p>
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
            <section id="ukm" class="bg-[#f3b7a0] px-10 pt-8 pb-10 mt-2">
                <h2 class="text-center text-lg font-semibold mb-6 uppercase">DAFTAR UKM</h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    <div class="bg-white rounded-xl border border-gray-800 flex flex-col items-center justify-center py-6">
                        <img src="https://via.placeholder.com/80x80?text=HERO" class="mb-2" alt="">
                        <span class="font-semibold text-xs">HERO</span>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-800 flex flex-col items-center justify-center py-6">
                        <img src="https://via.placeholder.com/80x80?text=HCC" class="mb-2" alt="">
                        <span class="font-semibold text-xs">HCC</span>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-800 flex flex-col items-center justify-center py-6">
                        <span class="font-semibold text-xs">SENI</span>
                    </div>
                    <div class="bg-white rounded-xl border border-gray-800 flex flex-col items-center justify-center py-6">
                        <span class="font-semibold text-xs">OLAHRAGA</span>
                    </div>
                </div>
            </section>

            {{-- TES MINAT --}}
            <section id="tes-minat" class="bg-white py-10 text-center">
                <h3 class="text-sm font-semibold mb-3 tracking-wide">TES MINAT</h3>
                <button
                    class="px-6 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600">
                    Ayo Mulai Tes!
                </button>
            </section>

        </main>
    </div>
</div>

</body>
</html>
