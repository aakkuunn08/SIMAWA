@extends('layouts.main')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- TOMBOL EDIT FIXED (HANYA UNTUK ADMINBEM) --}}
@auth
    @if(auth()->user()->hasRole('adminbem'))
        <button id="toggleEditMode" 
           class="fixed top-20 right-6 z-50 bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg shadow-lg transition-all duration-300 flex items-center gap-2 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
            </svg>
            <span class="font-semibold edit-mode-text">Edit</span>
        </button>
    @endif
@endauth

@if ($ormawa->slug === 'bem')
    {{-- ================== LAYOUT BEM ================== --}}
    <div style="position:relative; height:340px; overflow:hidden; border-bottom-left-radius:20px; border-bottom-right-radius:20px;">
        <img src="{{ asset('images/ith.jpg') }}" alt="Gedung ITH" style="width:100%; height:100%; object-fit:cover;">
        <div style="position:absolute; inset:0; background:rgba(0,0,0,0.38); display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; padding:0 16px; color:white;">
            <div style="font-size:22px; letter-spacing:2px; font-weight:500;">WELCOME</div>
            <div style="font-size:15px; opacity:0.9;">TO</div>
            <div style="font-size:30px; font-weight:800; margin-top:4px;">Badan Eksekutif Mahasiswa</div>
            <div style="font-size:15px; margin-top:6px; opacity:0.95;">Institut Teknologi Bacharuddin Jusuf Habibie</div>
        </div>
    </div>

    <div style="background:white; padding:38px 24px 90px;">
        <div style="display:flex; justify-content:center; margin-bottom:28px; position:relative;">
            <img src="{{ asset('images/logobem.png') }}" alt="BEM ITH 2025" style="width:120px; filter:drop-shadow(0 3px 6px rgba(0,0,0,0.15));"> 
        </div>

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:24px; max-width:1100px; margin:0 auto 24px;">
            {{-- VISION --}}
            <div style="background:white; padding:24px; border-radius:18px; box-shadow:0 6px 18px rgba(0,0,0,0.08); position:relative;">
                <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:10px;">Vision</div>
                <div class="editable-content" data-field="vision" style="font-size:15px; color:#444; line-height:1.6;">
                    {!! $ormawa->vision ?? 'Belum ada visi.' !!}
                </div>
                @auth @if(auth()->user()->hasRole('adminbem'))
                    <button class="edit-control hidden absolute top-4 right-4 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded" onclick="editContent(this, 'vision')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                    </button>
                @endif @endauth
            </div>

            {{-- MISSION --}}
            <div style="background:white; padding:24px; border-radius:18px; box-shadow:0 6px 18px rgba(0,0,0,0.08); position:relative;">
                <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:14px;">Mission</div>
                <div class="editable-content" data-field="mission" style="font-size:15px; color:#444; line-height:1.65;">
                    {!! $ormawa->mission ?? 'Belum ada misi.' !!}
                </div>
                @auth @if(auth()->user()->hasRole('adminbem'))
                    <button class="edit-control hidden absolute top-4 right-4 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded" onclick="editContent(this, 'mission')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                    </button>
                @endif @endauth
            </div>
        </div>
    </div>

