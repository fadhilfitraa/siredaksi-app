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
        .navbar { background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); } /* Warna Oranye untuk Edit */
        
        .card-form {
            border: none; border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05); overflow: hidden;
        }
        
        .card-header-pro {
            background-color: #ffffff; padding: 25px 30px;
            border-bottom: 1px solid #edf2f9; display: flex; align-items: center; justify-content: space-between;
        }

        .form-label { font-size: 0.8rem; text-transform: uppercase; font-weight: 700; color: #6c757d; margin-bottom: 8px; }
        .form-control, .form-select { padding: 12px 15px; border-radius: 8px; border: 1px solid #dee2e6; }
        .input-rupiah { font-size: 1.6rem; font-weight: bold; color: #fd7e14; letter-spacing: 1px; } /* Oranye */
        
        .select2-container--bootstrap-5 .select2-selection { border-radius: 8px; padding: 8px 15px; min-height: 48px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark shadow-sm mb-5">
        <div class="container-fluid px-5">
            <a class="navbar-brand fw-bold text-dark" href="{{ route('dashboard') }}">
                <i class="fas fa-arrow-left me-2"></i> Batal Edit
            </a>
            <span class="text-dark fw-bold opacity-75"><i class="fas fa-edit me-2"></i> EDIT DATA TRANSAKSI</span>
        </div>
    </nav>

    <div class="container-fluid px-4 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-xl-10">
                
                <form id="paymentForm" action="{{ route('pembayaran.update', $pembayaran->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="card card-form">
                        
                        <div class="card-header-pro border-warning border-bottom border-3">
                            <div>
                                <h4 class="fw-bold text-dark mb-1">Perbarui Data Pembayaran</h4>
                                <p class="text-muted small mb-0">Edit data jika terjadi kesalahan input.</p>
                            </div>
                            <div class="d-none d-md-block">
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                    <i class="fas fa-info-circle me-1"></i> Mode Edit
                                </span>
                            </div>
                        </div>

                        <div class="card-body p-5">
                            
                            @if ($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-5">
                                
                                <div class="col-md-6">
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
                                            <input type="date" name="tanggal_bayar" class="form-control" value="{{ $pembayaran->tanggal_bayar }}" required>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label">Untuk Bulan</label>
                                            <select name="bulan_bayar" class="form-select" required>
                                                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan)
                                                    @php $val = $bulan . ' ' . date('Y'); @endphp
                                                    <option value="{{ $val }}" {{ $pembayaran->bulan_bayar == $val ? 'selected' : '' }}>
                                                        {{ $val }}
                                                    </option>
                                                @endforeach
                                                @if(!str_contains($pembayaran->bulan_bayar, date('Y')))
                                                    <option value="{{ $pembayaran->bulan_bayar }}" selected>{{ $pembayaran->bulan_bayar }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Metode Pembayaran</label>
                                        <div class="d-flex gap-3">
                                            <div class="form-check border rounded p-3 flex-fill">
                                                <input class="form-check-input" type="radio" name="metode_pembayaran" value="Tunai" id="tunai" {{ $pembayaran->metode_pembayaran == 'Tunai' ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="tunai">💵 Tunai</label>
                                            </div>
                                            <div class="form-check border rounded p-3 flex-fill">
                                                <input class="form-check-input" type="radio" name="metode_pembayaran" value="Transfer" id="transfer" {{ $pembayaran->metode_pembayaran == 'Transfer' ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="transfer">🏦 Transfer</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 border-start ps-md-5">
                                    
                                    <div class="mb-5">
                                        <label class="form-label text-warning">NOMINAL (Rp)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-white border-end-0 fw-bold text-warning fs-4">Rp</span>
                                            <input type="text" id="rupiah" class="form-control input-rupiah border-start-0 ps-1" 
                                                   value="{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}" required>
                                            
                                            <input type="hidden" name="jumlah_bayar" id="jumlah_bayar_clean" value="{{ $pembayaran->jumlah_bayar }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Catatan</label>
                                        <textarea name="keterangan" class="form-control bg-light" rows="4">{{ $pembayaran->keterangan }}</textarea>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card-footer bg-light p-4 text-end border-top-0">
                            <a href="{{ route('pembayaran.index') }}" class="btn btn-link text-decoration-none text-muted me-3">Batal</a>
                            <button type="submit" class="btn btn-warning btn-lg px-5 fw-bold shadow-sm">
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
            // Select2
            $('.select-siswa').select2({ theme: 'bootstrap-5', width: '100%' });

            // Format Rupiah Logic
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

            $('#paymentForm').on('submit', function() {
                cleanInput.value = rupiah.value.replace(/\./g, '');
            });
        });
    </script>
</body>
</html>