{{-- resources/views/ormawa.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BEM ITH 2025</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased" style="margin:0; padding:0; background:#f5f5f5;">

<div style="display:flex; min-height:100vh; width:100%;">

    {{-- ================= SIDEBAR ================= --}}
    <aside style="
        width:240px; 
        background:white;
        border-right:1px solid #e5e7eb;
        padding-top:16px;
        position:sticky;
        top:0;
        height:100vh;
    ">
        <div style="padding:12px 20px; font-weight:700; font-size:15px;">
            SIMAWA ITH
        </div>

        <nav style="margin-top:10px; font-size:14px;">
            <a href="/kalender"
                style="display:block; padding:10px 20px; color:#333; text-decoration:none;"
                onmouseover="this.style.background='#f3f4f6'"
                onmouseout="this.style.background='transparent'">
                Kalender Kegiatan
            </a>

            <a href="/bem"
                style="display:block; padding:10px 20px; color:#333; text-decoration:none;"
                onmouseover="this.style.background='#f3f4f6'"
                onmouseout="this.style.background='transparent'">
                Badan Eksekutif Mahasiswa
            </a>

            <a href="/news"
                style="display:block; padding:10px 20px; color:#333; text-decoration:none;"
                onmouseover="this.style.background='#f3f4f6'"
                onmouseout="this.style.background='transparent'">
                NEWS
            </a>

            <a href="/ukm"
                style="display:block; padding:10px 20px; color:#333; text-decoration:none;"
                onmouseover="this.style.background='#f3f4f6'"
                onmouseout="this.style.background='transparent'">
                Daftar UKM/SC
            </a>

            <a href="/tes-minat"
                style="display:block; padding:10px 20px; color:#333; text-decoration:none;"
                onmouseover="this.style.background='#f3f4f6'"
                onmouseout="this.style.background='transparent'">
                Tes Minat
            </a>
        </nav>
    </aside>

    {{-- ================= AREA KANAN / KONTEN ================= --}}
    <div style="flex:1; display:flex; flex-direction:column;">

        {{-- =========== NAVBAR ATAS ============ --}}
        <header style="
            height:58px; 
            background:white;
            border-bottom:1px solid #e5e7eb;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 22px;
        ">
            <div style="font-size:15px; font-weight:600;">Dashboard Ormawa</div>

            <button onclick="window.location.href='{{ route('login') }}'"
                style="
                    background:#ff7a1a;
                    color:white;
                    padding:6px 20px;
                    font-size:13px;
                    font-weight:600;
                    border-radius:20px;
                    border:none;
                    cursor:pointer;
                ">
                LOGIN
            </button>
        </header>

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

                {{-- TOMBOL EDIT --}}
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

            </div>
        </main>

    </div>

</div>

</body>
</html>
