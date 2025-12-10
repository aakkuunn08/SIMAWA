<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit Informasi Ormawa' : 'Tambah Informasi Ormawa' }} - SIMAWA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex pt-16 min-h-screen">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-6">
            <div class="max-w-3xl mx-auto">
                {{-- Header --}}
                <div class="mb-6">
                    <a href="{{ route('adminbem.accounts.index') }}" 
                       class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Daftar Akun
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ $isEdit ? 'Edit Informasi Ormawa' : 'Tambah Informasi Ormawa' }}
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        Untuk akun: <span class="font-semibold">{{ $user->name }}</span> ({{ $user->username }})
                    </p>
                </div>

                {{-- Success Message --}}
                @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                @endif

                {{-- Form Card --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <form method="POST" 
                          action="{{ $isEdit ? route('adminbem.ormawa.update', $ormawa->id) : route('adminbem.ormawa.store', $user->id) }}">
                        @csrf
                        @if($isEdit)
                            @method('PUT')
                        @endif

                        {{-- Logo Preview --}}
                        <div class="mb-6 text-center">
                            <p class="text-sm font-semibold text-gray-700 mb-3">Logo Organisasi</p>
                            <div class="flex justify-center">
                                <div class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border-4 border-orange-200">
                                    @if($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                                             alt="Logo"
                                             class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Logo diambil dari foto profil akun. 
                                <a href="{{ route('adminbem.accounts.edit', $user->id) }}" class="text-orange-500 hover:text-orange-600">
                                    Edit akun untuk mengubah logo
                                </a>
                            </p>
                        </div>

                        {{-- Nama Organisasi --}}
                        <div class="mb-4">
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Organisasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="nama" 
                                   name="nama" 
                                   value="{{ old('nama', $isEdit ? $ormawa->nama : $user->name) }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('nama') border-red-500 @enderror"
                                   placeholder="Contoh: HERO (Habibie Engineering Robotic of Organization)"
                                   required>
                            @error('nama')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Nama lengkap organisasi yang akan ditampilkan</p>
                        </div>

                        {{-- Slug --}}
                        <div class="mb-4">
                            <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">
                                Slug (URL) <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-600">simawa.com/ormawa/</span>
                                <input type="text" 
                                       id="slug" 
                                       name="slug" 
                                       value="{{ old('slug', $isEdit ? $ormawa->slug : '') }}"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                                       placeholder="hero"
                                       pattern="[a-z0-9-]+"
                                       required>
                            </div>
                            @error('slug')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Hanya huruf kecil, angka, dan tanda hubung (-). Contoh: hero, hcc, seni</p>
                        </div>

                        {{-- Tipe --}}
                        <div class="mb-4">
                            <label for="tipe" class="block text-sm font-semibold text-gray-700 mb-2">
                                Tipe Organisasi <span class="text-red-500">*</span>
                            </label>
                            <select id="tipe" 
                                    name="tipe" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('tipe') border-red-500 @enderror"
                                    required>
                                <option value="">Pilih Tipe</option>
                                <option value="ukm" {{ old('tipe', $isEdit ? $ormawa->tipe : '') == 'ukm' ? 'selected' : '' }}>
                                    UKM (Unit Kegiatan Mahasiswa)
                                </option>
                                <option value="bem" {{ old('tipe', $isEdit ? $ormawa->tipe : '') == 'bem' ? 'selected' : '' }}>
                                    BEM (Badan Eksekutif Mahasiswa)
                                </option>
                                <option value="komunitas" {{ old('tipe', $isEdit ? $ormawa->tipe : '') == 'komunitas' ? 'selected' : '' }}>
                                    Komunitas
                                </option>
                            </select>
                            @error('tipe')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-6">
                            <label for="deskripsi" class="block text-sm font-semibold text-gray-700 mb-2">
                                Deskripsi Singkat
                            </label>
                            <textarea id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('deskripsi') border-red-500 @enderror"
                                      placeholder="Deskripsi singkat tentang organisasi...">{{ old('deskripsi', $isEdit ? $ormawa->deskripsi : '') }}</textarea>
                            @error('deskripsi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Opsional. Deskripsi akan ditampilkan di halaman organisasi</p>
                        </div>

                        {{-- Info Box --}}
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold mb-1">Informasi Penting:</p>
                                    <ul class="list-disc list-inside space-y-1 text-xs">
                                        <li>Logo organisasi akan otomatis menggunakan foto profil dari akun</li>
                                        <li>Slug harus unik dan akan digunakan sebagai URL halaman organisasi</li>
                                        <li>Informasi detail (visi, misi, struktur) dapat dikelola di halaman ormawa</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Buttons --}}
                        <div class="flex gap-3">
                            <a href="{{ route('adminbem.accounts.index') }}" 
                               class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-center py-3 rounded-lg font-medium transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-medium transition-colors duration-200">
                                {{ $isEdit ? 'Simpan Perubahan' : 'Tambah Informasi' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    {{-- Navbar --}}
    @include('components.navbar')

    <script>
        // Auto-generate slug from nama
        document.getElementById('nama').addEventListener('input', function(e) {
            const slugInput = document.getElementById('slug');
            // Only auto-generate if slug is empty or in create mode
            if (!slugInput.value || !{{ $isEdit ? 'true' : 'false' }}) {
                const slug = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();
                slugInput.value = slug;
            }
        });
    </script>
</body>
</html>