@else
    {{-- =========== LAYOUT UNTUK UKM ============ --}}
    <div style="background:white; padding:38px 24px 90px;">
        <div style="display:flex; justify-content:center; margin-bottom:28px; position:relative;">
            <img src="{{ asset($ormawa->logo) }}" alt="{{ $ormawa->nama }}" style="width:120px; filter:drop-shadow(0 3px 6px rgba(0,0,0,0.15));">
        </div>

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap:24px; max-width:1100px; margin:0 auto 24px;">
            <div style="background:white; padding:24px; border-radius:18px; box-shadow:0 6px 18px rgba(0,0,0,0.08); position:relative;">
                <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:10px;">Vision</div>
                <div class="editable-content" data-field="vision" style="font-size:15px; color:#444; line-height:1.6;">
                    {!! $ormawa->vision ?? 'Belum ada visi.' !!}
                </div>
                @auth @if(auth()->user()->hasRole('adminbem'))
                    <button class="edit-control hidden absolute top-4 right-4 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded" onclick="editContent(this, 'vision')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                    </button>
                @endif @endauth
            </div>

            <div style="background:white; padding:24px; border-radius:18px; box-shadow:0 6px 18px rgba(0,0,0,0.08); position:relative;">
                <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:14px;">Mission</div>
                <div class="editable-content" data-field="mission" style="font-size:15px; color:#444; line-height:1.65;">
                    {!! $ormawa->mission ?? 'Belum ada misi.' !!}
                </div>
                @auth @if(auth()->user()->hasRole('adminbem'))
                    <button class="edit-control hidden absolute top-4 right-4 bg-blue-500 hover:bg-blue-600 text-white p-2 rounded" onclick="editContent(this, 'mission')">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                    </button>
                @endif @endauth
            </div>
        </div>

        {{-- ORGANIZATIONAL STRUCTURE --}}
        <div style="max-width:1100px; margin:0 auto;">
            <div style="background:white; padding:24px; border-radius:18px; box-shadow:0 6px 18px rgba(0,0,0,0.08);">
                <div style="font-size:20px; font-weight:700; color:#ff7a1a; margin-bottom:16px;">Organizational Structure</div>
                
                @php $structure = json_decode($ormawa->structure ?? '{}', true); @endphp

                <div class="structure-view">
                    <div style="display:flex; justify-content:space-between; font-weight:700; border-bottom:1px solid #eee; padding:8px 0;">
                        <div>Ketua</div>
                        <div>{{ $structure['ketua'] ?? '' }}</div>
                    </div>
                    @foreach ($structure['jabatan'] ?? [] as $jabatan)
                        <div style="display:flex; justify-content:space-between; font-weight:700; padding:8px 0;">
                            <div>{{ $jabatan['jabatan'] }}</div>
                            <div style="font-weight:500">{{ $jabatan['nama'] }}</div>
                        </div>
                        @foreach ($jabatan['anggota'] ?? [] as $anggota)
                            <div style="margin-left:32px; font-size:14px; color:#555;">{{ $anggota }}</div>
                        @endforeach
                    @endforeach
                </div>

                <div class="structure-edit hidden">
                    <div style="display:flex; justify-content:space-between; align-items:center; font-weight:700; margin-bottom:15px;">
                        <div>Ketua</div>
                        <input id="ketuaInput" class="form-control" style="width:250px; border:1px solid #ddd; padding:5px 10px; border-radius:5px;" value="{{ $structure['ketua'] ?? '' }}" placeholder="Nama Ketua">
                    </div>
                    <div id="jabatanWrapper">
                        @foreach ($structure['jabatan'] ?? [] as $jabatan)
                            <div class="jabatan-item mt-4 p-3" style="border:1px dashed #ccc; border-radius:10px; position:relative;">
                                <div style="display:flex; justify-content:space-between; gap:10px;">
                                    <input class="form-control jabatan-nama" style="width:45%; font-weight:700; border:1px solid #ddd; padding:5px;" value="{{ $jabatan['jabatan'] }}" placeholder="Nama Jabatan">
                                    <input class="form-control jabatan-orang" style="width:45%; border:1px solid #ddd; padding:5px;" value="{{ $jabatan['nama'] }}" placeholder="Nama">
                                </div>
                                <div class="anggota-wrapper" style="margin-left:32px; margin-top:10px;">
                                    <label style="font-size:12px; color:#666;">Anggota (Opsional):</label>
                                    @foreach ($jabatan['anggota'] ?? [] as $anggota)
                                        <input class="form-control anggota-input mt-2" style="width:90%; border:1px solid #eee; padding:4px;" value="{{ $anggota }}">
                                    @endforeach
                                </div>
                                <button type="button" onclick="addAnggota(this)" class="btn btn-sm mt-2" style="margin-left:32px; font-size:12px; color:#ff7a1a; background:none; border:none; cursor:pointer;">+ Add Anggota</button>
                            </div>
                        @endforeach
                    </div>
                    <div style="display:flex; gap:10px; margin-top:20px;">
                        <button type="button" onclick="addJabatan()" class="btn" style="background-color:#ff7a1a; color:white; padding:8px 16px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">+ Add Position</button>
                        <button type="button" id="saveStructureBtn" onclick="saveStructure()" class="btn" style="background-color:#22c55e; color:white; padding:8px 16px; border-radius:8px; border:none; font-weight:600; cursor:pointer;">Simpan Struktur</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- JAVASCRIPT --}}
