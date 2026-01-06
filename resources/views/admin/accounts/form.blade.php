<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $isEdit ? 'Edit Akun' : 'Tambah Akun' }} - SIMAWA</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="flex pt-16 min-h-screen">
        @include('components.sidebar')

        <main class="flex-1 md:ml-64 p-6">
            <div class="max-w-2xl mx-auto">
                <div class="mb-6">
                    <a href="{{ route('adminbem.accounts.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-4">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Kembali
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $isEdit ? 'Edit: ' . $account->name : 'Tambah Akun Baru' }}</h1>
                </div>

                <div class="bg-white rounded-lg shadow-md p-6">
                    <form method="POST" action="{{ $isEdit ? route('adminbem.accounts.update', $account->id) : route('adminbem.accounts.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if($isEdit) @method('PUT') @endif

                        {{-- Logo Preview --}}
                        <div class="flex justify-center mb-6">
                            <div id="logoPreview" class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border-4 border-gray-200">
                                @if($isEdit && $account->profile_photo_path)
                                    <img src="{{ asset('storage/' . $account->profile_photo_path) }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                @endif
                            </div>
                        </div>

                        <div class="mb-8 text-center">
                            <label for="profile_photo" class="cursor-pointer bg-gray-100 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-200">Ganti Logo</label>
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="hidden" onchange="previewLogo(event)">
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Organisasi</label>
                                <input type="text" name="name" value="{{ old('name', $isEdit ? $account->name : '') }}" required class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-orange-500">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                                <input type="text" name="username" value="{{ old('username', $isEdit ? $account->username : '') }}" required class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-orange-500">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password {{ $isEdit ? '(Opsional)' : '' }}</label>
                                    <input type="password" name="password" {{ $isEdit ? '' : 'required' }} class="w-full px-4 py-2 border rounded-lg outline-none">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" {{ $isEdit ? '' : 'required' }} class="w-full px-4 py-2 border rounded-lg outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Ormawa</label>
                                <div class="flex gap-2">
                                    <select name="tipe_ormawa_id" id="tipe_select" class="flex-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-orange-500" required>
                                        <option value="">-- Pilih Tipe --</option>
                                        @foreach($tipes as $tipe)
                                            <option value="{{ $tipe->id }}" {{ old('tipe_ormawa_id', $isEdit && $account->ormawa ? $account->ormawa->tipe_ormawa_id : '') == $tipe->id ? 'selected' : '' }}>
                                                {{ $tipe->nama_tipe }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="button" onclick="toggleModal('modal-tipe', true)" class="bg-green-100 p-2 rounded-lg hover:bg-green-200 text-green-600 shadow-sm" title="Tambah Tipe">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    </button>
                                    <button type="button" onclick="deleteSelectedTipe()" class="bg-red-100 p-2 rounded-lg hover:bg-red-200 text-red-600 shadow-sm" title="Hapus Tipe">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-3 mt-10">
                            <a href="{{ route('adminbem.accounts.index') }}" class="flex-1 bg-gray-200 text-center py-3 rounded-lg font-medium">Batal</a>
                            <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-bold shadow-lg">
                                {{ $isEdit ? 'Simpan Perubahan' : 'Buat Akun' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    {{-- MODAL TIPE (Hanya 1 Baris Kode di sini) --}}
    <div id="modal-tipe" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[100] flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-sm w-full p-6 shadow-2xl">
            <h3 class="text-lg font-bold mb-4">Tambah Tipe Baru</h3>
            <form action="{{ route('adminbem.tipe.store') }}" method="POST">
                @csrf
                <input type="text" name="nama_tipe" placeholder="Contoh: UKM, SC, Komunitas" class="w-full border rounded-lg px-4 py-2 mb-4 focus:ring-2 focus:ring-orange-500" required>
                <div class="flex gap-2">
                    <button type="button" onclick="toggleModal('modal-tipe', false)" class="flex-1 bg-gray-100 py-2 rounded-lg font-bold">Batal</button>
                    <button type="submit" class="flex-1 bg-orange-500 text-white py-2 rounded-lg font-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <form id="delete-tipe-form" method="POST" style="display:none;">
        @csrf @method('DELETE')
    </form>

    @include('components.navbar')

    <script>
        function previewLogo(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('logoPreview');
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                reader.readAsDataURL(file);
            }
        }

        function toggleModal(id, show) {
            document.getElementById(id).classList.toggle('hidden', !show);
        }

        function deleteSelectedTipe() {
            const id = document.getElementById('tipe_select').value;
            if (!id) return alert('Pilih tipe dulu!');
            if (confirm('Yakin mau hapus tipe ini?')) {
                const form = document.getElementById('delete-tipe-form');
                form.action = `/adminbem/tipe-ormawa/${id}`;
                form.submit();
            }
        }
    </script>
</body>
</html>