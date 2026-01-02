{{-- 1. MODAL DETAIL KEGIATAN (PUBLIC - SEMUA BISA LIHAT) --}}
<div id="detailModal" class="modern-modal-overlay hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="modern-modal bg-white max-w-md w-full max-h-[90vh] flex flex-col rounded-2xl shadow-2xl">
        
        {{-- Header --}}
        <div class="modern-modal-header flex justify-between items-center p-6 border-b border-gray-100 shrink-0">
            <h3 id="detailTitle" class="modern-modal-title text-lg font-bold text-gray-800">Detail Kegiatan</h3>
            <button onclick="closeDetailModal()" class="modern-modal-close text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        {{-- Content --}}
        <div class="modern-modal-body space-y-5 overflow-y-auto p-6">
            
            {{-- Jadwal --}}
            <div class="flex items-start gap-4">
                <div class="modern-form-icon shrink-0">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-500 mb-1">Jadwal</p>
                    <p id="detailJadwal" class="text-sm text-gray-800 font-medium"></p>
                </div>
            </div>

            {{-- Kegiatan --}}
            <div class="flex items-start gap-4">
                <div class="modern-form-icon shrink-0">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-500 mb-1">Kegiatan</p>
                    <p id="detailKegiatan" class="text-sm text-gray-800"></p>
                </div>
            </div>

            {{-- Tempat --}}
            <div class="flex items-start gap-4">
                <div class="modern-form-icon shrink-0">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-500 mb-1">Tempat</p>
                    <p id="detailTempat" class="text-sm text-gray-800"></p>
                </div>
            </div>
            
            {{-- INFO PENGINPUT --}}
            <div class="flex items-start gap-4">
                <div class="modern-form-icon shrink-0">
                    <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                </div>
                <div class="flex-1">
                    <p class="text-xs font-semibold text-gray-500 mb-1">Diinput Oleh</p>
                    <p id="detailPenginput" class="text-sm text-gray-800 font-medium">-</p>
                </div>
            </div>

            <div class="pt-4 mt-2 border-t border-gray-100">
                <label class="text-xs font-bold text-gray-700 mb-2 block">Dokumen LPJ</label>
                
                {{-- Form Upload --}}
                <form id="formUploadLPJ" class="flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <input type="file" id="file_lpj" name="file_lpj" accept=".pdf,.doc,.docx"
                            class="block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-xs file:font-semibold
                            file:bg-orange-50 file:text-orange-700
                            hover:file:bg-orange-100 cursor-pointer">
                        
                        <button type="button" onclick="uploadFileLpj()" id="btnSubmitLpj" class="px-3 py-2 bg-orange-500 text-white text-xs font-semibold rounded-lg hover:bg-orange-600 transition shadow-sm shrink-0">
                            Upload
                        </button>
                    </div>
                    <small class="text-gray-400 text-[10px]">Format: PDF/Docx. Maks 2MB.</small>
                </form>

                {{-- Tampilan jika file sudah ada (Diatur via JS) --}}
                <div id="existingLpjAlert" class="hidden mt-2 p-2 bg-green-50 border border-green-200 rounded-md flex justify-between items-center">
                    <a id="linkLpj" href="#" target="_blank" class="text-xs text-green-700 hover:underline flex items-center gap-1 font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Lihat File LPJ Terupload
                    </a>
                </div>
            </div>

            {{-- === STATUS & VALIDASI BEM === --}}
            <div id="areaStatusLPJ" class="hidden pt-4 mt-2 border-t border-gray-100">

                {{-- A. BAGIAN DEADLINE --}}
                <div class="bg-blue-50 p-3 rounded-lg mb-3 border border-blue-100 flex justify-between items-center">
                    <div>
                        <p class="text-[10px] text-blue-600 font-bold uppercase tracking-wider">Batas Waktu LPJ</p>
                        <p id="textDeadline" class="text-sm font-bold text-blue-800">-</p>
                    </div>
                    
                    {{-- Tombol Setting Deadline (Hanya Admin BEM) --}}
                    @role('adminbem')
                    <button onclick="toggleEditDeadline()" class="text-xs bg-white border border-blue-200 text-blue-600 px-2 py-1 rounded hover:bg-blue-100 transition">
                        Atur
                    </button>
                    @endrole
                </div>

                {{-- Form Edit Deadline (Default Hidden) --}}
                @role('adminbem')
                <div id="formDeadlineContainer" class="hidden mb-4 p-3 bg-gray-50 rounded-lg border border-gray-200">
                    <label class="text-xs font-bold text-gray-700 mb-1 block">Set Tanggal Deadline:</label>
                    <div class="flex gap-2">
                        <input type="date" id="inputDeadline" class="flex-1 text-xs rounded border-gray-300">
                        <button onclick="simpanDeadline()" class="bg-blue-600 text-white text-xs px-3 py-1 rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </div>
                @endrole

                {{-- B. BAGIAN STATUS --}}
                <div class="flex justify-between items-center mb-3">
                    <span class="text-xs font-bold text-gray-700">Status LPJ:</span>
                    <span id="badgeStatus" class="px-3 py-1 rounded-full text-xs font-bold bg-gray-200 text-gray-600">
                        -
                    </span>
                </div>

                {{-- C. BAGIAN CATATAN REVISI --}}
                <div id="alertRevisi" class="hidden p-3 bg-red-50 border border-red-200 rounded-lg mb-3">
                    <p class="text-xs font-bold text-red-700 mb-1">Catatan Revisi dari BEM:</p>
                    <p id="textCatatanRevisi" class="text-xs text-red-600 italic"></p>
                </div>

                {{-- D. PANEL TOMBOL BEM --}}
                @role('adminbem')
                <div id="panelValidasiBem" class="bg-orange-50 p-4 rounded-xl border border-orange-100">
                    <h4 class="text-xs font-bold text-orange-800 mb-2">Validasi BEM</h4>
                    
                    <div id="formRevisiContainer" class="hidden mb-3">
                        <textarea id="inputCatatanRevisi" rows="2" 
                            class="w-full text-xs rounded-lg border-gray-300 focus:border-orange-500"
                            placeholder="Tuliskan alasan kenapa harus direvisi..."></textarea>
                    </div>

                    <div class="flex gap-2">
                        <button type="button" onclick="submitValidasi('diterima')" 
                            class="flex-1 py-2 bg-green-500 hover:bg-green-600 text-white text-xs font-bold rounded-lg transition shadow-sm">
                            ✓ Terima
                        </button>
                        <button type="button" id="btnMintaRevisi" onclick="toggleModeRevisi()" 
                            class="flex-1 py-2 bg-red-500 hover:bg-red-600 text-white text-xs font-bold rounded-lg transition shadow-sm">
                            ✕ Revisi
                        </button>
                        <button type="button" id="btnKirimRevisi" onclick="submitValidasi('revisi')" 
                            class="hidden flex-1 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-lg transition shadow-sm">
                            Kirim
                        </button>
                    </div>
                </div>
                @endrole
            </div>

            {{-- Buttons Aksi (Edit/Hapus) --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <button type="button" id="btnTutupDetail" onclick="closeDetailModal()" 
                    class="modern-btn modern-btn-secondary">
                    Tutup
                </button>
                <button type="button" id="btnEditKegiatan" onclick="editKegiatan()" 
                    class="modern-btn modern-btn-success">
                    Edit
                </button>
                <button type="button" id="btnHapusKegiatan" onclick="deleteKegiatan()" 
                    class="modern-btn modern-btn-danger">
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>


{{-- 2. MODAL INPUT/EDIT KEGIATAN (KHUSUS ADMIN) --}}
@auth
    @if(auth()->user()->hasAnyRole(['adminbem','adminukm']))
    <div id="addModal" class="modern-modal-overlay hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="modern-modal bg-white max-w-md w-full">
            {{-- Header --}}
            <div class="modern-modal-header flex justify-between items-center">
                <h3 id="modalTitle" class="modern-modal-title">Input Kegiatan</h3>
                <button onclick="closeAddModal()" class="modern-modal-close">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            {{-- Edit Mode Indicator --}}
            <div id="editModeIndicator" class="hidden px-6 py-3 bg-blue-50 border-l-4 border-blue-500">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <div>
                        <p class="text-sm font-semibold text-blue-800">Mode Edit</p>
                        <p class="text-xs text-blue-600">Ubah data yang ingin Anda edit, field lainnya akan tetap sama</p>
                    </div>
                </div>
            </div>
            
            {{-- Form --}}
            <form id="kegiatanForm" class="modern-modal-body space-y-5">
                @csrf
                <input type="hidden" id="kegiatan_id" name="kegiatan_id">
                
                {{-- Jadwal (Tanggal) --}}
                <div class="flex items-start gap-4">
                    <div class="modern-form-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="modern-label">Jadwal</label>
                        <input type="date" id="tanggal_kegiatan" name="tanggal_kegiatan" required class="modern-input">
                    </div>
                </div>

                {{-- Waktu --}}
                <div class="flex items-start gap-4">
                    <div class="modern-form-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <div class="flex-1 grid grid-cols-2 gap-3">
                        <div>
                            <label class="modern-label text-xs">Waktu Mulai</label>
                            <input type="time" id="waktu_mulai" name="waktu_mulai" required class="modern-input">
                        </div>
                        <div>
                            <label class="modern-label text-xs">Waktu Selesai</label>
                            <input type="time" id="waktu_selesai" name="waktu_selesai" required class="modern-input">
                        </div>
                    </div>
                </div>

                {{-- Kegiatan --}}
                <div class="flex items-start gap-4">
                    <div class="modern-form-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="modern-label">Kegiatan</label>
                        <input type="text" id="nama_kegiatan" name="nama_kegiatan" required placeholder="Nama kegiatan" class="modern-input">
                    </div>
                </div>

                {{-- Tempat --}}
                <div class="flex items-start gap-4">
                    <div class="modern-form-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                    <div class="flex-1">
                        <label class="modern-label">Tempat</label>
                        <input type="text" id="tempat" name="tempat" required placeholder="Lokasi kegiatan" class="modern-input">
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeAddModal()" class="modern-btn modern-btn-secondary">Batal</button>
                    <button type="submit" class="modern-btn modern-btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    @endif
@endauth 
{{-- ^^^ INI DIA YANG TADI HILANG (PENUTUP) --}}


{{-- 3. CUSTOM ALERT MODAL --}}
<div id="customAlertModal" class="modern-modal-overlay hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-2xl max-w-md w-full transform transition-all">
        <div class="p-6">
            <div class="flex justify-center mb-4">
                <div id="alertIcon" class="w-16 h-16 rounded-full flex items-center justify-center"></div>
            </div>
            <h3 id="alertTitle" class="text-xl font-bold text-center mb-2 text-gray-800"></h3>
            <p id="alertMessage" class="text-center text-gray-600 mb-6"></p>
            <div id="alertButtons" class="flex justify-center gap-3">
                <button id="alertCancelBtn" class="hidden px-6 py-2 bg-gray-200 text-gray-700 rounded-lg font-semibold hover:bg-gray-300 transition-colors">Batal</button>
                <button id="alertOkBtn" class="px-6 py-2 rounded-lg font-semibold transition-colors">OK</button>
            </div>
        </div>
    </div>
</div>


{{-- 4. MODAL BERITA --}}
<div id="modalBerita" class="modern-modal-overlay hidden fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/50">
    <div class="modern-modal bg-white max-w-2xl w-full rounded-xl shadow-2xl overflow-hidden">
        <div class="modern-modal-header bg-orange-500 p-4 flex justify-between items-center text-white">
            <h3 id="modalBeritaTitle" class="font-bold text-lg">Tambah Berita</h3>
            <button onclick="closeModalBerita()" class="hover:rotate-90 transition-transform">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        
        <form id="formBerita" action="{{ route('berita.index') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
            @csrf
            <div id="beritaMethod"></div> 
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Berita</label>
                <input type="text" name="judul" id="berita_judul" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Konten Berita</label>
                <textarea name="konten" id="berita_konten" rows="5" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring-orange-500" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Upload Gambar</label>
                <input type="file" name="gambar" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <button type="button" onclick="closeModalBerita()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Batal</button>
                <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600 shadow-md">Simpan Berita</button>
            </div>
        </form>
    </div>
</div>


{{-- 5. MODAL HAPUS BERITA --}}
<div id="deleteBeritaModal" class="hidden fixed inset-0 z-[150] flex items-center justify-center p-4 bg-black/50">
    <div class="bg-white rounded-2xl shadow-2xl max-w-sm w-full overflow-hidden transform transition-all scale-100">
        <div class="p-6 text-center">
            <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2 font-playfair">Hapus Berita?</h3>
            <p class="text-gray-500 text-sm mb-6">Berita yang dihapus tidak dapat dikembalikan. Apakah Anda yakin?</p>
            
            <div class="flex gap-3">
                <button onclick="closeDeleteModalBerita()" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition">
                    Batal
                </button>
                <form id="deleteBeritaForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2.5 bg-red-600 text-white font-semibold rounded-xl hover:bg-red-700 transition shadow-lg shadow-red-200">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>