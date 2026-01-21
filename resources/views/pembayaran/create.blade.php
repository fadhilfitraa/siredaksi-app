<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Form Input Pembayaran</h4>
            </div>
            <div class="card-body">
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pembayaran.store') }}" method="POST" id="formPembayaran">
                    @csrf 

                    <div class="mb-3">
                        <label class="form-label">Pilih Siswa</label>
                        <select name="siswa_id" class="form-select" required>
                            <option value="">Pilih Nama Siswa</option>
                            @foreach($siswas as $s)
                                <option value="{{ $s->id }}">{{ $s->nama }} - {{ $s->kelas }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="jumlah_bayar" name="jumlah_bayar" class="form-control" placeholder="Contoh: 500.000" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan Data</button>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
                </form>

            </div>
        </div>
    </div>

    <script>
        // 1. Tangkap elemen input dan form
        let inputJumlah = document.getElementById('jumlah_bayar');
        let form = document.getElementById('formPembayaran');

        // 2. Fungsi Format Rupiah (Saat mengetik)
        inputJumlah.addEventListener('keyup', function(e) {
            // Hapus karakter selain angka
            let value = this.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            this.value = rupiah;
        });

        // 3. Fungsi Bersihkan Titik (Saat Simpan)
        form.addEventListener('submit', function(e) {
            // Sebelum dikirim ke database, hapus semua titik
            // Contoh: "500.000" jadi "500000"
            inputJumlah.value = inputJumlah.value.replace(/\./g, '');
        });
    </script>
</body>
</html>