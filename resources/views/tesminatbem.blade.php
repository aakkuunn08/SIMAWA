<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Tes Minat - SIMAWA ITH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tesMinats as $tes)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-8 py-4 text-sm text-gray-800">
                                    {{ $tes->nama_lengkap ?? 'N/A' }}
                                </td>
                                <td class="px-8 py-4 text-sm text-gray-800">
                                    {{ $tes->nim ?? 'N/A' }}
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
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center text-gray-500">
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
</body>
</html>
