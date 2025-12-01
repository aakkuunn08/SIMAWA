@extends('layouts.main')

@section('content')

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
@endsection
