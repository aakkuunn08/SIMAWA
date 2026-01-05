@extends(auth()->check() ? 'layouts.main' : 'layouts.landing')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- TOMBOL EDIT UTAMA (KHUSUS ADMIN BEM) --}}
@auth
    @if(auth()->user()->hasRole('adminbem'))
        <button id="toggleEditMode" 
            class="fixed top-20 right-6 z-50 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 border-0">
            <span class="edit-mode-text font-bold">Edit Halaman</span>
        </button>
    @endif
@endauth

{{-- AREA KONTEN UTAMA --}}
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px; background: white;">
        
        @if ($ormawa->slug === 'bem')
            {{-- BEM --}}
            <div class="position-relative" style="height:300px; overflow:hidden;">
                <img src="{{ asset('images/ith.jpg') }}" alt="Gedung ITH" class="w-full h-full object-fit-cover">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column align-items-center justify-content-center text-center p-3" style="background:rgba(0,0,0,0.45); color:white;">
                    <h5 class="text-uppercase" style="letter-spacing: 2px;">Welcome To</h5>
                    <h2 class="fw-bold">Badan Eksekutif Mahasiswa</h2>
                    <p class="opacity-75">Institut Teknologi Bacharuddin Jusuf Habibie</p>
                </div>
            </div>
            {{-- LOGO BEM DI TENGAH --}}
            <div class="d-flex justify-content-center" style="margin-top: -50px; position: relative; z-index: 5;">
                <img src="{{ asset('images/logobem.png') }}" class="rounded-circle bg-white shadow p-2" style="width:100px; height:100px;">
            </div>
        @else
            {{-- HERO UKM (LOGO DI TENGAH) --}}
            <div class="text-center py-5 border-bottom bg-light d-flex justify-content-center">
                <img src="{{ asset($ormawa->logo) }}" alt="{{ $ormawa->nama }}" style="width:120px; filter:drop-shadow(0 3px 6px rgba(0,0,0,0.1)); margin: 0 auto">
            </div>
        @endif


        <div class="card-body p-4">

        {{-- Bagian Vision & Mission --}}
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="p-4 rounded-4 shadow-sm border bg-white h-100 d-flex flex-column">
                    <div class="d-flex align-items-center mb-3 gap-2">
                        <h4 class="section-header" style="color: #ff7a1a;">Vision</h4>
                        @auth
                            @if(auth()->user()->hasRole('adminbem'))
                                <button class="edit-control d-none btn btn-sm btn-primary border-0 rounded-circle p-0" 
                                        style="width: 28px; height: 28px; line-height: 1;" 
                                        onclick="editContent('vision')" aria-label="Edit Vision">
                                    ✎
                                </button>
                            @endif
                        @endauth
                    </div>
                    <div class="editable-content text-secondary" data-field="vision">
                        {!! $ormawa->vision ?? 'Belum ada visi.' !!}
                    </div>
                </div>
            </div>

            <div class="p-4 rounded-4 shadow-sm border bg-white h-100 d-flex flex-column">
                <div class="d-flex align-items-center mb-3 gap-2">
                    <h4 class="section-header" style="color: #ff7a1a;">Mission</h4>
                    @auth
                        @if(auth()->user()->hasRole('adminbem'))
                            <button class="edit-control d-none btn btn-sm btn-primary border-0 rounded-circle p-0" 
                                    style="width: 28px; height: 28px; line-height: 1;" 
                                    onclick="editContent('mission')" aria-label="Edit Mision">
                                ✎
                            </button>
                        @endif
                    @endauth
                </div>
                <div class="editable-content text-secondary" data-field="mission">
                    {!! $ormawa->mission ?? 'Belum ada misi.' !!}
                </div>
            </div>
        </div>

        {{-- Organizational Structure --}}
        <div class="p-4 rounded-4 shadow-sm border bg-white">
            <h4 class="section-header" style="color: #ff7a1a;">Organizational Structure</h4>

            @php
                // Pastikan data struktur dipecah sesuai format: ketua = nama, jabatan = array jabatan
                $structure = json_decode($ormawa->structure ?? '{"ketua":"","jabatan":[]}', true);
            @endphp

            <div class="structure-view">
                {{-- Jabatan Ketua tetap hardcoded --}}
                <div class="d-flex justify-content-between border-bottom pb-2 mb-3">
                    <span class="fw-bold text-dark" style="min-width: 150px;">Ketua</span>
                    <span class="text-dark">{{ $structure['ketua'] ?? '-' }}</span>
                </div>

                {{-- Tampilkan semua jabatan --}}
                @foreach ($structure['jabatan'] ?? [] as $jabatan)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom border-light" style="gap: 10px;">
                        <span class="fw-bold text-dark" style="min-width: 150px;">{{ $jabatan['jabatan'] }}</span>
                        <span class="text-dark">{{ $jabatan['nama'] }}</span>
                    </div>

                    {{-- Jika ada anggota, tampilkan dengan indentasi --}}
                    @foreach ($jabatan['anggota'] ?? [] as $anggota)
                        <div class="d-flex justify-content-end py-1 text-muted small" style="padding-right: 10px;">
                            <span class="fw-normal text-end">• {{ $anggota }}</span>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>


                {{-- FORM EDIT STRUKTUR (KHUSUS ADMIN BEM) --}}
                @auth @if(auth()->user()->hasRole('adminbem'))
                <div class="structure-edit d-none mt-4">
                    <div class="row align-items-center mb-4">
                        <div class="col-auto fw-bold">Ketua</div>
                        <div class="col"><input id="ketuaInput" class="form-control" value="{{ $structure['ketua'] ?? '' }}"></div>
                    </div>
                    <div id="jabatanWrapper">
                        @foreach ($structure['jabatan'] ?? [] as $j)
                            <div class="jabatan-item mb-4 p-3 border border-dashed rounded-3">
                                <div class="row g-2 mb-3">
                                    <div class="col-6"><input class="jabatan-nama form-control fw-bold" value="{{ $j['jabatan'] }}" placeholder="Jabatan"></div>
                                    <div class="col-6"><input class="jabatan-orang form-control" value="{{ $j['nama'] }}" placeholder="Nama"></div>
                                </div>
                                <div class="anggota-wrapper ms-4 mb-2">
                                    @foreach ($j['anggota'] ?? [] as $ang)
                                        <input class="anggota-input form-control form-control-sm mb-2" value="{{ $ang }}">
                                    @endforeach
                                </div>
                                <button onclick="addAnggota(this)" class="btn btn-sm btn-link p-0 text-decoration-none" style="color: #ff7a1a;">+ Add Anggota</button>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button onclick="addJabatan()" class="btn text-white fw-bold" style="background: #ff7a1a;">+ Add Position</button>
                        <button onclick="saveStructure()" class="btn btn-success fw-bold">Simpan Struktur</button>
                    </div>
                </div>
                @endif @endauth
            </div>
        </div>
    </div>
