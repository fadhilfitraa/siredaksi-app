<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Pembayaran - Bimbel Al-Kautsar</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        
        /* Navbar disamakan dengan Dashboard */
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .navbar-brand { letter-spacing: 1px; }
        
        /* Card Styling */
        .card-form {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .card-header-pro {
            background-color: #ffffff;
            padding: 20px 30px; /* Padding disesuaikan */
            border-bottom: 1px solid #edf2f9;
            display: flex; align-items: center; justify-content: space-between;
        }

        .form-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #6c757d;
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }
        .form-control:focus, .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        .input-rupiah {
            font-size: 1.8rem; /* Lebih besar sedikit */
            font-weight: bold;
            color: #198754;
            letter-spacing: 1px;
        }
        
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 8px;
            padding: 8px 15px;
            min-height: 48px;
        }
        
        /* Custom Buttons */
        .btn-back { border-radius: 50px; padding: 8px 25px; font-weight: 600; }
        .btn-cancel { border-radius: 50px; padding: 10px 30px; font-weight: 600; }
        .btn-save { border-radius: 50px; padding: 10px 50px; font-weight: 600; font-size: 1.1rem; }
    </style>
</head>
<body>

    @php
        $previousUrl = url()->previous();
        // Cek apakah URL sebelumnya mengandung kata 'pembayaran' (indikasi dari menu list)
        // Jika ya, kembali ke index pembayaran. Jika tidak (misal error validasi atau dari dashboard), ke dashboard.
        $backRoute = (str_contains($previousUrl, route('pembayaran.index'))) ? route('pembayaran.index') : route('dashboard');
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-graduation-cap me-2"></i>SIREDAKSI BIMBEL AL KAUTSAR
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item text-white opacity-75 small me-3 d-none d-lg-block">
                        <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name ?? 'Admin' }}
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pb-5" style="max-width: 1200px;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">
                    <i class="fas fa-cash-register text-primary me-2"></i>Input Pembayaran
                </h2>
                <p class="text-muted mb-0 ms-1">Catat transaksi pembayaran siswa baru.</p>
            </div>
            
            <a href="{{ $backRoute }}" class="btn btn-outline-secondary btn-back shadow-sm bg-white text-dark border-0">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <form id="paymentForm" action="{{ route('pembayaran.store') }}" method="POST">
            @csrf
            
            <div class="card card-form shadow-sm">
                
                <div class="card-header-pro">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-file-invoice-dollar fa-lg"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">Formulir Transaksi</h5>
                            <span class="text-muted small">Silakan lengkapi data di bawah ini.</span>
                        </div>
                    </div>
                    <div class="d-none d-md-block">
                        <div class="d-flex align-items-center text-muted border rounded-pill px-3 py-1 bg-light">
                            <i class="far fa-calendar-alt me-2"></i>
                            <span>Hari ini: <strong>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</strong></span>
                        </div>
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
                                <label class="form-label">Cari Nama Siswa <span class="text-danger">*</span></label>
                                <select name="siswa_id" class="form-select select-siswa" required>
                                    <option value="" disabled selected> Ketik Nama Siswa </option>
                                    @foreach($siswas as $s)
                                        <option value="{{ $s->id }}">{{ $s->nama }} - {{ $s->kelas }} ({{ $s->asal_sekolah }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Tanggal Bayar <span class="text-danger">*</span></label>
                                    <input type="date" id="tanggal_bayar" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label class="form-label">Untuk Bulan <span class="text-danger">*</span></label>
                                    <select id="bulan_bayar" name="bulan_bayar" class="form-select bg-light" required>
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
                            
                            <div class="mb-4 bg-light p-4 rounded-3 border dashed-border">
                                <label class="form-label text-success mb-2">NOMINAL YANG DIBAYAR (Rp) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 fw-bold text-success fs-3">Rp</span>
                                    <input type="text" id="rupiah" class="form-control input-rupiah border-start-0 ps-1" placeholder="0" required autofocus>
                                    
                                    <input type="hidden" name="jumlah_bayar" id="jumlah_bayar_clean">
                                </div>
                                <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle me-1"></i> Masukkan angka saja, titik pemisah otomatis muncul.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Catatan (Opsional)</label>
                                <textarea name="keterangan" class="form-control" rows="4" placeholder="Contoh: Lunas SPP, Cicilan pertama, Uang gedung, dll..."></textarea>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white p-4 text-end border-top">
                    <a href="{{ $backRoute }}" class="btn btn-outline-secondary btn-cancel me-2">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-save shadow">
                        <i class="fas fa-check-circle me-2"></i> SIMPAN DATA
                    </button>
                </div>

            </div>
        </form>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            
            // --- 1. SELECT2 (Pencarian Siswa) ---
            $('.select-siswa').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: ' Ketik Nama Siswa ',
                allowClear: true
            });

            // --- 2. FORMAT RUPIAH ---
            var rupiah = document.getElementById('rupiah');
            var cleanInput = document.getElementById('jumlah_bayar_clean');

            rupiah.addEventListener('keyup', function(e) {
                rupiah.value = formatRupiah(this.value);
                cleanInput.value = rupiah.value.replace(/\./g, '');
            });

            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split   = number_string.split(','),
                    sisa    = split[0].length % 3,
                    rupiah  = split[0].substr(0, sisa),
                    ribuan  = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            // --- 3. LOGIKA BULAN DINAMIS (Berdasarkan Tahun Tanggal Bayar) ---
            const tanggalInput = document.getElementById('tanggal_bayar');
            const bulanSelect = document.getElementById('bulan_bayar');
            const namaBulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            function updateBulanOptions() {
                // Ambil tahun dari input tanggal (format YYYY-MM-DD)
                const tanggalValue = new Date(tanggalInput.value);
                const tahunPilih = tanggalValue.getFullYear();
                const bulanSekarangIndex = new Date().getMonth(); // 0-11
                
                // Kosongkan opsi lama
                bulanSelect.innerHTML = '';

                // Generate opsi bulan Januari s/d Desember dengan tahun yang dipilih
                namaBulan.forEach((bulan, index) => {
                    let option = document.createElement('option');
                    let valueTeks = `${bulan} ${tahunPilih}`;
                    
                    option.value = valueTeks;
                    option.text = valueTeks;

                    // Auto-select bulan sesuai tanggal hari ini JIKA tahunnya sama
                    // Jika tidak, default ke Januari
                    if (index === bulanSekarangIndex && tahunPilih === new Date().getFullYear()) {
                        option.selected = true;
                    }
                    
                    bulanSelect.appendChild(option);
                });
            }

            // Jalankan saat pertama kali load
            updateBulanOptions();

            // Jalankan setiap kali tanggal berubah
            tanggalInput.addEventListener('change', updateBulanOptions);

            // --- 4. SUBMIT HANDLER ---
            $('#paymentForm').on('submit', function() {
                cleanInput.value = rupiah.value.replace(/\./g, '');
            });

        });
    </script>

</body>
</html>