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
        
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        
        /* Kartu Form Lebar */
        .card-form {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            overflow: hidden; /* Penting agar sudut bulat tidak bocor */
        }
        
        .card-header-pro {
            background-color: #ffffff;
            padding: 25px 30px;
            border-bottom: 1px solid #edf2f9;
            display: flex; align-items: center; justify-content: space-between;
        }

        .form-label {
            font-size: 0.8rem;
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

        /* Styling Khusus Input Rupiah */
        .input-rupiah {
            font-size: 1.6rem;
            font-weight: bold;
            color: #198754;
            letter-spacing: 1px;
        }
        
        /* Perbaikan Tampilan Select2 agar sesuai Bootstrap 5 */
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 8px;
            padding: 8px 15px;
            min-height: 48px; /* Biar tinggi sama dengan input lain */
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark shadow-sm mb-5">
        <div class="container-fluid px-5"> <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
            <span class="text-white opacity-90"><i class="fas fa-cash-register me-2"></i> TRANSAKSI PEMBAYARAN</span>
        </div>
    </nav>

    <div class="container-fluid px-4 pb-5"> <div class="row justify-content-center">
            
            <div class="col-lg-11 col-xl-10">
                
                <form id="paymentForm" action="{{ route('pembayaran.store') }}" method="POST">
                    @csrf
                    
                    <div class="card card-form">
                        
                        <div class="card-header-pro">
                            <div>
                                <h4 class="fw-bold text-dark mb-1">INPUT PEMBAYARAN</h4>
                                <p class="text-muted small mb-0">Input pembayaran Bimbingan Belajar siswa.</p>
                            </div>
                            <div class="d-none d-md-block">
                                <span class="badge bg-light text-primary border px-3 py-2 rounded-pill">
                                    <i class="fas fa-calendar-day me-1"></i> {{ date('d F Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-5"> @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-5"> <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="form-label">Cari Nama Siswa</label>
                                        <select name="siswa_id" class="form-select select-siswa" required>
                                            <option value="" disabled selected> Ketik Nama Siswa </option>
                                            @foreach($siswas as $s)
                                                <option value="{{ $s->id }}">{{ $s->nama }} - {{ $s->kelas }} ({{ $s->asal_sekolah }})</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Tanggal Bayar</label>
                                            <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Untuk Bulan</label>
                                            <select name="bulan_bayar" class="form-select" required>
                                                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan)
                                                    <option value="{{ $bulan }} {{ date('Y') }}" {{ $bulan == date('F') ? 'selected' : '' }}>
                                                        {{ $bulan }} {{ date('Y') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check border rounded p-3 flex-fill">
                                                <input class="form-check-input" type="radio" name="metode_pembayaran" value="Tunai" id="tunai" checked>
                                                <label class="form-check-label fw-bold" for="tunai">Tunai</label>
                                            </div>
                                            <div class="form-check border rounded p-3 flex-fill">
                                                <input class="form-check-input" type="radio" name="metode_pembayaran" value="Transfer" id="transfer">
                                                <label class="form-check-label fw-bold" for="transfer">Transfer</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 border-start ps-md-5">
                                    
                                    <div class="mb-5">
                                        <label class="form-label text-success">NOMINAL (Rp)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 fw-bold text-success fs-4">Rp</span>
                                            <input type="text" id="rupiah" class="form-control input-rupiah border-start-0 ps-1" placeholder="0" required>
                                            
                                            <input type="hidden" name="jumlah_bayar" id="jumlah_bayar_clean">
                                        </div>
                                        <small class="text-muted">Ketik angka saja, titik otomatis muncul.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Catatan (Opsional)</label>
                                        <textarea name="keterangan" class="form-control bg-light" rows="4" placeholder="Keterangan tambahan..."></textarea>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="card-footer bg-light p-4 text-end border-top-0">
                            <a href="{{ route('dashboard') }}" class="btn btn-link text-decoration-none text-muted me-3">Batal</a>
                            <button type="submit" class="btn btn-primary btn-lg px-5 fw-bold shadow-sm">
                                <i class="fas fa-check-circle me-2"></i> SIMPAN
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
            
            // --- A. AKTIFKAN PENCARIAN SISWA (SELECT2) ---
            $('.select-siswa').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: ' Ketik Nama Siswa ',
                allowClear: true
            });

            // --- B. FORMAT RUPIAH OTOMATIS ---
            var rupiah = document.getElementById('rupiah');
            var cleanInput = document.getElementById('jumlah_bayar_clean');

            rupiah.addEventListener('keyup', function(e) {
                // 1. Format tampilan (kasih titik)
                rupiah.value = formatRupiah(this.value);
                
                // 2. Simpan angka murni ke input hidden (hapus semua titik)
                cleanInput.value = rupiah.value.replace(/\./g, '');
            });

            // Fungsi Format Rupiah
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

            // --- C. MENCEGAH SUBMIT JIKA KOSONG ---
            $('#paymentForm').on('submit', function() {
                // Pastikan input hidden terisi angka murni sebelum submit
                cleanInput.value = rupiah.value.replace(/\./g, '');
            });

        });
    </script>

</body>
</html>