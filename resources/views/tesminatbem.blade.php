<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hasil Tes Minat - SIMAWA ITH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s;
        }
        
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 1rem;
            max-width: 400px;
            width: 90%;
            animation: slideIn 0.3s;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen p-4 md:p-8">
        <div class="max-w-7xl mx-auto">
            
            <!-- Header dengan tombol kembali -->
            <div class="mb-6 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-2 text-gray-600 hover:text-orange-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">Kembali ke Dashboard</span>
                </a>
            </div>

            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                
                <!-- Header Orange -->
                <div class="bg-gradient-to-r from-orange-400 to-orange-500 px-8 py-12">
                    <h1 class="text-white text-4xl md:text-5xl font-bold">Tes Minat</h1>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                <div class="mx-8 mt-6 px-4 py-3 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                @endif

                <!-- Search Bar -->
                <div class="px-8 py-6 border-b border-gray-200">
                    <form method="GET" action="{{ route('tesminatbem.results') }}" class="flex justify-end">
                        <div class="relative w-full md:w-80">
                            <input 
                                type="text" 
                                name="search" 
                                value="{{ $search }}"
                                placeholder="Cari nama atau NIM..." 
                                class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                            >
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-orange-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Nama</th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">NIM</th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Prodi</th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Angkatan</th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                                <th class="px-8 py-4 text-left text-sm font-semibold text-gray-700">Hasil</th>
                                <th class="px-8 py-4 text-center text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tesMinats as $tes)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-8 py-4 text-sm text-gray-800">
                                    {{ $tes->nama_lengkap ?? ($tes->user->name ?? 'N/A') }}
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-800">
                                    {{ $tes->nim ?? ($tes->user->username ?? 'N/A') }}
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-800">
                                    {{ $tes->program_studi ?? '-' }}
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-800">
                                    {{ $tes->angkatan ?? '-' }}
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-800">
                                    {{ $tes->created_at->format('d F Y') }}
                                </td>
                                <td class="px-8 py-4">
                                    @php
                                        // Extract nama UKM dari hasil_rekomendasi
                                        $hasil = $tes->hasil_rekomendasi;
                                        // Ambil nama sebelum tanda kurung jika ada
                                        $namaUkm = explode(' (', $hasil)[0];
                                    @endphp
                                    <span class="inline-block px-6 py-2 bg-orange-500 text-white text-sm font-semibold rounded-full">
                                        {{ $namaUkm }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <form action="{{ route('tesminatbem.delete', $tes->id_tes) }}" method="POST" class="inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="openDeleteModal(this.form)" class="text-red-600 hover:text-red-800 transition" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-8 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center gap-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-lg font-medium">
                                            @if($search)
                                                Tidak ada hasil untuk pencarian "{{ $search }}"
                                            @else
                                                Belum ada data tes minat
                                            @endif
                                        </p>
                                        @if($search)
                                        <a href="{{ route('tesminatbem.results') }}" class="text-orange-500 hover:text-orange-600 font-medium">
                                            Tampilkan semua data
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Info -->
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                    <p class="text-sm text-gray-600">
                        Total: <span class="font-semibold">{{ $tesMinats->count() }}</span> hasil tes
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="text-center">
                <!-- Icon Warning -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                
                <!-- Title -->
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Hapus Hasil Tes?</h3>
                
                <!-- Message -->
                <p class="text-sm text-gray-600 mb-6">
                    Apakah Anda yakin ingin menghapus hasil tes ini? Data yang dihapus tidak dapat dikembalikan.
                </p>
                
                <!-- Buttons -->
                <div class="flex gap-3 justify-center">
                    <button onclick="closeDeleteModal()" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition font-medium">
                        Batal
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let deleteModal = document.getElementById('deleteModal');
        let deleteFormModal = document.getElementById('deleteForm');
        let currentForm = null;
        
        function openDeleteModal(form) {
            currentForm = form;
            // Copy action dari form asli ke form di modal
            deleteFormModal.action = form.action;
            deleteModal.classList.add('active');
        }
        
        function closeDeleteModal() {
            deleteModal.classList.remove('active');
            currentForm = null;
        }
        
        // Submit form asli saat tombol Hapus di modal diklik
        deleteFormModal.addEventListener('submit', function(e) {
            e.preventDefault();
            if (currentForm) {
                currentForm.submit();
            }
        });
        
        // Close modal when clicking outside
        deleteModal.addEventListener('click', function(e) {
            if (e.target === deleteModal) {
                closeDeleteModal();
            }
        });
        
        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && deleteModal.classList.contains('active')) {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>
