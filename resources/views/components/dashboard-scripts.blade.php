<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // ==========================================
    // 1. SETUP DATA & VARIABEL GLOBAL
    // ==========================================
    const events = JSON.parse(`{!! json_encode($sevents ?? []) !!}`); 
    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    let activeKegiatanId = null; 

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
                const maxDisplay = 2; 
                
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
        document.getElementById('kegiatan_id').value = ''; 
        document.getElementById('modalTitle').textContent = 'Input Kegiatan';
        document.getElementById('editModeIndicator').classList.add('hidden');
        document.getElementById('addModal').classList.remove('hidden');
    }

    window.closeAddModal = function() {
        document.getElementById('addModal').classList.add('hidden');
        document.getElementById('kegiatanForm').reset();
    }

    // Submit Form Tambah/Edit (PAKAI SWEETALERT)
    document.getElementById('kegiatanForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const id = document.getElementById('kegiatan_id').value;
        const url = id ? `/kegiatan/${id}` : '/kegiatan';
        const method = id ? 'PUT' : 'POST';
        
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
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(async res => {
            const result = await res.json();
            if (!res.ok) throw new Error(result.message || 'Gagal menyimpan data');
            return result;
        })
        .then(res => {
            // SUCCESS: Pakai SweetAlert, lalu Reload
            Swal.fire({
                title: 'Berhasil!',
                text: 'Data kegiatan berhasil disimpan.',
                icon: 'success',
                confirmButtonColor: '#f97316'
            }).then(() => {
                location.reload(); // <--- RELOAD DI SINI
            });
        })
        .catch(err => {
            btnSubmit.textContent = oldText;
            btnSubmit.disabled = false;
            Swal.fire('Gagal!', err.message, 'error');
        });
    });

    // ==========================================
    // 5. FUNGSI ADMIN: MODAL DETAIL & LPJ
    // ==========================================
    
    window.showSideDetail = function(eventId) {
        activeKegiatanId = eventId; 

        fetch(`/kegiatan/${eventId}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('detailTitle').textContent = data.nama_kegiatan;
                document.getElementById('detailKegiatan').textContent = data.nama_kegiatan;
                document.getElementById('detailTempat').textContent = data.tempat;
                
                const penginput = (data.user && data.user.name) ? data.user.name : 'Admin';
                document.getElementById('detailPenginput').textContent = penginput;

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

                if(areaStatus) areaStatus.classList.remove('hidden');

                if (data.lpj && data.lpj.deadline) {
                    const d = new Date(data.lpj.deadline);
                    textDeadline.textContent = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                } else {
                    textDeadline.textContent = "Belum ditentukan";
                }

                // Cek apakah File LPJ sudah ada?
                if (data.lpj && data.lpj.file_lpj) {
                    let status = (data.lpj.status_lpj || data.lpj.status || 'pending'); 
                    badgeStatus.textContent = status.toUpperCase();
                    
                    badgeStatus.className = 'px-3 py-1 rounded-full text-xs font-bold border';
                    
                    if(status === 'diterima') {
                        badgeStatus.classList.add('bg-green-100', 'text-green-700', 'border-green-200');
                        alertRevisi.classList.add('hidden');
                    } else if(status === 'revisi') {
                        badgeStatus.classList.add('bg-red-100', 'text-red-700', 'border-red-200');
                        if(data.lpj.catatan_revisi) {
                            alertRevisi.classList.remove('hidden');
                            textRevisi.textContent = data.lpj.catatan_revisi;
                        }
                    } else { // Pending
                        badgeStatus.classList.add('bg-yellow-100', 'text-yellow-700', 'border-yellow-200');
                        alertRevisi.classList.add('hidden');
                    }

                    existingAlert.classList.remove('hidden');
                    linkLpj.href = `/kegiatan/${eventId}/download-lpj`; 
                    if(btnSubmitLpj) btnSubmitLpj.textContent = "Ganti File";

                    if(panelBem) {
                        panelBem.classList.remove('hidden');
                        document.getElementById('formRevisiContainer').classList.add('hidden');
                        document.getElementById('btnMintaRevisi').classList.remove('hidden');
                        document.getElementById('btnKirimRevisi').classList.add('hidden');
                        document.getElementById('inputCatatanRevisi').value = '';
                    }

                } else {
                    // BELUM ADA FILE
                    existingAlert.classList.add('hidden');
                    if(alertRevisi) alertRevisi.classList.add('hidden');
                    if(btnSubmitLpj) btnSubmitLpj.textContent = "Upload";
                    
                    badgeStatus.textContent = "MENUNGGU UPLOAD";
                    badgeStatus.className = 'px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-500 border border-gray-200';
                    
                    if(panelBem) panelBem.classList.add('hidden'); 
                }

                const fileInput = document.getElementById('file_lpj');
                if(fileInput) fileInput.value = '';

                if(formDeadline) formDeadline.classList.add('hidden');

                document.getElementById('detailModal').classList.remove('hidden');
            })
            .catch(err => {
                console.error(err);
                Swal.fire('Error', 'Gagal mengambil data kegiatan.', 'error');
            });
    }

    window.closeDetailModal = function() {
        document.getElementById('detailModal').classList.add('hidden');
    }

    // Fungsi Upload LPJ (PAKAI SWEETALERT)
    window.uploadFileLpj = function() {
        if (!activeKegiatanId) return;

        const fileInput = document.getElementById('file_lpj');
        if (!fileInput || fileInput.files.length === 0) {
            Swal.fire('Oops...', 'Pilih file LPJ dulu sebelum upload!', 'warning');
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
            const data = await res.json();
            if (!res.ok) throw new Error(data.message || 'Terjadi kesalahan pada server');
            return data;
        })
        .then(res => {
            btn.textContent = oldText;
            btn.disabled = false;

            if(res.success) {
                Swal.fire('Berhasil!', res.message, 'success').then(() => {
                    showSideDetail(activeKegiatanId); // Refresh tampilan modal
                });
            } else {
                Swal.fire('Gagal', res.message, 'error');
            }
        })
        .catch(err => {
            btn.textContent = oldText;
            btn.disabled = false;
            Swal.fire('Gagal Upload', err.message, 'error');
        });
    }

    // Fungsi Edit
    window.editKegiatan = function() {
        if (!activeKegiatanId) return;
        
        fetch(`/kegiatan/${activeKegiatanId}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('kegiatan_id').value = data.id_kegiatan;
                document.getElementById('nama_kegiatan').value = data.nama_kegiatan;
                document.getElementById('tanggal_kegiatan').value = data.tanggal_kegiatan;
                document.getElementById('tempat').value = data.tempat;
                document.getElementById('waktu_mulai').value = data.waktu_mulai;
                document.getElementById('waktu_selesai').value = data.waktu_selesai;

                document.getElementById('modalTitle').textContent = 'Edit Kegiatan';
                document.getElementById('editModeIndicator').classList.remove('hidden');
                
                closeDetailModal();
                document.getElementById('addModal').classList.remove('hidden');
            });
    }

    // Fungsi Hapus (PAKAI SWEETALERT CONFIRM)
    window.deleteKegiatan = function() {
        if (!activeKegiatanId) return;
        
        Swal.fire({
            title: 'Yakin hapus?',
            text: "Data kegiatan ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proses Hapus
                fetch(`/kegiatan/${activeKegiatanId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(async res => {
                    const result = await res.json();
                    if (!res.ok) throw new Error(result.message || 'Gagal menghapus');
                    return result;
                })
                .then(res => {
                    Swal.fire('Terhapus!', 'Kegiatan telah dihapus.', 'success').then(() => {
                        location.reload(); // RELOAD HALAMAN
                    });
                })
                .catch(err => {
                    Swal.fire('Gagal!', err.message, 'error');
                });
            }
        })
    }

    // --- FUNGSI VALIDASI BEM ---
    
    window.toggleModeRevisi = function() {
        const container = document.getElementById('formRevisiContainer');
        const btnMinta = document.getElementById('btnMintaRevisi');
        const btnKirim = document.getElementById('btnKirimRevisi');

        container.classList.remove('hidden');
        btnMinta.classList.add('hidden');
        btnKirim.classList.remove('hidden');
    }

    // Submit Validasi (PAKAI SWEETALERT)
    window.submitValidasi = function(statusKeputusan) {
        if(!activeKegiatanId) return;

        const catatan = document.getElementById('inputCatatanRevisi').value;

        if(statusKeputusan === 'revisi' && !catatan.trim()) {
            Swal.fire('Peringatan', 'Wajib mengisi catatan alasan revisi!', 'warning');
            return;
        }

        Swal.fire({
            title: 'Konfirmasi Validasi',
            text: `Anda yakin ingin mengubah status menjadi ${statusKeputusan.toUpperCase()}?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            confirmButtonColor: statusKeputusan === 'diterima' ? '#22c55e' : '#ef4444'
        }).then((result) => {
            if (result.isConfirmed) {
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
                        // SUKSES
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Status LPJ berhasil diperbarui',
                            icon: 'success'
                        }).then(() => {
                            // OPSI 1: RELOAD SUPAYA DATA DI KALENDER JUGA BERUBAH WARNANYA
                            // Kalau mau modal doang yg update, pakai showSideDetail(activeKegiatanId)
                            location.reload(); 
                        });
                    } else {
                        Swal.fire('Gagal', res.message, 'error');
                    }
                })
                .catch(err => Swal.fire('Error', 'Terjadi kesalahan sistem', 'error'));
            }
        });
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
            title.textContent = 'Edit Berita';
            form.action = `/berita/${id}`;
            methodDiv.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            document.getElementById('berita_judul').value = judul;
            document.getElementById('berita_konten').value = konten;
        } else {
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
                document.getElementById('berita_judul').value = data.judul_berita;
                document.getElementById('berita_konten').value = data.konten;
                
                document.getElementById('modalBeritaTitle').textContent = 'Edit Berita';
                document.getElementById('formBerita').action = `/berita/${id}`;
                document.getElementById('beritaMethod').innerHTML = '<input type="hidden" name="_method" value="PUT">';
                
                document.getElementById('modalBerita').classList.remove('hidden');
            });
    }

    window.openDeleteModalBerita = function(actionUrl) {
        const modal = document.getElementById('deleteBeritaModal');
        const form = document.getElementById('deleteBeritaForm');
        form.action = actionUrl; 
        modal.classList.remove('hidden');
    }

    window.closeDeleteModalBerita = function() {
        document.getElementById('deleteBeritaModal').classList.add('hidden');
    }

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('deleteBeritaModal');
        if (event.target === modal) {
            closeDeleteModalBerita();
        }
    });

    // ==========================================
    // FUNGSI PENCARIAN
    // ==========================================
    window.searchEvents = function() {
        const keyword = document.getElementById('searchInput').value.toLowerCase();
        const listContainer = document.getElementById('dailyEventsList');
        const label = document.getElementById('selectedDateLabel');
        
        if (keyword.length < 1) {
            label.textContent = "- Pilih Tanggal -";
            listContainer.innerHTML = `
                <div class="text-center py-10 text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <p class="text-sm">Klik tanggal di kalender<br>untuk melihat daftar kegiatan.</p>
                </div>`;
            return;
        }

        label.textContent = "Hasil Pencarian: " + keyword;
        listContainer.innerHTML = ''; 

        let found = false;

        for (let dateKey in events) {
            const dailyEvents = Array.isArray(events[dateKey]) ? events[dateKey] : [events[dateKey]];
            
            dailyEvents.forEach(event => {
                if (event.nama.toLowerCase().includes(keyword)) {
                    found = true;
                    const item = document.createElement('div');
                    item.className = 'group p-3 rounded-xl border border-orange-100 bg-orange-50/30 hover:bg-orange-50 cursor-pointer transition-all duration-200 mb-3';
                    
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
            Swal.fire('Oops...', 'Pilih tanggal dulu!', 'warning');
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
                Swal.fire('Berhasil!', 'Deadline berhasil disimpan.', 'success').then(() => {
                     showSideDetail(activeKegiatanId); // Update modal tanpa reload
                });
            } else {
                Swal.fire('Gagal', res.message, 'error');
            }
        })
        .catch(err => Swal.fire('Error', 'Terjadi kesalahan sistem', 'error'));
    }
</script>