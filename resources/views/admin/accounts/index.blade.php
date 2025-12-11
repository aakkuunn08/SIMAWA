<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manajemen Akun - SIMAWA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex pt-16 min-h-screen">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-6">
            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Unit Kegiatan Mahasiswa</h1>
                    <p class="text-sm text-gray-600 mt-1">Kelola akun organisasi mahasiswa</p>
                </div>
                <a href="{{ route('adminbem.accounts.create') }}" 
                   class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Akun
                </a>
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

            {{-- Accounts Grid --}}
            @if($accounts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($accounts as $account)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200 overflow-hidden">
                    {{-- Card Header with Logo --}}
                    <div class="p-6 flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full bg-gray-100 flex items-center justify-center mb-4 overflow-hidden border-2 border-gray-200">
                            @if($account->profile_photo_path)
                                <img src="{{ asset('storage/' . $account->profile_photo_path) }}"
                                     alt="{{ $account->name }}"
                                     class="w-full h-full object-cover">
                            @elseif($account->ormawa && $account->ormawa->logo)
                                <img src="{{ asset($account->ormawa->logo) }}"
                                     alt="{{ $account->name }}"
                                     class="w-full h-full object-contain p-2">
                            @else
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            @endif
                        </div>
                        
                        <h3 class="text-lg font-semibold text-gray-900 text-center mb-1">{{ $account->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $account->username }}</p>

                        {{-- Ormawa Info --}}
                        @if($account->ormawa)
                        <div class="w-full bg-green-50 rounded-lg p-3 mb-4 border border-green-200">
                            <p class="text-xs text-green-600 mb-1">Informasi Ormawa:</p>
                            <p class="text-sm font-medium text-gray-800">{{ $account->ormawa->nama }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst($account->ormawa->tipe) }}</p>
                        </div>
                        @else
                        <div class="w-full bg-yellow-50 rounded-lg p-3 mb-4 border border-yellow-200">
                            <p class="text-xs text-yellow-700">⚠️ Belum ada informasi ormawa</p>
                        </div>
                        @endif
                    </div>

                    {{-- Card Actions --}}
                    <div class="border-t border-gray-200 px-6 py-4">
                        {{-- Ormawa Action Button --}}
                        @if($account->ormawa)
                        <a href="{{ route('adminbem.ormawa.edit', $account->ormawa->id) }}" 
                           class="w-full bg-green-500 hover:bg-green-600 text-white text-center py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center gap-2 mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Informasi Ormawa
                        </a>
                        @else
                        <a href="{{ route('adminbem.ormawa.create', $account->id) }}" 
                           class="w-full bg-orange-500 hover:bg-orange-600 text-white text-center py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center gap-2 mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Informasi Ormawa
                        </a>
                        @endif
                        
                        {{-- Account Actions --}}
                        <div class="flex gap-2">
                            <a href="{{ route('adminbem.accounts.edit', $account->id) }}" 
                               class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-center py-2 rounded-lg font-medium transition-colors duration-200">
                                Edit Akun
                            </a>
                            <button onclick="confirmDelete({{ $account->id }}, '{{ $account->name }}')"
                                    class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium transition-colors duration-200">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Akun</h3>
                <p class="text-gray-600 mb-4">Mulai dengan menambahkan akun organisasi pertama</p>
                <a href="{{ route('adminbem.accounts.create') }}" 
                   class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Akun
                </a>
            </div>
            @endif
        </main>
    </div>

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Delete Confirmation Modal --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi Hapus</h3>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus akun <span id="accountName" class="font-semibold"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            
            <form id="deleteForm" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" 
                        class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-2 rounded-lg font-medium transition-colors duration-200">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium transition-colors duration-200">
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <script>
        function confirmDelete(accountId, accountName) {
            const modal = document.getElementById('deleteModal');
            const form = document.getElementById('deleteForm');
            const nameSpan = document.getElementById('accountName');
            
            form.action = `/adminbem/accounts/${accountId}`;
            nameSpan.textContent = accountName;
            modal.classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>
