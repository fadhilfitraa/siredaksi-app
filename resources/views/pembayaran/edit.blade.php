<!DOCTYPE html>
<html>
<head>
    <title>Edit Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h4>Edit Data Pembayaran</h4>
            </div>
            <div class="card-body">
                
                <form action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST" id="formEdit">
                    @csrf 
                    @method('PUT') 

                    <div class="mb-3">
                        <label class="form-label">Pilih Siswa</label>
                        <select name="siswa_id" class="form-select" required>
                            @foreach($siswas as $s)
                                <option value="{{ $s->id }}" {{ $pembayaran->siswa_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->nama }} - {{ $s->kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Bayar</label>
                        <input type="date" name="tanggal_bayar" class="form-control" value="{{ $pembayaran->tanggal_bayar }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jumlah Bayar (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" id="jumlah_bayar" name="jumlah_bayar" class="form-control" value="{{ $pembayaran->jumlah_bayar }}" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success">Update Data</button>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary">Batal</a>
                </form>

            </div>
        </div>
    </div>

    <script>
        let inputJumlah = document.getElementById('jumlah_bayar');
        let form = document.getElementById('formEdit');

        // Fungsi format manual
        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, '').toString(),
            split   = number_string.split(','),
            sisa    = split[0].length % 3,
            rupiah  = split[0].substr(0, sisa),
            ribuan  = split[0].substr(sisa).match(/\d{3}/gi);

            if(ribuan){
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        }

        // 1. Saat mengetik
        inputJumlah.addEventListener('keyup', function(e) {
            this.value = formatRupiah(this.value);
        });

        // 2. Saat halaman baru dibuka (Load), format angka dari database
        // Supaya "500000" otomatis jadi "500.000" pas edit dibuka
        window.addEventListener('load', function() {
            inputJumlah.value = formatRupiah(inputJumlah.value);
        });

        // 3. Saat Simpan, HAPUS titiknya lagi
        form.addEventListener('submit', function(e) {
            inputJumlah.value = inputJumlah.value.replace(/\./g, '');
        });
    </script>
</body>
</html>