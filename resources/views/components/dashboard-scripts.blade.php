<script>
    // ==========================================
    // 1. SETUP DATA & VARIABEL GLOBAL
    // ==========================================
    const events = JSON.parse(`{!! json_encode($sevents ?? []) !!}`); 
    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    let activeKegiatanId = null; // Menyimpan ID kegiatan yang sedang dibuka
    
    const grid = document.getElementById('calendarGrid');
    const monthLabel = document.getElementById('monthLabel');

    // ==========================================
    // 2. FUNGSI RENDER KALENDER (Gaya Baru + Limit)
    // ==========================================
    function renderCalendar(year, month) {
        if(monthLabel) monthLabel.textContent = new Date(year, month).toLocaleString('id-ID', { month: 'long', year: 'numeric' });
        if(grid) grid.innerHTML = '';
        
        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Kotak Kosong
        for (let i = 0; i < firstDay; i++) {
            grid.appendChild(document.createElement('div'));
        }

        // Tanggal
        for (let d = 1; d <= daysInMonth; d++) {
            const cell = document.createElement('div');
            cell.onclick = () => updateSidebarList(year, month, d);
            cell.className = 'flex flex-col items-center justify-start cursor-pointer hover:bg-orange-50 transition p-1 min-h-[80px] rounded-lg border border-transparent hover:border-orange-100 relative';

            const dateEl = document.createElement('div');
            dateEl.textContent = d;
            dateEl.className = 'text-sm mb-1 font-medium text-gray-700';
            
            if (year === today.getFullYear() && month === today.getMonth() && d === today.getDate()) {
                dateEl.className = 'w-7 h-7 flex items-center justify-center bg-orange-500 text-white rounded-full text-xs font-bold shadow-md mb-1';
            }
            cell.appendChild(dateEl);

            // LOGIKA LIMIT 3 ITEM
            const key = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            if (events[key]) {
                const eventList = Array.isArray(events[key]) ? events[key] : [events[key]];
                const maxDisplay = 2; // Tampilkan 2 + sisa
                
                eventList.forEach((event, index) => {
                    if (eventList.length <= 3) {
                         createEventPill(cell, event.nama);
                    } else {
                        if (index < maxDisplay) {
                            createEventPill(cell, event.nama);
                        } else if (index === maxDisplay) {
                            const more = document.createElement('div');
                            more.className = 'text-[10px] text-gray-400 font-bold mt-0.5';
                            more.textContent = `+ ${eventList.length - maxDisplay} lagi...`;
                            cell.appendChild(more);
                        }
                    }
                });
            }
            grid.appendChild(cell);
        }
    }

    function createEventPill(parent, text) {
        const ev = document.createElement('div');
        ev.className = 'w-full bg-orange-100 text-orange-700 text-[10px] px-1 py-0.5 rounded truncate mt-0.5 font-medium border border-orange-200/50';
        ev.textContent = text;
        parent.appendChild(ev);
    }

    // ==========================================
    // 3. FUNGSI UPDATE SIDEBAR (Klik Tanggal)
    // ==========================================
    function updateSidebarList(year, month, day) {
        const key = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const dateObj = new Date(year, month, day);
        
        const label = document.getElementById('selectedDateLabel');
        if(label) label.textContent = dateObj.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

        const listContainer = document.getElementById('dailyEventsList');
        if(!listContainer) return;
        
        listContainer.innerHTML = ''; 

        if (events[key]) {
            const eventList = Array.isArray(events[key]) ? events[key] : [events[key]];
            
            eventList.forEach(event => {
                const item = document.createElement('div');
                item.className = 'group p-3 rounded-xl border border-gray-100 bg-gray-50 hover:bg-orange-50 hover:border-orange-200 cursor-pointer transition-all duration-200';
                
                // KLIK LIST DI SIDEBAR -> BUKA MODAL DETAIL ADMIN
                item.onclick = () => showSideDetail(event.id);
                
                item.innerHTML = `
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="font-bold text-gray-800 text-sm group-hover:text-orange-600 line-clamp-2">${event.nama}</h4>
                        <span class="text-[10px] px-2 py-0.5 bg-gray-50 border border-gray-200 rounded-full text-gray-500 group-hover:bg-white">Detail</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>${event.waktu_mulai ? event.waktu_mulai.substring(0,5) : '-'}</span>
                    </div>
                `;
                listContainer.appendChild(item);
            });
        } else {
            listContainer.innerHTML = `<div class="text-center py-8 text-gray-400 bg-gray-50 rounded-xl border border-dashed border-gray-200"><p class="text-sm font-medium">Tidak ada kegiatan</p><p class="text-xs">Klik tombol (+) di atas untuk menambah</p></div>`;
        }
    }

    // ==========================================
    // 4. FUNGSI ADMIN: MODAL INPUT (Tambah/Edit)
    // ==========================================
    window.openAddModal = function() {
        document.getElementById('kegiatanForm').reset();
        document.getElementById('kegiatan_id').value = ''; // Kosongkan ID (Mode Tambah)
        document.getElementById('modalTitle').textContent = 'Input Kegiatan';
        document.getElementById('editModeIndicator').classList.add('hidden');
        document.getElementById('addModal').classList.remove('hidden');
    }

    window.closeAddModal = function() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('kegiatanForm').reset();
    }

    // Submit Form Tambah/Edit
    document.getElementById('kegiatanForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const id = document.getElementById('kegiatan_id').value;
        const url = id ? `/kegiatan/${id}` : '/kegiatan';
        const method = id ? 'PUT' : 'POST';
        
        // Ambil Data Form Manual
        const data = {
            nama_kegiatan: document.getElementById('nama_kegiatan').value,
            tanggal_kegiatan: document.getElementById('tanggal_kegiatan').value,
            tempat: document.getElementById('tempat').value,
            waktu_mulai: document.getElementById('waktu_mulai').value,
            waktu_selesai: document.getElementById('waktu_selesai').value
        };

        const btnSubmit = this.querySelector('button[type="submit"]');
        const oldText = btnSubmit.textContent;
        btnSubmit.textContent = 'Menyimpan...';
        btnSubmit.disabled = true;

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json' // <--- PENTING: Supaya error-nya jadi JSON
            },
            body: JSON.stringify(data)
        })
        .then(async res => {
            const result = await res.json();
            // Cek apakah request sukses (Status 200-299)
            if (!res.ok) {
                // Jika error 403 (Ditolak Policy) atau 422 (Validasi), lempar error
                throw new Error(result.message || 'Gagal menyimpan data');
            }
            return result;
        })
        .then(res => {
            alert('Berhasil menyimpan kegiatan!');
            location.reload();
        })
        .catch(err => {
            btnSubmit.textContent = oldText;
            btnSubmit.disabled = false;
            // Munculkan pesan error asli dari Policy (misal: "Akses Ditolak...")
            alert(err.message);
        });
    });

    // ==========================================
    // 5. FUNGSI ADMIN: MODAL DETAIL & LPJ
    // ==========================================
    
    // Fungsi Buka Modal Detail (Dipanggil saat klik list sidebar)
    window.showSideDetail = function(eventId) {
        activeKegiatanId = eventId; // Simpan ID aktif

        fetch(`/kegiatan/${eventId}`)
            .then(res => res.json())
            .then(data => {
                // 1. Isi Info Dasar
                document.getElementById('detailTitle').textContent = data.nama_kegiatan;
                document.getElementById('detailKegiatan').textContent = data.nama_kegiatan;
                document.getElementById('detailTempat').textContent = data.tempat;
                
                // Isi Penginput (Cek null safety)
                const penginput = (data.user && data.user.name) ? data.user.name : 'Admin';
                document.getElementById('detailPenginput').textContent = penginput;

                // Format Jadwal
                const date = new Date(data.tanggal_kegiatan);
                const hari = date.toLocaleDateString('id-ID', { weekday: 'long' });
                const tgl = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                const jam = (data.waktu_mulai && data.waktu_selesai) ? `${data.waktu_mulai.substring(0,5)} - ${data.waktu_selesai.substring(0,5)}` : '';
                document.getElementById('detailJadwal').textContent = `${hari}, ${tgl}, ${jam}`;

                // --- 2. LOGIKA LPJ & STATUS & DEADLINE ---
                const areaStatus = document.getElementById('areaStatusLPJ');
                const badgeStatus = document.getElementById('badgeStatus');
                const alertRevisi = document.getElementById('alertRevisi');
                const textRevisi = document.getElementById('textCatatanRevisi');
                const panelBem = document.getElementById('panelValidasiBem');
                
                const existingAlert = document.getElementById('existingLpjAlert');
                const linkLpj = document.getElementById('linkLpj');
                const btnSubmitLpj = document.getElementById('btnSubmitLpj');

                const textDeadline = document.getElementById('textDeadline');
                const formDeadline = document.getElementById('formDeadlineContainer');

                // A. Selalu tampilkan area status (agar info deadline terlihat)
                if(areaStatus) areaStatus.classList.remove('hidden');

                // B. Isi Info Deadline (Safe Check)
                if (data.lpj && data.lpj.deadline) {
                    const d = new Date(data.lpj.deadline);
                    textDeadline.textContent = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                } else {
                    textDeadline.textContent = "Belum ditentukan";
                }

                // C. Cek apakah File LPJ sudah ada?
                if (data.lpj && data.lpj.file_lpj) {
                    
                    // Set Status Badge (PENTING: Tambah || 'pending' biar tidak error jika null)
                    let status = (data.lpj.status || 'pending'); 
                    badgeStatus.textContent = status.toUpperCase();
                    
                    // Reset class warna
                    badgeStatus.className = 'px-3 py-1 rounded-full text-xs font-bold border';
                    
                    if(status === 'diterima') {
                        badgeStatus.classList.add('bg-green-100', 'text-green-700', 'border-green-200');
                        alertRevisi.classList.add('hidden');
                    } else if(status === 'revisi') {
                        badgeStatus.classList.add('bg-red-100', 'text-red-700', 'border-red-200');
                        // Tampilkan Catatan Revisi jika ada
                        if(data.lpj.catatan_revisi) {
                            alertRevisi.classList.remove('hidden');
                            textRevisi.textContent = data.lpj.catatan_revisi;
                        }
                    } else { // Pending
                        badgeStatus.classList.add('bg-yellow-100', 'text-yellow-700', 'border-yellow-200');
                        alertRevisi.classList.add('hidden');
                    }

                    // Tampilkan Link Download
                    existingAlert.classList.remove('hidden');
                    linkLpj.href = `/kegiatan/${eventId}/download-lpj`; 
                    if(btnSubmitLpj) btnSubmitLpj.textContent = "Ganti File";

                    // Munculkan Panel Validasi BEM (Jika User BEM)
                    if(panelBem) {
                        panelBem.classList.remove('hidden');
                        // Reset tampilan form revisi
                        document.getElementById('formRevisiContainer').classList.add('hidden');
                        document.getElementById('btnMintaRevisi').classList.remove('hidden');
                        document.getElementById('btnKirimRevisi').classList.add('hidden');
                        document.getElementById('inputCatatanRevisi').value = '';
                    }

                } else {
                    // Jika BELUM ada file
                    existingAlert.classList.add('hidden');
                    if(alertRevisi) alertRevisi.classList.add('hidden');
                    if(btnSubmitLpj) btnSubmitLpj.textContent = "Upload";
                    
                    // Status default
                    badgeStatus.textContent = "MENUNGGU UPLOAD";
                    badgeStatus.className = 'px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200';
                    
                    // Sembunyikan validasi BEM karena belum ada file
                    if(panelBem) panelBem.classList.add('hidden'); 
                }

                // Reset Input File
                const fileInput = document.getElementById('file_lpj');
                if(fileInput) fileInput.value = '';

                // Reset Form Deadline (BEM)
                if(formDeadline) formDeadline.classList.add('hidden');

                // 3. Tampilkan Modal Akhirnya
                document.getElementById('detailModal').classList.remove('hidden');
            })
            .catch(err => {
                console.error(err);
                alert('Gagal mengambil data kegiatan. Cek console browser.');
            });
    }

    window.closeDetailModal = function() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Fungsi Upload LPJ
    window.uploadFileLpj = function() {
        if (!activeKegiatanId) return;

        const fileInput = document.getElementById('file_lpj');
        if (!fileInput || fileInput.files.length === 0) {
            alert('Pilih file dulu bos!');
            return;
        }

        const formData = new FormData();
        formData.append('file_lpj', fileInput.files[0]);
        const btn = document.getElementById('btnSubmitLpj');
        const oldText = btn.textContent;
        btn.textContent = 'Uploading...';
        btn.disabled = true;

        fetch(`/kegiatan/${activeKegiatanId}/upload-lpj`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content ,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(async res => {
            // --- BAGIAN INI YANG PENTING ---
            // Kita cek status HTTP-nya dulu
            const data = await res.json();

            // Jika statusnya BUKAN sukses (misal 403 Forbidden atau 500 Error)
            if (!res.ok) {
                // Kita lempar error manual biar ditangkap sama .catch di bawah
                // data.message itu isinya pesan dari Policy tadi ("Akses Ditolak: ...")
                throw new Error(data.message || 'Terjadi kesalahan pada server');
            }

            return data;
        })
        .then(res => {
            // Ini jalan kalau statusnya 200 (OK)
            btn.textContent = oldText;
            btn.disabled = false;

            if(res.success) {
                alert(res.message); // "LPJ Berhasil Diupload!"
                showSideDetail(activeKegiatanId);
            } else {
                alert('Gagal: ' + res.message);
            }
        })
        .catch(err => {
            // --- ERROR DITANGKAP DISINI ---
            btn.textContent = oldText;
            btn.disabled = false;
            
            // Tampilkan pesan error asli dari Laravel (Policy)
            alert(err.message); 
        });
    }

    // Fungsi Edit (Buka Modal Input dengan Data)
    window.editKegiatan = function() {
        if (!activeKegiatanId) return;
        
        // Fetch ulang data lengkap biar aman
        fetch(`/kegiatan/${activeKegiatanId}`)
            .then(res => res.json())
            .then(data => {
                // Isi Form Input
                document.getElementById('kegiatan_id').value = data.id_kegiatan; // ID untuk update
                document.getElementById('nama_kegiatan').value = data.nama_kegiatan;
                document.getElementById('tanggal_kegiatan').value = data.tanggal_kegiatan;
                document.getElementById('tempat').value = data.tempat;
                document.getElementById('waktu_mulai').value = data.waktu_mulai;
                document.getElementById('waktu_selesai').value = data.waktu_selesai;

                // Ganti Tampilan jadi Mode Edit
                document.getElementById('modalTitle').textContent = 'Edit Kegiatan';
                document.getElementById('editModeIndicator').classList.remove('hidden');
                
                // Tutup modal detail, buka modal edit
                closeDetailModal();
                document.getElementById('addModal').classList.remove('hidden');
            });
    }

    // Fungsi Hapus
    window.deleteKegiatan = function() {
        if (!activeKegiatanId) return;
        
        if(confirm('Yakin ingin menghapus kegiatan ini?')) {
            fetch(`/kegiatan/${activeKegiatanId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json' // <--- PENTING: Supaya tidak error token '<'
                }
            })
            .then(async res => {
                const result = await res.json();
                if (!res.ok) {
                    // Tangkap pesan error dari Policy
                    throw new Error(result.message || 'Gagal menghapus');
                }
                return result;
            })
            .then(res => {
                alert('Terhapus!');
                location.reload();
            })
            .catch(err => {
                // Tampilkan pesan error yang jelas
                alert(err.message);
            });
        }
    }

    // --- FUNGSI VALIDASI BEM ---
    
    // 1. Toggle Tampilan Input Revisi
    window.toggleModeRevisi = function() {
        const container = document.getElementById('formRevisiContainer');
        const btnMinta = document.getElementById('btnMintaRevisi');
        const btnKirim = document.getElementById('btnKirimRevisi');

        // Show Textarea & Button Kirim, Hide Button Minta
        container.classList.remove('hidden');
        btnMinta.classList.add('hidden');
        btnKirim.classList.remove('hidden');
    }

    // 2. Submit ke Server
    window.submitValidasi = function(statusKeputusan) {
        if(!activeKegiatanId) return;

        const catatan = document.getElementById('inputCatatanRevisi').value;

        // Validasi simpel: Kalau pilih revisi, wajib isi catatan
        if(statusKeputusan === 'revisi' && !catatan.trim()) {
            alert('Wajib mengisi catatan alasan revisi!');
            return;
        }

        if(!confirm('Yakin ingin mengubah status LPJ ini?')) return;

        fetch(`/kegiatan/${activeKegiatanId}/validasi-lpj`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: statusKeputusan,
                catatan: catatan
            })
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                alert('Status berhasil diperbarui!');
                showSideDetail(activeKegiatanId); // Refresh modal biar status berubah langsung
            } else {
                alert('Gagal: ' + res.message);
            }
        })
        .catch(err => alert('Terjadi kesalahan sistem'));
    }

    // ==========================================
    // 6. INIT LISTENER
    // ==========================================
    document.addEventListener('DOMContentLoaded', () => {
        const pBtn = document.getElementById('prevBtn');
        const nBtn = document.getElementById('nextBtn');
        
        if(pBtn) pBtn.onclick = () => {
            currentMonth--;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            renderCalendar(currentYear, currentMonth);
        };
        
        if(nBtn) nBtn.onclick = () => {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            renderCalendar(currentYear, currentMonth);
        };

        renderCalendar(currentYear, currentMonth);
    });

    // --- FUNGSI MODAL BERITA ---
    window.openModalBerita = function(id = null, judul = '', konten = '') {
        const modal = document.getElementById('modalBerita');
        const form = document.getElementById('formBerita');
        const title = document.getElementById('modalBeritaTitle');
        const methodDiv = document.getElementById('beritaMethod');

        if (id) {
            // Jika Mode Edit
            title.textContent = 'Edit Berita';
            form.action = `/berita/${id}`;
            methodDiv.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('berita_judul').value = judul;
            document.getElementById('berita_konten').value = konten;
        } else {
            // Jika Mode Tambah
            title.textContent = 'Tambah Berita';
            form.action = "{{ route('berita.store') }}";
            methodDiv.innerHTML = '';
            form.reset();
        }
        modal.classList.remove('hidden');
    }

    window.closeModalBerita = function() {
        document.getElementById('modalBerita').classList.add('hidden');
    }

    window.editBerita = function(id) {
        fetch(`/berita/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                // Isi data ke dalam form modal berita
                document.getElementById('berita_judul').value = data.judul_berita;
                document.getElementById('berita_konten').value = data.konten;
                
                // Ubah Judul Modal & Action Form
                document.getElementById('modalBeritaTitle').textContent = 'Edit Berita';
                document.getElementById('formBerita').action = `/berita/${id}`;
                document.getElementById('beritaMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
                
                // Tampilkan Modal
                document.getElementById('modalBerita').classList.remove('hidden');
            });
    }

    /**
     * 1. Fungsi Buka Modal Hapus
     * @param {string} actionUrl - URL lengkap Laravel untuk menghapus (misal: /berita/4)
     */
    window.openDeleteModalBerita = function(actionUrl) {
        const modal = document.getElementById('deleteBeritaModal');
        const form = document.getElementById('deleteBeritaForm');
        
        // Pasang URL hapus berita secara dinamis ke form modal
        form.action = actionUrl; 
        
        // Hilangkan class hidden untuk memunculkan modal
        modal.classList.remove('hidden');
    }

    /**
     * 2. Fungsi Tutup Modal Hapus
     */
    window.closeDeleteModalBerita = function() {
        document.getElementById('deleteBeritaModal').classList.add('hidden');
    }

    /**
     * 3. Tambahan Keamanan: Tutup modal jika klik di area luar modal (overlay)
     */
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('deleteBeritaModal');
        if (event.target === modal) {
            closeDeleteModalBerita();
        }
    });
    // ==========================================
    // FUNGSI PENCARIAN KEGIATAN (GLOBAL)
    // ==========================================
    window.searchEvents = function() {
        const keyword = document.getElementById('searchInput').value.toLowerCase();
        const listContainer = document.getElementById('dailyEventsList');
        const label = document.getElementById('selectedDateLabel');
        
        if (keyword.length < 1) {
            // Jika kolom pencarian kosong, kembalikan ke instruksi pilih tanggal
            label.textContent = "- Pilih Tanggal -";
            listContainer.innerHTML = `
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-sm">Klik tanggal di kalender<br>untuk melihat daftar kegiatan.</p>
                </div>`;
            return;
        }

        label.textContent = "Hasil Pencarian: " + keyword;
        listContainer.innerHTML = ''; // Kosongkan list

        let found = false;

        // Iterasi melalui semua data events yang ada di variabel global 'events'
        for (let dateKey in events) {
            const dailyEvents = Array.isArray(events[dateKey]) ? events[dateKey] : [events[dateKey]];
            
            dailyEvents.forEach(event => {
                if (event.nama.toLowerCase().includes(keyword)) {
                    found = true;
                    const item = document.createElement('div');
                    item.className = 'group p-3 rounded-xl border border-orange-100 bg-orange-50/30 hover:bg-orange-50 cursor-pointer transition-all duration-200 mb-3';
                    
                    // Tetap memfungsikan klik detail untuk Admin
                    item.onclick = () => showSideDetail(event.id);
                    
                    item.innerHTML = `
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-gray-800 text-sm group-hover:text-orange-600 line-clamp-2">${event.nama}</h4>
                            <span class="text-[10px] px-2 py-0.5 bg-white border border-orange-200 rounded-full text-orange-500">${dateKey}</span>
                        </div>
                        <div class="flex items-center gap-2 text-xs text-gray-500">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>${event.waktu_mulai ? event.waktu_mulai.substring(0,5) : '-'}</span>
                        </div>
                    `;
                    listContainer.appendChild(item);
                }
            });
        }

        if (!found) {
            listContainer.innerHTML = `
                <div class="text-center py-8 text-gray-400">
                    <p class="text-sm font-medium">Kegiatan "${keyword}" tidak ditemukan.</p>
                </div>`;
        }
    }

    // --- FUNGSI DEADLINE (BEM) ---
    window.toggleEditDeadline = function() {
        const el = document.getElementById('formDeadlineContainer');
        if(el) el.classList.toggle('hidden');
    }

    window.simpanDeadline = function() {
        if(!activeKegiatanId) return;
        const tgl = document.getElementById('inputDeadline').value;
        
        if(!tgl) {
            alert('Pilih tanggal dulu!');
            return;
        }

        fetch(`/kegiatan/${activeKegiatanId}/atur-deadline`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ deadline: tgl })
        })
        .then(res => res.json())
        .then(res => {
            if(res.success) {
                alert('Deadline berhasil disimpan!');
                showSideDetail(activeKegiatanId); // Refresh tampilan modal
            } else {
                alert('Gagal: ' + res.message);
            }
        })
        .catch(err => alert('Error sistem saat simpan deadline'));
    }
</script>