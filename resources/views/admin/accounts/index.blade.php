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
                    <p class="text-sm text-gray-600 mt-1">Kelola akun dan profil organisasi mahasiswa</p>
                </div>
                <a href="{{ route('adminbem.accounts.create') }}" 
                   class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Akun
                </a>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 transition-colors">
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
                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100">
                    {{-- Card Content --}}
                    <div class="p-6 flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full bg-gray-50 flex items-center justify-center mb-4 overflow-hidden border-2 border-orange-100 shadow-inner">
                            @if($account->profile_photo_path)
                                <img src="{{ asset('storage/' . $account->profile_photo_path) }}"
                                     alt="{{ $account->name }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="bg-orange-50 w-full h-full flex items-center justify-center">
                                    <span class="text-2xl font-bold text-orange-300">{{ substr($account->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-900 text-center leading-tight mb-1">{{ $account->name }}</h3>
                        <p class="text-sm text-gray-500 font-medium mb-4">@ {{ $account->username }}</p>

                        {{-- Ormawa Badge Info --}}
                        <div class="w-full bg-gray-50 rounded-lg p-3 border border-gray-100">
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400">Tipe Organisasi</span>
                                <span class="px-2 py-0.5 bg-orange-100 text-orange-600 rounded text-[10px] font-bold uppercase">
                                    {{ $account->ormawa->tipe->nama_tipe ?? 'Umum' }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600 truncate">Slug: <span class="font-mono text-orange-500">{{ $account->ormawa->slug ?? '-' }}</span></p>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('adminbem.accounts.edit', $account->id) }}" 
                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold py-2.5 rounded-lg text-center transition-colors">
                            Edit Akun
                        </a>
                        <button onclick="confirmDelete({{ $account->id }}, '{{ $account->name }}')"
                                class="flex-1 bg-white hover:bg-red-50 text-red-500 border border-red-100 text-sm font-bold py-2.5 rounded-lg transition-all duration-200">
                            Hapus
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-white rounded-xl shadow-sm p-16 text-center border border-dashed border-gray-300">
                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Data Akun Kosong</h3>
                <p class="text-gray-500 mb-6 max-w-xs mx-auto">Anda belum memiliki akun organisasi mahasiswa yang terdaftar di sistem.</p>
                <a href="{{ route('adminbem.accounts.create') }}" 
                   class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-bold transition-all shadow-md">
                    Tambah Akun Sekarang
                </a>
            </div>
            @endif
        </main>
    </div>

    @include('components.navbar')

    {{-- Delete Modal --}}
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 z-[60] backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-sm w-full p-8 text-center shadow-2xl">
            <div class="w-16 h-16 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Akun?</h3>
            <p class="text-sm text-gray-500 mb-8 leading-relaxed">Akun <span id="accountName" class="font-bold text-gray-800"></span> dan seluruh data organisasinya akan dihapus permanen.</p>
            
            <form id="deleteForm" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" 
                        class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-600 rounded-lg font-bold hover:bg-gray-50">Batal</button>
                <button type="submit" class="flex-1 px-4 py-2.5 bg-red-500 text-white rounded-lg font-bold hover:bg-red-600 shadow-sm transition-colors">Hapus</button>
            </form>
        </div>
    </div>

    <script>
        function closeEditModal() {
            document.getElementById('modal-edit').classList.add('hidden');
        }

        function confirmDelete(accountId, accountName) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('accountName').textContent = accountName;
            document.getElementById('deleteForm').action = `/adminbem/accounts/${accountId}`;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close on outside click
        window.onclick = function(event) {
            if (event.target.id === 'modal-edit') closeEditModal();
            if (event.target.id === 'deleteModal') closeDeleteModal();
        }
    </script>
</body>
</html>