@auth @if(auth()->user()->hasRole('adminbem'))
<script>
    let editMode = false;
    const toggleBtn = document.getElementById('toggleEditMode');
    const editControls = document.querySelectorAll('.edit-control');
    const editModeText = document.querySelector('.edit-mode-text');
    const ormawaSlug = '{{ $ormawa->slug }}';

    toggleBtn.addEventListener('click', function() {
        editMode = !editMode;
        document.querySelector('.structure-view')?.classList.toggle('hidden', editMode);
        document.querySelector('.structure-edit')?.classList.toggle('hidden', !editMode);
        
        if (editMode) {
            editControls.forEach(control => control.classList.remove('hidden'));
            toggleBtn.classList.replace('bg-orange-500', 'bg-green-500');
            editModeText.textContent = 'Selesai';
        } else {
            editControls.forEach(control => control.classList.add('hidden'));
            toggleBtn.classList.replace('bg-green-500', 'bg-orange-500');
            editModeText.textContent = 'Edit';
        }
    });

    function editContent(button, field) {
        const contentDiv = button.parentElement.querySelector('.editable-content');
        const currentContent = contentDiv.innerHTML.trim();
        const textarea = document.createElement('textarea');
        textarea.className = 'w-full p-3 border-2 border-blue-500 rounded focus:outline-none';
        textarea.style.minHeight = '150px';
        textarea.value = currentContent.replace(/<[^>]*>/g, '').trim();
        
        const container = document.createElement('div');
        container.className = 'flex gap-2 mt-3';
        
        const sBtn = document.createElement('button');
        sBtn.textContent = 'Simpan';
        sBtn.className = 'px-4 py-2 bg-orange-500 text-white rounded';
        sBtn.onclick = () => saveContent(field, textarea.value, contentDiv, button);
        
        const cBtn = document.createElement('button');
        cBtn.textContent = 'Batal';
        cBtn.className = 'px-4 py-2 bg-gray-500 text-white rounded';
        cBtn.onclick = () => { contentDiv.innerHTML = currentContent; button.classList.remove('hidden'); };
        
        container.append(sBtn, cBtn);
        contentDiv.innerHTML = '';
        contentDiv.append(textarea, container);
        button.classList.add('hidden');
    }

    async function saveContent(field, newContent, contentDiv, button) {
        Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        try {
            const response = await fetch(`/ormawa/${ormawaSlug}/update-content`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ field, content: newContent })
            });
            if (response.ok) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Konten diperbarui!', timer: 1500, showConfirmButton: false });
                contentDiv.innerHTML = newContent;
                button.classList.remove('hidden');
            }
        } catch (e) { Swal.fire('Error', 'Gagal menyimpan', 'error'); }
    }

    function addJabatan() {
        const wrapper = document.getElementById('jabatanWrapper');
        const div = document.createElement('div');
        div.className = 'jabatan-item mt-4 p-3';
        div.style = 'border:1px dashed #ccc; border-radius:10px; position:relative;';
        div.innerHTML = `<div style="display:flex; justify-content:space-between; gap:10px;"><input class="form-control jabatan-nama" style="width:45%; font-weight:700; border:1px solid #ddd; padding:5px;" placeholder="Nama Jabatan"><input class="form-control jabatan-orang" style="width:45%; border:1px solid #ddd; padding:5px;" placeholder="Nama"></div><div class="anggota-wrapper" style="margin-left:32px; margin-top:10px;"><label style="font-size:12px; color:#666;">Anggota (Opsional):</label></div><button type="button" onclick="addAnggota(this)" class="btn btn-sm mt-2" style="margin-left:32px; font-size:12px; color:#ff7a1a; background:none; border:none; cursor:pointer;">+ Add Anggota</button>`;
        wrapper.appendChild(div);
    }

    function addAnggota(btn) {
        const wrapper = btn.parentElement.querySelector('.anggota-wrapper');
        const input = document.createElement('input');
        input.className = 'form-control anggota-input mt-2';
        input.style = 'width:90%; border:1px solid #eee; padding:4px; display:block;';
        input.placeholder = 'Nama Anggota';
        wrapper.appendChild(input);
    }

    async function saveStructure() {
        const data = { ketua: document.getElementById('ketuaInput').value, jabatan: [] };
        document.querySelectorAll('.jabatan-item').forEach(item => {
            const nj = item.querySelector('.jabatan-nama').value;
            const no = item.querySelector('.jabatan-orang').value;
            if (nj.trim() !== "") {
                const ang = [];
                item.querySelectorAll('.anggota-input').forEach(a => { if(a.value.trim() !== "") ang.push(a.value); });
                data.jabatan.push({ jabatan: nj, nama: no, anggota: ang });
            }
        });

        Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
        try {
            const response = await fetch(`/ormawa/${ormawaSlug}/update-content`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ field: 'structure', content: JSON.stringify(data) })
            });
            if (response.ok) {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Struktur organisasi diperbarui!', confirmButtonColor: '#ff7a1a' }).then(() => location.reload());
            } else { throw new Error(); }
        } catch (e) { Swal.fire('Error', 'Gagal menyimpan struktur', 'error'); }
    }
</script>
@endif @endauth

<style> .hidden { display: none !important; } </style>
@endsection

