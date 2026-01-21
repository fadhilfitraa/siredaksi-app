<!DOCTYPE html>
<html>
<head>
    <title>Kartu Pembayaran - {{ $siswa->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Agar saat di-Print tampilannya rapi */
        @media print {
            .no-print { display: none !important; }
            .card { border: none !important; shadow: none !important; }
            .bg-primary { color: black !important; background: white !important; }
        }
    </style>
</head>
<body class="bg-light p-5">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4 no-print">
            <h3>📜 Kartu Pembayaran SPP</h3>
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Daftar Siswa
            </a>
        </div>

        <div class="card shadow">
            <div class="card-header bg-primary text-white p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0">{{ $siswa->nama }}</h2>
                        <p class="mb-0 fs-5">Kelas: {{ $siswa->kelas }}</p>
                    </div>
                    <div class="text-end">
                        <button onclick="window.print()" class="btn btn-light text-primary fw-bold no-print">
                            <i class="fas fa-print"></i> Cetak Rekap
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="card-body p-4">
                
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert alert-info border-0 shadow-sm d-flex justify-content-between align-items-center">
                            <strong>Total Uang Masuk:</strong>
                            <span class="fs-4 fw-bold">Rp {{ number_format($siswa->pembayarans->sum('jumlah_bayar')) }}</span>
                        </div>
                    </div>
                </div>

                <h5 class="mb-3 text-muted">Rincian Riwayat Transaksi</h5>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th width="5%">No</th>
                            <th>Tanggal Bayar</th>
                            <th>Nominal</th>
                            <th width="15%" class="no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa->pembayarans as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d F Y') }}</td>
                            <td class="fw-bold text-success">Rp {{ number_format($p->jumlah_bayar) }}</td>
                            <td class="no-print text-center">
                                <a href="{{ route('pembayaran.cetak', $p->id) }}" target="_blank" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-file-invoice"></i> Kwitansi
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i>Belum ada riwayat pembayaran untuk siswa ini.</i>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="2" class="text-end fw-bold">Grand Total</td>
                            <td colspan="2" class="fw-bold text-primary">Rp {{ number_format($siswa->pembayarans->sum('jumlah_bayar')) }}</td>
                        </tr>
                    </tfoot>
                </table>

            </div>
            <div class="card-footer text-muted text-center small">
                Dicetak pada: {{ date('d F Y H:i') }} | Sistem Bimbel Al-Kautsar
            </div>
        </div>

    </div>
</body>
</html>