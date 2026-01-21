<!DOCTYPE html>
<html>
<head>
    <title>Edit Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4>Edit Data Siswa</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="{{ $siswa->nama }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenjang Pendidikan</label>
                        <select name="tingkatan" class="form-select" required>
                            <option value="">-- Pilih Jenjang --</option>
                            <option value="TK" {{ $siswa->tingkatan == 'TK' ? 'selected' : '' }}>TK (Taman Kanak-kanak)</option>
                            <option value="SD" {{ $siswa->tingkatan == 'SD' ? 'selected' : '' }}>SD (Sekolah Dasar)</option>
                            <option value="SMP" {{ $siswa->tingkatan == 'SMP' ? 'selected' : '' }}>SMP (Sekolah Menengah Pertama)</option>
                            <option value="SMA" {{ $siswa->tingkatan == 'SMA' ? 'selected' : '' }}>SMA (Sekolah Menengah Atas)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" class="form-control" value="{{ $siswa->asal_sekolah }}" placeholder="Contoh: TK Pertiwi">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" class="form-control" value="{{ $siswa->kelas }}" required>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>