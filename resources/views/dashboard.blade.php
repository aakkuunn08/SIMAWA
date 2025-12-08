@extends('layouts.main')

@section('content')
    {{-- SECTION HERO --}}
    <section class="relative w-full min-h-[calc(110vh-4rem)] md:min-h-[calc(100vh-4rem)]">
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
    <div class="mt-10 flex flex-col items-center">
        <div class="w-full max-w-4xl px-4 flex flex-col items-center">
            {{-- SEARCH --}}
            <div class="relative mx-auto w-full max-w-xs">
                <input type="text" placeholder="Cari Kegiatan"
                    class="px-4 py-2 w-full bg-gray-100 rounded-md border focus:outline-none focus:ring-2 focus:ring-orange-400">
                <button class="absolute right-3 top-2.5 text-gray-600 hover:text-gray-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.2-5.2m0 0A7 7 0 1 0 5 5a7 7 0 0 0 10.8 10.8Z" />
                    </svg>
                </button>
            </div>

            {{-- NAVIGASI BULAN --}}
            <div class="flex items-center gap-4 justify-center mt-4 mb-4">
                <button id="prevBtn" class="px-3 py-1 rounded hover:bg-gray-200 text-lg">&lsaquo;</button>
                <span id="monthLabel" class="font-semibold text-orange-500 text-lg md:text-xl lg:text-2xl">
                    {{ date('F, Y') }}
                </span>
                <button id="nextBtn" class="px-3 py-1 rounded hover:bg-gray-200 text-lg">&rsaquo;</button>
            </div>
        </div>
    </div>

    {{-- AREA KALENDER --}}
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
            <div id="calendarGrid" class="grid grid-cols-7 gap-y-6 gap-x-4 text-center text-sm"></div>
            
            {{-- TOMBOL EDIT KEGIATAN --}}
            @auth
                @if(auth()->user()->hasRole('adminbem','adminukm'))
                <div class="flex justify-end mt-6">
                    <button onclick="openAddModal()" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 font-semibold text-sm shadow-lg transition duration-200">
                        + Tambah Kegiatan
                    </button>
                </div>
                @endif
            @endauth
        </div>
    </section>

    {{-- MODAL INPUT KEGIATAN --}}
    @auth
        @if(auth()->user()->hasRole('adminbem','adminukm'))
        <div id="addModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                {{-- Header --}}
                <div class="bg-red-600 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                    <h3 class="text-lg font-bold">Input Kegiatan</h3>
                    <button onclick="closeAddModal()" class="text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
                </div>
                
                {{-- Form --}}
                <form id="kegiatanForm" class="p-6 space-y-4">
                    @csrf
                    <input type="hidden" id="kegiatan_id" name="kegiatan_id">
                    
                    {{-- Jadwal (Tanggal) --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 flex items-center justify-center flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-semibold mb-1">Jadwal</label>
                            <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>

                    {{-- Waktu --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 flex items-center justify-center flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1 grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-semibold mb-1">Waktu Mulai</label>
                                <input type="time" id="waktu_mulai" name="waktu_mulai" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold mb-1">Waktu Selesai</label>
                                <input type="time" id="waktu_selesai" name="waktu_selesai" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                            </div>
                        </div>
                    </div>

                    {{-- Kegiatan --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 flex items-center justify-center flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-semibold mb-1">Kegiatan</label>
                            <input type="text" id="nama_kegiatan" name="nama_kegiatan" required
                                placeholder="Nama kegiatan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>

                    {{-- Tempat --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 flex items-center justify-center flex-shrink-0 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-semibold mb-1">Tempat</label>
                            <input type="text" id="tempat" name="tempat" required
                                placeholder="Lokasi kegiatan"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-end gap-2 pt-4">
                        <button type="button" onclick="closeAddModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-semibold">
                            Batal
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 bg-orange-600 text-white rounded-md hover:bg-orange-700 font-semibold">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- MODAL DETAIL KEGIATAN --}}
        <div id="detailModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                {{-- Header --}}
                <div class="bg-red-600 text-white px-6 py-4 rounded-t-lg flex justify-between items-center">
                    <h3 id="detailTitle" class="text-lg font-bold">Detail Kegiatan</h3>
                    <button onclick="closeDetailModal()" class="text-white hover:text-gray-200 text-2xl leading-none">&times;</button>
                </div>
                
                {{-- Content --}}
                <div class="p-6 space-y-4">
                    {{-- Jadwal --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p id="detailJadwal" class="text-sm"></p>
                        </div>
                    </div>

                    {{-- Kegiatan --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p id="detailKegiatan" class="text-sm"></p>
                        </div>
                    </div>

                    {{-- Tempat --}}
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p id="detailTempat" class="text-sm"></p>
                        </div>
                    </div>

                    {{-- Buttons (Only for Admin) --}}
                    <div class="flex justify-end gap-2 pt-4">
                        <button type="button" onclick="closeDetailModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-semibold">
                            Tutup
                        </button>
                        <button type="button" onclick="editKegiatan()" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-semibold">
                            Edit
                        </button>
                        <button type="button" onclick="deleteKegiatan()" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 font-semibold">
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endauth

    {{-- BEM --}}
    <section id="bem" class="bg-white mt-6 px-10 pt-10 pb-8">
        <h2 class="text-center text-lg font-semibold mb-6">Badan Eksekutif Mahasiswa</h2>
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <div class="w-32 h-32 rounded-xl border-4 border-gray-800 flex items-center justify-center overflow-hidden flex-shrink-0">
                <a href="{{ route('ormawa.show', 'bem') }}" title="BEM"
                    class="w-full h-full items-center justify-center block hover:opacity-90">
                    <img src="/images/logobem.png" alt="BEM Logo" class="w-full h-full object-contain">
                </a>
            </div>
            <div class="flex-1">
                <p class="max-w-3xl text-sm text-gray-700 leading-relaxed text-left">
                    Badan Eksekutif Mahasiswa hadir sebagai penggerak utama dinamika kampus...
                </p>
            </div>
        </div>
    </section>

    {{-- NEWS --}}
    <section id="news" class="bg-white px-10 pt-8 pb-10">
        <h2 class="text-center text-lg font-semibold mb-6 uppercase">NEWS</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
            {{-- Contoh Berita --}}
            <article class="flex flex-col">
                <img src="https://via.placeholder.com/350x180?text=News+1" class="rounded-lg mb-2 object-cover w-full h-40" alt="">
                <p class="font-semibold mb-1">Mitraindonesia, Parepare – Habibie Robotic Competition (HRC) 2025...</p>
                <p class="text-gray-700">Kegiatan tahunan Unit Kegiatan Mahasiswa...</p>
            </article>
            <article class="flex flex-col">
                <img src="https://via.placeholder.com/350x180?text=News+2" class="rounded-lg mb-2 object-cover w-full h-40" alt="">
                <p class="font-semibold mb-1">Parepare, 29/05/2025 – ITH Futsal Cup resmi bergulir...</p>
                <p class="text-gray-700">Turnamen futsal antar program studi...</p>
            </article>
            <article class="flex flex-col">
                <img src="https://via.placeholder.com/350x180?text=News+3" class="rounded-lg mb-2 object-cover w-full h-40" alt="">
                <p class="font-semibold mb-1">ITH Sukses Laksanakan Festival Seni...</p>
                <p class="text-gray-700">Festival seni yang menghadirkan berbagai penampilan mahasiswa...</p>
            </article>
        </div>

        {{-- FITUR KHUSUS ADMIN: TOMBOL EDIT --}}
        @role('adminbem|adminukm')
        <div class="flex justify-end mt-4">
            <button class="px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 text-sm font-semibold">
                Edit Berita
            </button>
        </div>
        @endrole
    </section>

    {{-- DAFTAR UKM --}}
    <section id="ukm" class="bg-[#edb59fc2] px-6 pt-8 pb-10 mt-2">
        <h2 class="text-center text-lg font-semibold mb-6 uppercase">DAFTAR UKM/SC</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 items-start">
            @foreach ($ormawas->where('tipe', 'ukm') as $item)
                <div class="flex flex-col items-center">
                    <div class="bg-white rounded-xl border border-gray-800 w-full h-40 flex items-center justify-center overflow-hidden">
                        <a href="{{ route('ormawa.show', $item->slug) }}" class="w-full h-full flex items-center justify-center">
                            <img src="{{ asset($item->logo) }}" alt="{{ $item->nama }}" class="max-h-full max-w-full object-contain">
                        </a>
                    </div>
                    <span class="mt-3 text-center font-semibold text-xs">{{ strtoupper($item->nama) }}</span>
                </div>
            @endforeach
        </div>
    </section>

    {{-- TES MINAT --}}
    <section id="tes-minat" class="bg-white py-10 text-center">     
        @auth
            @if(auth()->user()->isAdminBem())
                {{-- Untuk Admin BEM: Link ke halaman kelola tes minat --}}
                <h3 class="text-sm font-semibold mb-3 tracking-wide">TES MINAT</h3>
                <a href="{{ route('tesminatbem.results') }}"
                    class="inline-block px-6 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600">
                    Kelola Tes Minat
                </a>
            @elseif(auth()->user()->isAdminUkm())
                {{--Admin UKM: Tidak ada keperluan ke tes minat--}}
            @else
                {{-- Untuk user biasa/mahasiswa: Link ke halaman isi tes minat --}}
                <a href="{{ route('tesminat.index') }}"
                    class="inline-block px-6 py-2 bg-orange-500 text-white rounded-full text-sm font-semibold hover:bg-orange-600">
                    Ayo Mulai Tes!
                </a>
            @endif
        @else
            {{-- Untuk guest (belum login): Link ke halaman isi tes minat --}}
            <h3 class="text-sm font-semibold mb-3 tracking-wide">TES MINAT</h3>
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
                alert('Gagal memuat detail kegiatan');
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
                alert('Gagal memuat data kegiatan');
            });
    }

    function deleteKegiatan() {
        if (!currentEventId) return;
        
        if (!confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')) return;
        
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
                alert('Kegiatan berhasil dihapus');
                closeDetailModal();
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menghapus kegiatan');
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
                        alert(data.message);
                        closeAddModal();
                        location.reload();
                    } else {
                        alert('Error: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Gagal menyimpan kegiatan: ' + error.message);
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
                cell.className = 'flex flex-col items-center justify-start h-auto min-h-16 py-2';

                const dateEl = document.createElement('div');
                dateEl.textContent = d;
                dateEl.className = 'text-sm mb-1';

                if (year === today.getFullYear() && month === today.getMonth() && d === today.getDate()) {
                    dateEl.className += ' w-8 h-8 flex items-center justify-center rounded-full bg-orange-500 text-white';
                }
                cell.appendChild(dateEl);

                const key = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
                if (events[key]) {
                    const eventList = Array.isArray(events[key]) ? events[key] : [events[key]];
                    eventList.forEach(event => {
                        const ev = document.createElement('div');
                        ev.className = 'mt-1 text-[10px] leading-3 text-red-700 text-center cursor-pointer hover:underline px-1';
                        
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