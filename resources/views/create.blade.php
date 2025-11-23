<!DOCTYPE html>
<html>
<head>
    <title>Tambah Soal</title>
</head>
<body>

<h1>Tambah Soal</h1>

<form action="{{ route('soal.store') }}" method="POST">
    @csrf

    <label>Pertanyaan:</label><br>
    <textarea name="pertanyaan" required></textarea><br><br>

    <label>Skala Likert:</label><br>
    <input type="number" name="skala_likert" required><br><br>

    <button type="submit">Simpan</button>
</form>

<a href="{{ route('soal.index') }}">Kembali</a>

</body>
</html>
