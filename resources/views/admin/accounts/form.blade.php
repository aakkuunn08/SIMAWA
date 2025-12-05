<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isEdit ? 'Edit Akun' : 'Tambah Akun' }} - SIMAWA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex pt-16 min-h-screen">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-6">
            <div class="max-w-2xl mx-auto">
                {{-- Header --}}
                <div class="mb-6">
                    <a href="{{ route('adminbem.accounts.index') }}" 
                       class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ $isEdit ? $account->name : 'Tambah Akun Baru' }}
                    </h1>
                    <p class="text-sm text-gray-600 mt-1">
                        {{ $isEdit ? 'Edit informasi akun organisasi' : 'Buat akun baru untuk organisasi mahasiswa' }}
                    </p>
                </div>

                {{-- Form Card --}}
                <div class="bg-white rounded-lg shadow-md p-6">
                    <form method="POST" 
                          action="{{ $isEdit ? route('adminbem.accounts.update', $account->id) : route('adminbem.accounts.store') }}"
                          enctype="multipart/form-data">
                        @csrf
                        @if($isEdit)
                            @method('PUT')
                        @endif

                        {{-- Logo Preview --}}
                        <div class="flex justify-center mb-6">
                            <div class="relative">
                                <div id="logoPreview" class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border-4 border-gray-200">
                                    @if($isEdit && $account->profile_photo_path)
                                        <img src="{{ asset('storage/' . $account->profile_photo_path) }}" 
                                             alt="Logo"
                                             class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Organization Name --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Organisasi
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $isEdit ? $account->name : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('name') border-red-500 @enderror"
                                   placeholder="Contoh: Hobibie Engineering Robotic of Organization"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="mb-4">
                            <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                Username
                            </label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   value="{{ old('username', $isEdit ? $account->username : '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('username') border-red-500 @enderror"
                                   placeholder="Contoh: hero_ith"
                                   required>
                            @error('username')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password Section --}}
                        <div class="border-t border-gray-200 pt-4 mb-4">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">
                                {{ $isEdit ? 'Ubah Password (Opsional)' : 'Password' }}
                            </h3>
                            
                            @if($isEdit)
                            <p class="text-sm text-gray-600 mb-4">
                                Kosongkan jika tidak ingin mengubah password
                            </p>
                            @endif

                            {{-- New Password --}}
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $isEdit ? 'Password Baru' : 'Password' }}
                                </label>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent @error('password') border-red-500 @enderror"
                                       placeholder="Minimal 8 karakter"
                                       {{ $isEdit ? '' : 'required' }}>
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="mb-4">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Konfirmasi Password
                                </label>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                                       placeholder="Ulangi password"
                                       {{ $isEdit ? '' : 'required' }}>
                            </div>
                        </div>

                        {{-- Change Logo --}}
                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <label for="profile_photo" class="block text-sm font-semibold text-gray-700 mb-2">
                                {{ $isEdit ? 'Ubah Logo' : 'Upload Logo' }}
                            </label>
                            <div class="flex items-center gap-4">
                                <label for="profile_photo" 
                                       class="cursor-pointer bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Pilih File
                                </label>
                                <span id="fileName" class="text-sm text-gray-600">
                                    {{ $isEdit && $account->profile_photo_path ? 'Logo saat ini: ' . basename($account->profile_photo_path) : 'Belum ada file dipilih' }}
                                </span>
                            </div>
                            <input type="file" 
                                   id="profile_photo" 
                                   name="profile_photo" 
                                   accept="image/*"
                                   class="hidden"
                                   onchange="previewLogo(event)">
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG. Maksimal 2MB</p>
                            @error('profile_photo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex gap-3">
                            <a href="{{ route('adminbem.accounts.index') }}" 
                               class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-center py-3 rounded-lg font-medium transition-colors duration-200">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-medium transition-colors duration-200">
                                {{ $isEdit ? 'Simpan Perubahan' : 'Buat Akun' }}
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
        function previewLogo(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('logoPreview');
            const fileName = document.getElementById('fileName');
            
            if (file) {
                fileName.textContent = file.name;
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover">`;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
