<!DOCTYPE html>
<html>
<head>
    <title>Edit Soal</title>
</head>
<body>

<h1>Edit Soal</h1>

<form action="{{ route('soal.update', $soal->id_soal) }}" method="POST">
    @csrf
    @method('PUT')

    <label>Pertanyaan:</label><br>
    <textarea name="pertanyaan" required>{{ $soal->pertanyaan }}</textarea><br><br>

    <label>Skala Likert:</label><br>
    <input type="number" name="skala_likert" value="{{ $soal->skala_likert }}" required><br><br>

    <button type="submit">Update</button>
</form>

<a href="{{ route('soal.index') }}">Kembali</a>

</body>
</html>
