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
        
        /* Navbar Styling */
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .navbar-brand { letter-spacing: 1px; font-weight: 700; }
        
        /* Nav Button */
        .nav-btn { border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: white; transition: all 0.3s; backdrop-filter: blur(5px); }
        .nav-btn:hover { background: white; color: #0d6efd; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.1); }

        /* Card & Table */
        .card { border-radius: 12px; border: none; }
        .table th { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: #6c757d; vertical-align: middle; background-color: #f8f9fa; border-bottom: 2px solid #e9ecef; }
        .table td { vertical-align: middle; font-size: 0.95rem; }
        .table-hover tbody tr:hover { background-color: #f1f4f9; }
        
        /* Inputs */
        .form-control, .form-select { border-radius: 8px; padding: 10px 12px; border: 1px solid #dee2e6; }
        .form-control:focus, .form-select:focus { border-color: #86b7fe; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15); }

        /* Tombol Aksi Tabel (Bulat) */
        .btn-icon { width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; transition: all 0.2s; margin: 0 2px; border: 1px solid #dee2e6; background-color: white; }
        .btn-icon:hover { transform: scale(1.1); }
        .btn-print { color: #212529; } .btn-print:hover { background-color: #212529; color: white; border-color: #212529; }
        .btn-edit { color: #ffc107; } .btn-edit:hover { background-color: #ffc107; color: black; border-color: #ffc107; }
        .btn-delete { color: #dc3545; } .btn-delete:hover { background-color: #dc3545; color: white; border-color: #dc3545; }
        
        /* Tombol Filter (Excel/Reset) */
        .btn-filter-icon {
            width: 42px; /* Lebar tombol kotak */
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px; /* Sudut tumpul */
            transition: 0.3s;
        }
        .btn-filter-icon:hover { transform: translateY(-2px); }

    </style>
</head>
<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand mb-0 h1" href="{{ route('dashboard') }}">
                <i class="fas fa-file-invoice-dollar me-2"></i> DATA KEUANGAN
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="btn btn-sm nav-btn rounded-pill px-4 py-2"><i class="fas fa-home me-2"></i> Dashboard</a></li>
                    <li class="nav-item"><a href="{{ route('siswa.index') }}" class="btn btn-sm nav-btn rounded-pill px-4 py-2"><i class="fas fa-users me-2"></i> Data Siswa</a></li>
                    <li class="nav-item ms-lg-3 text-white opacity-75 small"><i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name ?? 'Admin' }}</li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pb-5">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

<div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-bold py-3 border-bottom-0">
                <div class="d-flex align-items-center text-primary">
                    <i class="fas fa-filter me-2"></i> Filter & Pencarian
                </div>
            </div>
            <div class="card-body bg-white pt-0">
                <form action="{{ route('pembayaran.index') }}" method="GET">
                    
                    <div class="row g-3 align-items-end">
                        
                        <div class="col-md-4">
                            <label class="form-label small text-muted fw-bold mb-1">
                                Tanggal <span class="fw-normal fst-italic text-secondary ms-1" style="font-size: 0.75rem;">(Isi kolom bagian kiri untuk tanggal spesifik)</span>
                            </label>
                            <div class="input-group">
                                <input type="date" name="start_date" class="form-control bg-light" value="{{ request('start_date') }}">
                                <span class="input-group-text bg-white border-start-0 border-end-0 text-muted"><i class="fas fa-arrow-right small"></i></span>
                                <input type="date" name="end_date" class="form-control bg-light" value="{{ request('end_date') }}">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small text-muted fw-bold mb-1">Bulan</label>
                            <select name="bulan" class="form-select bg-light">
                                <option value="">Semua</option>
                                @foreach(range(1, 12) as $bulan)
                                    <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small text-muted fw-bold mb-1">Tahun</label>
                            <select name="tahun" class="form-select bg-light">
                                <option value="">Semua</option>
                                @for($i = date('Y'); $i >= date('Y')-3; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small text-muted fw-bold mb-1">Urutkan</label>
                            <select name="sort" class="form-select bg-light">
                                <option value="input_terbaru" {{ !request('sort') || request('sort') == 'input_terbaru' ? 'selected' : '' }}>Input Terbaru</option>
                                <option value="tanggal_terbaru" {{ request('sort') == 'tanggal_terbaru' ? 'selected' : '' }}>Tanggal Bayar (Baru)</option>
                                <option value="tanggal_terlama" {{ request('sort') == 'tanggal_terlama' ? 'selected' : '' }}>Tanggal Bayar (Lama)</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label small fw-bold mb-1 d-block">&nbsp;</label>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary fw-bold text-white shadow-sm flex-grow-1" style="padding: 10px;">
                                    <i class="fas fa-search me-1"></i> Cari
                                </button>
                                
                                <a href="{{ route('pembayaran.export', request()->query()) }}" class="btn btn-success shadow-sm btn-filter-icon" title="Download Excel" style="height: 42px; width: 42px;">
                                    <i class="fas fa-file-excel fs-5"></i>
                                </a>

                                <a href="{{ route('pembayaran.index') }}" class="btn btn-dark shadow-sm btn-filter-icon" title="Reset Filter" style="height: 42px; width: 42px;">
                                    <i class="fas fa-sync-alt"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            
            <div class="card-footer bg-white border-top p-0">
                <div class="alert alert-success mb-0 rounded-0 border-0 border-start border-success border-5 bg-success bg-opacity-10 d-flex justify-content-between align-items-center px-4 py-3">
                    <div><small class="text-success fw-bold text-uppercase ls-1">Total Pemasukan (Sesuai Filter)</small></div>
                    <div><h4 class="mb-0 fw-bold text-success">Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</h4></div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-0">
                <div class="p-3 d-flex justify-content-between align-items-center border-bottom bg-light bg-opacity-50">
                    <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-list me-2 text-secondary"></i> Daftar Transaksi</h6>
                    <a href="{{ route('pembayaran.create') }}" class="btn btn-primary btn-sm shadow-sm rounded-pill px-3 py-2 fw-bold">
                        <i class="fas fa-plus-circle me-1"></i> Input Baru
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-nowrap">
                            <tr>
                                <th class="text-center ps-3" width="5%">No</th>
                                <th width="20%">Siswa</th>
                                <th width="15%">Tagihan Bulan</th>
                                <th width="15%">Tgl Bayar</th>
                                <th width="10%" class="text-center">Metode</th> 
                                <th width="20%">Catatan</th> 
                                <th width="15%" class="text-end pe-4">Nominal</th>
                                <th width="10%" class="text-center">Aksi</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pembayarans as $index => $p)
                            <tr>
                                <td class="text-center ps-3 text-muted fw-bold">{{ $loop->iteration + $pembayarans->firstItem() - 1 }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $p->siswa->nama ?? 'Siswa Dihapus' }}</div>
                                    <div class="small text-muted"><i class="fas fa-id-badge me-1 opacity-50"></i> {{ $p->siswa->kelas ?? '-' }}</div>
                                </td>
                                <td><span class="badge bg-light text-dark border fw-normal px-2 py-1">{{ $p->bulan_bayar ?? '-' }}</span></td>
                                <td>
                                    <div class="text-dark">{{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d M Y') }}</div>
                                    <small class="text-muted" style="font-size: 0.75rem;">{{ \Carbon\Carbon::parse($p->tanggal_bayar)->diffForHumans() }}</small>
                                </td>
                                <td class="text-center">
                                    @php
                                        $metode = $p->metode_pembayaran ?? 'Tunai';
                                        $badgeClass = ($metode == 'Transfer' || $metode == 'QRIS') ? 'bg-info bg-opacity-10 text-info border-info' : 'bg-success bg-opacity-10 text-success border-success';
                                    @endphp
                                    <span class="badge {{ $badgeClass }} badge-method border">{{ $metode }}</span>
                                </td>
                                <td>
                                    @if(!empty($p->keterangan)) <div class="text-muted fst-italic small">{{ $p->keterangan }}</div>
                                    @else <span class="text-muted small opacity-50">-</span> @endif
                                </td>
                                <td class="text-end pe-4"><span class="fw-bold text-success" style="font-size: 1rem;">+ {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</span></td>
                                <td class="text-center text-nowrap">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('pembayaran.cetak', $p->id) }}" target="_blank" class="btn btn-icon btn-print shadow-sm" title="Cetak"><i class="fas fa-print"></i></a>
                                        <a href="{{ route('pembayaran.edit', $p->id) }}" class="btn btn-icon btn-edit shadow-sm" title="Edit"><i class="fas fa-edit"></i></a>
                                        <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pembayaran ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-delete shadow-sm" title="Hapus"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="8" class="text-center py-5"><div class="opacity-25 mb-3"><i class="fas fa-file-invoice fa-4x"></i></div><h6 class="fw-bold text-muted">Belum ada data pembayaran</h6><p class="small text-muted">Coba ubah filter pencarian atau input data baru.</p></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($pembayarans instanceof \Illuminate\Pagination\LengthAwarePaginator)
            <div class="card-footer bg-white py-3">{{ $pembayarans->withQueryString()->links() }}</div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>