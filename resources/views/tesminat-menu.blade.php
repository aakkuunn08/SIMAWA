<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Tes Minat - SIMAWA ITH</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="min-h-screen p-4 md:p-8">
        <div class="max-w-5xl mx-auto">
            
            <!-- Header dengan tombol kembali -->
            <div class="mb-8 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-2 text-gray-600 hover:text-orange-500 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm font-medium">Kembali ke Dashboard</span>
                </a>
            </div>

            <!-- Title -->
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-3">Kelola Tes Minat</h1>
                <p class="text-gray-600 text-lg">Pilih menu yang ingin Anda kelola</p>
            </div>

            <!-- Cards Container -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                
                <!-- Card 1: Kelola Pertanyaan -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-8">
                        <!-- Icon -->
                        <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-orange-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        
                        <!-- Title -->
                        <h2 class="text-2xl font-bold text-gray-800 mb-3">Kelola Pertanyaan Tes Minat</h2>
                        
                        <!-- Description -->
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Atur, tambah, edit, dan hapus pertanyaan tes minat mahasiswa
                        </p>
                        
                        <!-- Button -->
                        <a href="{{ route('tesminatbem.pertanyaan') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition-colors group-hover:gap-3">
                            <span>Masuk</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Card 2: Hasil Tes Minat -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                    <div class="p-8">
                        <!-- Icon -->
                        <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mb-6 group-hover:bg-orange-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        
                        <!-- Title -->
                        <h2 class="text-2xl font-bold text-gray-800 mb-3">Hasil Tes Minat Mahasiswa</h2>
                        
                        <!-- Description -->
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Lihat hasil tes minat mahasiswa, lengkap dengan tanggal pengisian
                        </p>
                        
                        <!-- Button -->
                        <a href="{{ route('tesminatbem.results') }}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 text-white rounded-lg font-semibold hover:bg-orange-600 transition-colors group-hover:gap-3">
                            <span>Lihat Hasil</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</body>
</html>
