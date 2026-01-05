<script>
    // 1. Variabel Global & Data
    const events = JSON.parse(`{!! json_encode($sevents ?? []) !!}`);
    const today = new Date();
    let currentMonth = today.getMonth();
    let currentYear = today.getFullYear();
    const grid = document.getElementById('calendarGrid');
    const monthLabel = document.getElementById('monthLabel');

    // 2. Fungsi Helper: Bikin Pill Oranye (Sama dengan Dashboard)
    function createEventPill(parent, text) {
        const ev = document.createElement('div');
        ev.className = 'w-full bg-orange-100 text-orange-700 text-[10px] px-1 py-0.5 rounded truncate mt-0.5 font-medium border border-orange-200/50';
        ev.textContent = text;
        parent.appendChild(ev);
    }

    // 3. Render Calendar (Versi Home dengan LIMIT 2)
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
            
            // ONCLICK: Panggil updateSidebarList (Khusus Tamu)
            cell.onclick = () => updateSidebarList(year, month, d);
            
            cell.className = 'flex flex-col items-center justify-start cursor-pointer hover:bg-orange-50 transition p-1 min-h-[80px] rounded-lg border border-transparent hover:border-orange-100 relative';

            // Angka Tanggal
            const dateEl = document.createElement('div');
            dateEl.textContent = d;
            dateEl.className = 'text-sm mb-1 font-medium text-gray-700';
            
            if (year === today.getFullYear() && month === today.getMonth() && d === today.getDate()) {
                dateEl.className = 'w-7 h-7 flex items-center justify-center bg-orange-500 text-white rounded-full text-xs font-bold shadow-md mb-1';
            }
            cell.appendChild(dateEl);

            // --- LOGIKA LIMIT 2 BARIS (SAMA PERSIS DASHBOARD) ---
            const key = `${year}-${String(month + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            
            if (events[key]) {
                const eventList = Array.isArray(events[key]) ? events[key] : [events[key]];
                const maxDisplay = 2; // Batas tampil
                
                eventList.forEach((event, index) => {
                    // Kalau total <= 3, tampilkan semua
                    if (eventList.length <= 3) {
                         createEventPill(cell, event.nama);
                    } 
                    // Kalau > 3, tampilkan 2 saja + sisanya
                    else {
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

    // 4. Update Sidebar (Versi Guest)
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
                item.onclick = () => openDetailModal(event.id);
                
                item.innerHTML = `
                    <div class="flex justify-between items-start mb-1">
                        <h4 class="font-bold text-gray-800 text-sm group-hover:text-orange-600 line-clamp-2">${event.nama}</h4>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>${event.waktu_mulai ? event.waktu_mulai.substring(0,5) : '-'}</span>
                    </div>
                `;
                listContainer.appendChild(item);
            });
        } else {
            listContainer.innerHTML = `
                <div class="text-center py-8 text-gray-400 bg-gray-50 rounded-xl border border-dashed border-gray-200">
                    <p class="text-sm font-medium">Tidak ada kegiatan</p>
                    <p class="text-xs">pada tanggal ini</p>
                </div>
            `;
        }
    }

    // 5. Modal Detail (Versi Guest & AES Check)
    function openDetailModal(eventId) {
        fetch(`/kegiatan/${eventId}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('detailKegiatan').textContent = data.nama_kegiatan;
                document.getElementById('detailTempat').textContent = data.tempat;
                
                const penginput = (data.user && data.user.name) ? data.user.name : 'Admin';
                document.getElementById('detailPenginput').textContent = penginput;

                const date = new Date(data.tanggal_kegiatan);
                const hari = date.toLocaleDateString('id-ID', { weekday: 'long' });
                const tgl = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                const jam = (data.waktu_mulai && data.waktu_selesai) ? `${data.waktu_mulai.substring(0,5)} - ${data.waktu_selesai.substring(0,5)}` : '';
                document.getElementById('detailJadwal').textContent = `${hari}, ${tgl}, ${jam}`;

                // Logika LPJ Tamu
                const lpjContainer = document.getElementById('lpjContainer');
                const linkLpj = document.getElementById('linkLpj');
                
                if (data.lpj && data.lpj.file_lpj) {
                    lpjContainer.classList.remove('hidden');
                    // Cek login via blade
                    const isGuest = {{ auth()->check() ? 'false' : 'true' }};

                    if (isGuest) {
                        linkLpj.href = "{{ route('login') }}";
                        linkLpj.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg> Login untuk Download (AES)`;
                        linkLpj.onclick = (e) => {
                            if(!confirm('File ini terenkripsi. Silakan login untuk mengunduh.')) e.preventDefault();
                        };
                        linkLpj.parentElement.className = "p-2 bg-gray-100 border border-gray-200 rounded-md flex justify-between items-center text-gray-500 cursor-not-allowed";
                    } else {
                        linkLpj.href = `/kegiatan/${eventId}/download-lpj`;
                        linkLpj.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg> Download LPJ`;
                        linkLpj.parentElement.className = "p-2 bg-green-50 border border-green-200 rounded-md flex justify-between items-center";
                        linkLpj.onclick = null;
                    }
                } else {
                    lpjContainer.classList.add('hidden');
                }
                document.getElementById('detailModal').classList.remove('hidden');
            });
    }

    function closeDetailModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }

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

                    // Tetap memfungsikan klik detail untuk Guest
                    item.onclick = () => openDetailModal(event.id);

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

    // Init
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

        // Render Awal
        renderCalendar(currentYear, currentMonth);

        // --- SCROLLSPY (Biar Navigasi Oranye jalan) ---
        const navLinks = document.querySelectorAll('nav a[href^="#"]');
        const sections = document.querySelectorAll('section[id]');

        if(navLinks.length > 0 && sections.length > 0) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        navLinks.forEach(link => {
                            link.classList.remove('text-orange-500', 'font-bold');
                            if(link.getAttribute('href') === '#' + entry.target.id) {
                                link.classList.add('text-orange-500', 'font-bold');
                            }
                        });
                    }
                });
            }, { rootMargin: '-50% 0px -50% 0px' });

            sections.forEach(section => observer.observe(section));
        }
    });
</script>