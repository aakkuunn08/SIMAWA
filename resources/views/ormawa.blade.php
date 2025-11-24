{{-- resources/views/ormawa.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>BEM ITH 2025</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased" style="margin:0; padding:0;">

<div style="min-height:100vh; background:#f5f5f5; display:flex; flex-direction:column;">

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
    <div style="flex:1; background:white; padding:38px 24px 90px;">

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
                    The BEM consists of elected representatives, committees, and advisory boards.
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
                    Membuat BEM ITH menjadi organisasi yang benar-benar peduli dan dekat dengan mahasiswa,
                    tempat kita bisa bersama-sama bertumbuh dan berkolaborasi baik untuk kampus maupun masyarakat.
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
            <div>
                Saya ingin memastikan setiap mahasiswa merasa didengarkan baik itu Aspirasi,keluhan,
                dan saran yang ada, akan saya respon dan tindaklanjuti dengan cepat dan terbuka, sehingga
                BEM bisa benar-benar menjadi tempat kita menyuarakan kebutuhan bersama.
            </div>
        </div>

        <div>
            <div style="font-weight:700; margin-bottom:4px;">Mendorong Pengembangan Diri dan Bakat Mahasiswa</div>
            <div>
                Saya akan menyediakan ruang bagi mahasiswa untuk belajar hal-hal baru, mengasah keterampilan,
                dan menemukan bakat mereka. Program pelatihan, mentoring, dan kegiatan pengembangan diri
                akan saya buat agar semua mahasiswa bisa tumbuh sesuai potensinya. 
                
            </div>
        </div>

        <div>
            <div style="font-weight:700; margin-bottom:4px;">Membangun Rasa Kebersamaan di Kampus</div>
            <div>
                Saya ingin menciptakan suasana kampus yang penuh keakraban dan kekeluargaan. Melalui
                kegiatan bersama antar-organisasi, saya akan memperkuat rasa saling mendukung dan kebersamaan 
                di antara kita, sehingga kampus menjadi lingkungan yang nyaman bagi semua.
            </div>
        </div>

        <div>
            <div style="font-weight:700; margin-bottom:4px;">Menggerakkan Aksi Sosial yang bermanfaat</div>
            <div>
                Bersama-sama, kita bisa memberi dampak positif bagi masyarakat sekitar dan lingkungan.
                saya akan menginisiasi program-program yang menyentuh isu-isusosial dan lingkungan yang nyata,
                agar kita bisa ikut terlibat dan berkontribusi bagi sekitar.
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

</body>
</html>
