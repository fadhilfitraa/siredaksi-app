<!DOCTYPE html>
<html>
<head>
    <title>Tambah Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Tambah Siswa Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('siswa.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Contoh: Abdullah Wahid">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenjang Pendidikan</label>
                        <select name="tingkatan" class="form-select" required>
                            <option value=""> Pilih Jenjang </option>
                            <option value="TK">TK (Taman Kanak-kanak)</option> <option value="SD">SD (Sekolah Dasar)</option>
                            <option value="SMP">SMP (Sekolah Menengah Pertama)</option>
                            <option value="SMA">SMA (Sekolah Menengah Atas)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Asal Sekolah</label>
                        <input type="text" name="asal_sekolah" class="form-control" placeholder="Contoh: TK Pertiwi, SD Al Kautsar">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" class="form-control" required placeholder="Contoh: B1, 6B, 12.1">
                    </div>

                    <button type="submit" class="btn btn-success">Simpan</button>
                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>