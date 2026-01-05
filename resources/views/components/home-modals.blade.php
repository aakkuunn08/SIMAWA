
    {{-- MODAL DETAIL (VERSI GUEST - READ ONLY) --}}
    <div id="detailModal" class="modern-modal-overlay hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="modern-modal bg-white max-w-md w-full">
            <div class="modern-modal-header flex justify-between items-center">
                <h3 class="modern-modal-title">Detail Kegiatan</h3>
                <button onclick="closeDetailModal()" class="modern-modal-close">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="modern-modal-body space-y-5">
                {{-- Info Utama --}}
                <div class="flex items-start gap-4">
                    <div class="modern-form-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg></div>
                    <div class="flex-1"><p class="text-xs font-semibold text-gray-500 mb-1">Jadwal</p><p id="detailJadwal" class="text-sm text-gray-800 font-medium"></p></div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="modern-form-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" /></svg></div>
                    <div class="flex-1"><p class="text-xs font-semibold text-gray-500 mb-1">Kegiatan</p><p id="detailKegiatan" class="text-sm text-gray-800"></p></div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="modern-form-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg></div>
                    <div class="flex-1"><p class="text-xs font-semibold text-gray-500 mb-1">Tempat</p><p id="detailTempat" class="text-sm text-gray-800"></p></div>
                </div>
                
                <div class="flex items-start gap-4">
                    <div class="modern-form-icon"><svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg></div>
                    <div class="flex-1"><p class="text-xs font-semibold text-gray-500 mb-1">Penyelenggara</p><p id="detailPenginput" class="text-sm text-gray-800 font-medium">-</p></div>
                </div>

                {{-- Link Download LPJ (Hanya Muncul Jika Ada File) --}}
                <div id="lpjContainer" class="hidden pt-4 mt-2 border-t border-gray-100">
                    <label class="text-xs font-bold text-gray-700 mb-2 block">Dokumen LPJ</label>
                    <div class="p-2 bg-green-50 border border-green-200 rounded-md flex justify-between items-center">
                        <a id="linkLpj" href="#" target="_blank" class="text-xs text-green-700 hover:underline flex items-center gap-1 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download File LPJ
                        </a>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="button" onclick="closeDetailModal()" class="modern-btn modern-btn-secondary">Tutup</button>
                </div>
            </div>
        </div>
    </div>