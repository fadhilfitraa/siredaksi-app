<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pembayaran - Bimbel Al-Kautsar</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        
        /* Navbar Gradient Oranye untuk Mode Edit */
        .navbar { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); }
        .navbar-brand { letter-spacing: 1px; font-weight: 700; color: #212529 !important; }
        
        /* Card Styling */
        .card-form { border: none; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden; }
        .card-header-pro { background-color: #ffffff; padding: 25px 30px; border-bottom: 1px solid #edf2f9; display: flex; align-items: center; justify-content: space-between; }

        .form-label { font-size: 0.8rem; text-transform: uppercase; font-weight: 700; color: #6c757d; margin-bottom: 8px; }
        .form-control, .form-select { padding: 12px 15px; border-radius: 8px; border: 1px solid #dee2e6; }
        .form-control:focus, .form-select:focus { border-color: #ffc107; box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25); }
        
        .input-rupiah { font-size: 1.8rem; font-weight: bold; color: #fd7e14; letter-spacing: 1px; }
        .select2-container--bootstrap-5 .select2-selection { border-radius: 8px; padding: 8px 15px; min-height: 48px; }
        
        .btn-back { border-radius: 50px; padding: 8px 25px; font-weight: 600; }
        .btn-update { border-radius: 50px; padding: 12px 40px; font-weight: 700; font-size: 1.1rem; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand mb-0 h1" href="{{ route('dashboard') }}">
                <i class="fas fa-graduation-cap me-2"></i>SIREDAKSI BIMBEL AL KAUTSAR
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <span class="fw-bold text-dark opacity-75 d-none d-lg-block">
                    <i class="fas fa-edit me-2"></i> EDIT DATA TRANSAKSI
                </span>
            </div>
        </div>
    </nav>

    <div class="container pb-5" style="max-width: 1200px;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Edit Pembayaran</h2>
                <p class="text-muted mb-0">Perbarui data jika terjadi kesalahan input.</p>
            </div>
            <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary btn-back shadow-sm bg-white text-dark border-0">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                
                <form id="paymentForm" action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
                    @csrf
                    @method('PUT') 
                    
                    <div class="card card-form">
                        
                        <div class="card-header-pro border-warning border-bottom border-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                    <i class="fas fa-edit fa-lg text-dark"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0">Formulir Perubahan</h5>
                                    <span class="text-muted small">Data terakhir diupdate: {{ $pembayaran->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="d-none d-md-block">
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                                    <i class="fas fa-pen me-1"></i> Mode Edit
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-4 p-md-5">
                            
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4 border-0 shadow-sm rounded-3">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-5">
                                
                                <div class="col-lg-6">
                                    <div class="mb-4">
                                        <label class="form-label">Nama Siswa</label>
                                        <select name="siswa_id" class="form-select select-siswa" required>
                                            <option value="" disabled>-- Pilih Siswa --</option>
                                            @foreach($siswas as $s)
                                                <option value="{{ $s->id }}" {{ $pembayaran->siswa_id == $s->id ? 'selected' : '' }}>
                                                    {{ $s->nama }} - {{ $s->kelas }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Tanggal Bayar</label>
                                            <input type="date" id="tanggal_bayar" name="tanggal_bayar" class="form-control" value="{{ $pembayaran->tanggal_bayar }}" required>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Untuk Bulan</label>
                                            <select id="bulan_bayar" name="bulan_bayar" class="form-select" data-selected="{{ $pembayaran->bulan_bayar }}" required>
                                                </select>
                                        </div>
                                    </div>

                                   <div class="mb-3">
                                <label class="form-label">Metode Pembayaran</label>
                                <div class="d-flex gap-3">
                                    <div class="form-check border rounded p-3 flex-fill bg-white position-relative">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran" value="Tunai" id="tunai" checked style="cursor: pointer;">
                                        <label class="form-check-label fw-bold w-100 stretched-link" for="tunai" style="cursor: pointer;">
                                            <i class="fas fa-money-bill-wave me-2 text-success"></i> Tunai
                                        </label>
                                    </div>
                                    <div class="form-check border rounded p-3 flex-fill bg-white position-relative">
                                        <input class="form-check-input" type="radio" name="metode_pembayaran" value="Transfer" id="transfer" style="cursor: pointer;">
                                        <label class="form-check-label fw-bold w-100 stretched-link" for="transfer" style="cursor: pointer;">
                                            <i class="fas fa-university me-2 text-primary"></i> Transfer
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                                <div class="col-lg-6 border-start ps-lg-5">
                                    
                                    <div class="mb-5 bg-light p-4 rounded-3 border border-warning border-opacity-50">
                                        <label class="form-label text-warning mb-2">NOMINAL (Rp)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 fw-bold text-warning fs-3">Rp</span>
                                            <input type="text" id="rupiah" class="form-control input-rupiah border-start-0 ps-1" 
                                                   value="{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}" required>
                                            
                                            <input type="hidden" name="jumlah_bayar" id="jumlah_bayar_clean" value="{{ $pembayaran->jumlah_bayar }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Catatan</label>
                                        <textarea name="keterangan" class="form-control" rows="4">{{ $pembayaran->keterangan }}</textarea>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-white p-4 text-end border-top">
                            <button type="submit" class="btn btn-warning btn-update shadow text-dark">
                                <i class="fas fa-save me-2"></i> UPDATE PERUBAHAN
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // 1. Select2
            $('.select-siswa').select2({ theme: 'bootstrap-5', width: '100%' });

            // 2. Format Rupiah Logic
            var rupiah = document.getElementById('rupiah');
            var cleanInput = document.getElementById('jumlah_bayar_clean');

            rupiah.addEventListener('keyup', function(e) {
                rupiah.value = formatRupiah(this.value);
                cleanInput.value = rupiah.value.replace(/\./g, '');
            });

            function formatRupiah(angka) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split   = number_string.split(','),
                    sisa    = split[0].length % 3,
                    rupiah  = split[0].substr(0, sisa),
                    ribuan  = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                return split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            }

            // 3. LOGIKA BULAN DINAMIS (Sama seperti Create)
            const tanggalInput = document.getElementById('tanggal_bayar');
            const bulanSelect = document.getElementById('bulan_bayar');
            const selectedBulanAwal = bulanSelect.getAttribute('data-selected'); // Ambil nilai lama dari database

            const namaBulan = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            function updateBulanOptions() {
                const tanggalValue = new Date(tanggalInput.value);
                const tahunPilih = tanggalValue.getFullYear();
                
                // Simpan nilai yang sedang dipilih user sebelum opsi di-reset (jika ada)
                const currentValue = bulanSelect.value; 

                bulanSelect.innerHTML = '';

                namaBulan.forEach((bulan) => {
                    let option = document.createElement('option');
                    let valueTeks = `${bulan} ${tahunPilih}`;
                    option.value = valueTeks;
                    option.text = valueTeks;

                    // Logika Seleksi Otomatis:
                    // 1. Jika ini load pertama kali, pilih sesuai data database (selectedBulanAwal)
                    // 2. Jika user mengubah tanggal, coba pertahankan bulan yang sama tapi tahun baru (opsional)
                    // 3. Di sini kita prioritaskan data database saat load awal.
                    
                    if (valueTeks === selectedBulanAwal && !bulanSelect.hasAttribute('data-changed')) {
                        option.selected = true;
                    } 
                    
                    bulanSelect.appendChild(option);
                });
            }

            // Jalankan saat load awal
            updateBulanOptions();

            // Jalankan saat tanggal berubah
            tanggalInput.addEventListener('change', function() {
                bulanSelect.setAttribute('data-changed', 'true'); // Tandai user sudah ubah tanggal
                updateBulanOptions();
            });

            // 4. Submit Handler
            $('#paymentForm').on('submit', function() {
                cleanInput.value = rupiah.value.replace(/\./g, '');
            });
        });
    </script>
</body>
</html>