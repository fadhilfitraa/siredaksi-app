<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa - {{ $siswa->nama }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* =========================================
           STYLE TAMPILAN WEB (DASHBOARD MODERN)
           ========================================= */
        body { background-color: #f3f4f6; font-family: 'Poppins', sans-serif; }
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); background: white; overflow: hidden; }
        .avatar-profile { width: 80px; height: 80px; font-size: 2rem; font-weight: bold; display: flex; align-items: center; justify-content: center; border-radius: 50%; margin-bottom: 15px; }
        .table-web thead th { background-color: #f8f9fa; color: #6c757d; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; border-bottom: 2px solid #dee2e6; padding: 12px; }
        .table-web tbody td { padding: 12px; vertical-align: middle; }

        /* Sembunyikan Layout Struk saat di layar biasa */
        #print-area { display: none; }

        /* =========================================
           STYLE TAMPILAN CETAK (STRUK KLASIK)
           ========================================= */
        @media print {
            /* 1. Sembunyikan UI Web */
            .web-area, .navbar, .btn, .no-print { display: none !important; }
            
            /* 2. Tampilkan Area Struk */
            #print-area { display: block !important; }
            
            /* 3. Reset Body ke Kertas Putih */
            body { background: #fff !important; padding: 0 !important; margin: 0 !important; font-family: 'Courier New', Courier, monospace !important; }
            
            /* 4. Styling Kotak Struk */
            .struk-box {
                width: 100%; max-width: 210mm; margin: 0 auto;
                padding: 15px 25px; 
                border: 1px solid #333; /* Border kotak luar */
            }

            /* Header Struk */
            .header { display: flex; align-items: center; border-bottom: 2px dashed #333; padding-bottom: 15px; margin-bottom: 15px; }
            .company-info h1 { margin: 0; font-size: 20px; color: #000; font-weight: 800; text-transform: uppercase; font-family: Helvetica, sans-serif; }
            .company-info p { margin: 2px 0; font-size: 11px; color: #000; font-family: Helvetica, sans-serif; }
            
            .meta-info { margin-left: auto; text-align: right; font-size: 11px; color: #000; font-family: 'Courier New', Courier, monospace; }
            .client-info { margin-bottom: 15px; font-size: 12px; color: #000; font-family: 'Courier New', Courier, monospace; }
            
            /* Tabel Struk */
            .struk-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; font-size: 12px; font-family: 'Courier New', Courier, monospace; }
            .struk-table th { text-align: left; border-bottom: 1px dashed #000; padding: 5px 0; text-transform: uppercase; }
            .struk-table td { padding: 5px 0; vertical-align: top; }
            .struk-table .col-total { text-align: right; }
            
            /* Footer Struk */
            .total-section { border-top: 2px dashed #333; padding-top: 15px; display: flex; justify-content: space-between; align-items: flex-end; }
            .grand-total { text-align: right; }
            .grand-total .amount { font-size: 18px; font-weight: 800; border: 2px solid #000; padding: 5px 10px; display: inline-block; font-family: Helvetica, sans-serif; }
            
            .footer { margin-top: 40px; text-align: right; font-size: 11px; font-family: Helvetica, sans-serif; }
            .signature { margin-top: 50px; text-decoration: underline; font-weight: bold; }
        }
    </style>
</head>
<body>

    <div class="web-area">
        <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">
                    <i class="fas fa-graduation-cap me-2"></i>SIREDAKSI BIMBEL AL KAUTSAR
                </a>
            </div>
        </nav>

        <div class="container mt-4 mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Kartu Siswa & Riwayat</h4>
                    <p class="text-muted small mb-0">Detail profil dan data pembayaran.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('siswa.index') }}" class="btn btn-secondary shadow-sm fw-bold px-4 rounded-pill">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                    <button onclick="window.print()" class="btn btn-dark shadow-sm fw-bold px-4 rounded-pill">
                        <i class="fas fa-print me-2"></i>Cetak Struk Rekap
                    </button>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card card-custom h-100">
                        <div class="card-body text-center p-4">
                            @php
                                $bgColors = ['TK'=>'bg-success','SD'=>'bg-danger','SMP'=>'bg-primary','SMA'=>'bg-secondary'];
                                $bgClass = $bgColors[$siswa->tingkatan] ?? 'bg-dark';
                            @endphp
                            <div class="d-flex justify-content-center">
                                <div class="avatar-profile {{ $bgClass }} bg-opacity-10 text-opacity-75 {{ str_replace('bg-', 'text-', $bgClass) }}">
                                    {{ substr($siswa->nama, 0, 1) }}
                                </div>
                            </div>
                            <h5 class="fw-bold mb-1">{{ $siswa->nama }}</h5>
                            <div class="badge bg-light text-dark border mb-3">{{ $siswa->kelas }}</div>
                            
                            <div class="text-start mt-3 border-top pt-3">
                                <div class="d-flex justify-content-between py-1"><small>Jenjang:</small> <strong>{{ $siswa->tingkatan }}</strong></div>
                                <div class="d-flex justify-content-between py-1"><small>Sekolah:</small> <strong>{{ $siswa->asal_sekolah }}</strong></div>
                                <div class="d-flex justify-content-between py-1"><small>No HP:</small> <strong>{{ $siswa->no_hp ?? '-' }}</strong></div>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                <a href="{{ route('pembayaran.create', ['siswa_id' => $siswa->id]) }}" class="btn btn-primary fw-bold shadow-sm">
                                    <i class="fas fa-plus-circle me-2"></i> Input Pembayaran
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="card card-custom mb-3">
                        <div class="card-body p-4 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted small fw-bold mb-1">TOTAL UANG MASUK</h6>
                                <h2 class="text-success fw-bold mb-0">Rp {{ number_format($siswa->pembayarans->sum('jumlah_bayar'), 0, ',', '.') }}</h2>
                            </div>
                            <i class="fas fa-wallet fs-1 text-success opacity-25"></i>
                        </div>
                    </div>

                    <div class="card card-custom">
                        <div class="card-header bg-white p-3 border-bottom">
                            <h6 class="mb-0 fw-bold"><i class="fas fa-history me-2 text-primary"></i>Riwayat Transaksi</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-web table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
                                        <th class="text-end">Nominal</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($siswa->pembayarans as $p)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</td>
                                        <td>SPP Bulan {{ $p->bulan_bayar }}</td>
                                        <td class="text-end fw-bold text-success">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('pembayaran.cetak', $p->id) }}" target="_blank" class="btn btn-sm btn-light border">
                                                <i class="fas fa-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4" class="text-center py-4 text-muted">Belum ada data.</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="print-area">
        <div class="struk-box">
            
            <div class="header">
                <div class="company-info">
                    <h1>BIMBEL AL-KAUTSAR</h1>
                    <p>Jl. Soekarno Hatta (Depan Islamic Center)</p>
                    <p>Bandar Lampung | Telp: 0721-788410</p>
                </div>
                <div class="meta-info">
                    <span><strong>REKAPITULASI PEMBAYARAN</strong></span>
                    <span>Tgl Cetak: {{ date('d/m/Y') }}</span>
                    <span>Admin: {{ strtoupper(Auth::user()->name ?? 'ADMIN') }}</span>
                </div>
            </div>

            <div class="client-info">
                DATA SISWA: <br>
                <span style="font-weight:bold; font-size:14px;">{{ strtoupper($siswa->nama) }}</span> <br>
                Kelas: {{ $siswa->kelas }} | Asal: {{ $siswa->asal_sekolah }} | Jenjang: {{ $siswa->tingkatan }}
            </div>

            <table class="struk-table">
                <thead>
                    <tr>
                        <th>TANGGAL</th>
                        <th>KETERANGAN / PERIODE</th>
                        <th class="col-total">JUMLAH (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($siswa->pembayarans as $p)
                    @php $total += $p->jumlah_bayar; @endphp
                    <tr>
                        <td>{{ date('d/m/y', strtotime($p->tanggal_bayar)) }}</td>
                        <td>
                            Pembayaran SPP/Bimbel <br>
                            <small>Periode: {{ $p->bulan_bayar }}</small>
                        </td>
                        <td class="col-total">
                            {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                    
                    @if($siswa->pembayarans->isEmpty())
                    <tr>
                        <td colspan="3" style="text-align:center; padding: 20px;">-- Belum ada riwayat transaksi --</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <div class="total-section">
                <div style="flex: 1; font-size: 10px; font-style: italic; margin-right: 20px;">
                    * Struk ini adalah bukti rekapitulasi pembayaran yang sah.<br>
                    * Harap disimpan dengan baik.
                </div>
                <div class="grand-total">
                    <span style="display:block; font-size:11px; font-weight:bold; margin-bottom:5px;">TOTAL AKUMULASI</span>
                    <span class="amount">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="footer">
                <p>Bandar Lampung, {{ date('d F Y') }}</p>
                <br><br><br>
                <div class="signature">({{ strtoupper(Auth::user()->name ?? 'ADMINISTRATOR') }})</div>
            </div>

        </div>
    </div>

    <script>
        function printStruk() {
            window.print();
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>