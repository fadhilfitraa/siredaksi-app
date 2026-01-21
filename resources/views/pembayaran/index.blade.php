<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembayaran - Bimbel Al-Kautsar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .table th { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; vertical-align: middle; }
        .table td { vertical-align: middle; font-size: 0.95rem; }
        .badge-method { font-size: 0.8rem; padding: 6px 10px; width: 100%; display: block; }
    </style>
</head>
<body>
    
    <nav class="navbar navbar-dark bg-primary shadow-sm mb-4">
        <div class="container-fluid px-4">
            <span class="navbar-brand fw-bold mb-0 h1"><i class="fas fa-file-invoice-dollar me-2"></i> DATA KEUANGAN</span>
            <div>
                <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-outline-light me-2">
                    <i class="fas fa-users"></i> Data Siswa
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-light text-primary fw-bold">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-4">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-white fw-bold py-3">
                <i class="fas fa-filter text-secondary"></i> Filter & Pencarian
            </div>
            <div class="card-body bg-white">
                <form action="{{ route('pembayaran.index') }}" method="GET">
                    <div class="row g-2 align-items-end">
                        
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Urutkan Berdasarkan</label>
                            <select name="sort" class="form-select bg-light" onchange="this.form.submit()">
                                <option value="input_terbaru" {{ !request('sort') || request('sort') == 'input_terbaru' ? 'selected' : '' }}>Waktu Input (Terbaru)</option>
                                <option value="tanggal_terbaru" {{ request('sort') == 'tanggal_terbaru' ? 'selected' : '' }}>Tanggal Bayar (Baru-Lama)</option>
                                <option value="tanggal_terlama" {{ request('sort') == 'tanggal_terlama' ? 'selected' : '' }}>Tanggal Bayar (Lama-Baru)</option>
                                <option value="kelas_az" {{ request('sort') == 'kelas_az' ? 'selected' : '' }}>Kelas (A-Z)</option>
                                <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama Siswa (A-Z)</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-muted">Filter Bulan</label>
                            <select name="bulan" class="form-select">
                                <option value="">Semua Bulan</option>
                                @foreach(range(1, 12) as $bulan)
                                    <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-bold small text-muted">Filter Tahun</label>
                            <select name="tahun" class="form-select">
                                <option value="">Semua</option>
                                @for($i = date('Y'); $i >= date('Y')-3; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                
                                <a href="{{ route('pembayaran.export', request()->query()) }}" class="btn btn-success flex-fill text-white">
                                    <i class="fas fa-file-excel"></i> Excel
                                </a>

                                <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary" title="Reset">
                                    <i class="fas fa-sync"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="card-footer bg-success text-white text-center py-2">
                <small>Total Pemasukan:</small>
                <h5 class="mb-0 fw-bold">Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</h5>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-0">
                
                <div class="p-3">
                    <a href="{{ route('pembayaran.create') }}" class="btn btn-primary shadow-sm">
                        <i class="fas fa-plus-circle"></i> Input Pembayaran Baru
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle mb-0">
                        <thead class="table-dark text-nowrap">
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th width="20%">Siswa & Sekolah</th>
                                <th width="15%">Periode Tagihan</th>
                                <th width="12%">Tgl Bayar</th>
                                <th width="10%" class="text-center">Metode</th> 
                                <th width="15%">Catatan</th> <th width="12%">Nominal</th>
                                <th width="15%" class="text-center">Aksi</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayarans as $index => $p)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                
                                <td>
                                    <div class="fw-bold text-primary">{{ $p->siswa->nama ?? 'Siswa Dihapus' }}</div>
                                    <div class="small text-muted">
                                        {{ $p->siswa->kelas ?? '-' }} 
                                        @if(isset($p->siswa->asal_sekolah))
                                            | {{ $p->siswa->asal_sekolah }}
                                        @endif
                                    </div>
                                </td>
                                
                                <td>
                                    <span class="fw-bold text-dark">
                                        {{ $p->bulan_bayar ?? '-' }}
                                    </span>
                                </td>

                                <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d M Y') }}</td>

                                <td class="text-center">
                                    @php
                                        $metode = $p->metode_pembayaran ?? 'Tunai';
                                        $badgeClass = ($metode == 'Transfer' || $metode == 'QRIS') ? 'bg-info text-dark' : 'bg-success';
                                        $icon = ($metode == 'Transfer') ? 'fa-university' : (($metode == 'QRIS') ? 'fa-qrcode' : 'fa-money-bill-wave');
                                    @endphp
                                    <span class="badge {{ $badgeClass }} badge-method border">
                                        <i class="fas {{ $icon }} me-1"></i> {{ $metode }}
                                    </span>
                                </td>

                                <td>
                                    @if(!empty($p->keterangan))
                                        <div class="text-muted fst-italic" style="font-size: 0.9rem; line-height: 1.3;">
                                            {{ $p->keterangan }}
                                        </div>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="fw-bold text-success" style="font-size: 1.05rem;">
                                    Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                                </td>

                                <td class="text-center text-nowrap">
                                    <div class="btn-group shadow-sm" role="group">
                                        <a href="{{ route('pembayaran.cetak', $p->id) }}" target="_blank" class="btn btn-outline-dark btn-sm px-3" title="Cetak Kwitansi">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a href="{{ route('pembayaran.edit', $p->id) }}" class="btn btn-outline-warning btn-sm px-3" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pembayaran ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-0 rounded-end px-3" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted bg-white">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486777.png" width="80" class="mb-3 opacity-50">
                                    <p class="mb-0">Belum ada data pembayaran yang ditemukan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($pembayarans instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer bg-white">
                {{ $pembayarans->withQueryString()->links() }}
            </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>