</div>

{{-- WHATSAPP FLOATING BUTTON --}}
@if($ormawa->whatsapp)
    @php $phone = preg_replace('/\D/', '', $ormawa->whatsapp); @endphp
    <a href="https://api.whatsapp.com/send?phone={{ $phone }}" target="_blank" 
       class="fixed bottom-6 right-6 z-50 bg-green-500 text-white p-3 rounded-circle shadow-lg d-flex align-items-center justify-content-center text-decoration-none"
       style="width: 60px; height: 60px; font-size: 30px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" viewBox="0 0 16 16"><path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.104-1.08a7.863 7.863 0 0 0 3.89.976h.004c4.367 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.17-.478 1.338-.942.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/></svg>
    </a>
@endif

{{-- TOMBOL SET WA (ADMIN ONLY) --}}
@auth @if(auth()->user()->hasRole('adminbem'))
<div class="edit-control d-none fixed bottom-24 right-6 z-50">
    <button onclick="editWhatsApp()" class="btn btn-primary rounded-circle shadow p-3 border-0">📞</button>
</div>
@endif @endauth

<script>
    let editMode = false;
    const ormawaSlug = '{{ $ormawa->slug }}';

    // Toggle Edit
    document.getElementById('toggleEditMode')?.addEventListener('click', function() {
        editMode = !editMode;
        document.querySelector('.structure-view')?.classList.toggle('d-none', editMode);
        document.querySelector('.structure-edit')?.classList.toggle('d-none', !editMode);
        document.querySelectorAll('.edit-control').forEach(el => el.classList.toggle('d-none', !editMode));
        this.classList.toggle('bg-green-500', editMode);
        this.classList.toggle('bg-orange-500', !editMode);
        this.querySelector('.edit-mode-text').textContent = editMode ? 'Selesai' : 'Edit';
    });

    //edit wa agar bisa diinput
    async function saveToServer(field, content) {
        Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        try {
            const res = await fetch(`/ormawa/${ormawaSlug}/update-content`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ field, content })
            });

            const data = await res.json();

            if (res.ok) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', timer: 1000, showConfirmButton: false });

                if(field === 'whatsapp') {
                    // Update link tombol WhatsApp floating tanpa reload halaman
                    const phone = content.replace(/\D/g, '');
                    const waButton = document.querySelector('a[href^="https://api.whatsapp.com/send"]');
                    if(waButton){
                        waButton.href = `https://api.whatsapp.com/send?phone=${phone}`;
                    }
                } else {
                    // Reload halaman setelah save untuk field lain
                    setTimeout(() => location.reload(), 1100);
                }

            } else {
                Swal.fire('Error', data.message || 'Gagal menyimpan. Cek koneksi server.', 'error');
            }
        } catch (e) {
            Swal.fire('Error', 'Gagal menyimpan. Cek koneksi server.', 'error');
        }
    }

    function editContent(field) {
    const current = document.querySelector(`[data-field="${field}"]`).innerText.trim();
    Swal.fire({
        title: 'Edit ' + field.charAt(0).toUpperCase() + field.slice(1),
        input: 'textarea',
        inputValue: current,
        showCancelButton: true,
        confirmButtonColor: '#ff7a1a'
    }).then(res => { 
        if(res.isConfirmed) saveToServer(field, res.value);
    });
}

    function editWhatsApp() {
    Swal.fire({
        title: 'Nomor WhatsApp',
        input: 'text',
        inputAttributes: { maxlength: 15, oninput: "this.value=this.value.replace(/[^0-9]/g,'');" },
        inputValue: '{{ $ormawa->whatsapp }}',
        showCancelButton: true,
        confirmButtonColor: '#ff7a1a'
    }).then(res => {
        if(res.isConfirmed) {
            // Validate minimum length here if needed
            if(res.value && res.value.length >= 8){
                saveToServer('whatsapp', res.value);
            }else{
                Swal.fire('Error', 'Nomor WhatsApp tidak valid.', 'error');
            }
        }
    });
}
    // }

    function addJabatan() {
        const div = document.createElement('div');
        div.className = 'jabatan-item mb-4 p-3 border border-dashed rounded-3';
        div.innerHTML = `<div class="row g-2 mb-3"><div class="col-6"><input class="jabatan-nama form-control fw-bold" placeholder="Jabatan"></div><div class="col-6"><input class="jabatan-orang form-control" placeholder="Nama"></div></div><div class="anggota-wrapper ms-4 mb-2"></div><button onclick="addAnggota(this)" class="btn btn-sm btn-link p-0 text-decoration-none" style="color: #ff7a1a;">+ Add Anggota</button>`;
        document.getElementById('jabatanWrapper').appendChild(div);
    }

    function addAnggota(btn) {
        const input = document.createElement('input');
        input.className = 'anggota-input form-control form-control-sm mb-2';
        input.placeholder = 'Nama Anggota';
        btn.parentElement.querySelector('.anggota-wrapper').appendChild(input);
    }

    async function saveStructure() {
        const data = { ketua: document.getElementById('ketuaInput').value, jabatan: [] };
        document.querySelectorAll('.jabatan-item').forEach(el => {
            const n = el.querySelector('.jabatan-nama').value;
            const o = el.querySelector('.jabatan-orang').value;
            if(n) {
                const ang = [];
                el.querySelectorAll('.anggota-input').forEach(a => { if(a.value) ang.push(a.value); });
                data.jabatan.push({ jabatan: n, nama: o, anggota: ang });
            }
        });
        saveToServer('structure', JSON.stringify(data));
    }
</script>

<style>
    .d-none { display: none !important; }
    .object-fit-cover { object-fit: cover; }
    
    /* Menjaga Sidebar tetap aman */
    .container-fluid { width: 100% !important; max-width: 100% !important; }
    structure-view > div {
    padding-left: 0.5rem;
    padding-right: 0.5rem;}
    .structure-view > div.d-flex {
    gap: 10px;
    }

    .structure-view span.fw-bold {
        min-width: 150px;
        display: inline-block;
    }
    .edit-control.btn {
    padding: 0.2rem 0.5rem;
    font-size: 14px;
    cursor: pointer;
    }
    .structure-view table tbody tr td {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    vertical-align: middle;
    }
    .section-header {
    color: #ff7a1a;
    font-weight: 700;  /* sama dengan fw-bold */
    font-size: 1.1rem;  /* bisa disesuaikan */
    border-bottom: 2px solid #ff7a1a;
    padding-bottom: 0.25rem;
    margin-bottom: 1.5rem;
    text-transform: uppercase; /* opsi agar uppercase */
    letter-spacing: 1.5px;     /* opsi agar lebih rapi */
}
</style>
@endsection