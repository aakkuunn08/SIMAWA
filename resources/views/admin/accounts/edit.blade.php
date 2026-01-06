@extends('layouts.main')

@section('content')
<div class="p-8">
    <h2 class="text-2xl font-bold mb-6">Edit Akun Ormawa</h2>

    <form action="{{ route('adminbem.accounts.update', $user->id) }}" method="POST" class="max-w-lg bg-white p-6 rounded-xl shadow-md">
        @csrf
        @method('PUT') {{-- Penting: Laravel butuh ini untuk Update --}}

        <div class="mb-4">
            <label class="block text-sm font-bold mb-2">Nama Akun/Ormawa</label>
            <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold mb-2">Username</label>
            <input type="text" name="username" value="{{ $user->username }}" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold mb-2">Tipe Ormawa</label>
            <select name="tipe_ormawa_id" class="w-full border rounded-lg px-3 py-2">
                @foreach($tipe_ormawa as $tipe)
                    <option value="{{ $tipe->id }}" {{ $user->ormawa->tipe_ormawa_id == $tipe->id ? 'selected' : '' }}>
                        {{ $tipe->nama_tipe }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-bold mb-2">Password (Kosongkan jika tidak ganti)</label>
            <input type="password" name="password" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-lg">Simpan Perubahan</button>
            <a href="{{ route('adminbem.accounts.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</a>
        </div>
    </form>
</div>
@endsection