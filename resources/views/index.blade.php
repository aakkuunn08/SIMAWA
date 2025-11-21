<!DOCTYPE html>
<html>
<head>
    <title>Daftar Soal</title>
</head>
<body>

<h1>Daftar Soal</h1>

<a href="{{ route('soal.create') }}">+ Tambah Soal</a>

@if (session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="6">
    <tr>
        <th>ID</th>
        <th>Pertanyaan</th>
        <th>Skala Likert</th>
        <th>Aksi</th>
    </tr>

    @foreach($soal as $s)
    <tr>
        <td>{{ $s->id_soal }}</td>
        <td>{{ $s->pertanyaan }}</td>
        <td>{{ $s->skala_likert }}</td>
        <td>
            <a href="{{ route('soal.edit', $s->id_soal) }}">Edit</a> |
            <form action="{{ route('soal.destroy', $s->id_soal) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Yakin hapus?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

</body>
</html>
