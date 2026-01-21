<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light p-5">
    
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>💰 Data Pembayaran Bimbel</h1>
            <div>
                <a href="{{ route('siswa.index') }}" class="btn btn-info text-white me-2">
                    <i class="fas fa-users"></i> Kelola Data Siswa
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-dark">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow mb-4 border-0">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-filter"></i> Filter & Pengurutan Data
            </div>
            <div class="card-body bg-white rounded">
                <form action="{{ route('pembayaran.index') }}" method="GET">
                    <div class="row g-2 align-items-end">
                        
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Urutkan Data</label>
                            <select name="sort" class="form-select bg-light border-primary" onchange="this.form.submit()">
                                <option value="tanggal_terbaru" {{ request('sort') == 'tanggal_terbaru' ? 'selected' : '' }}>Tanggal Terbaru</option>
                                <option value="tanggal_terlama" {{ request('sort') == 'tanggal_terlama' ? 'selected' : '' }}>Tanggal Terlama</option>
                                <option value="kelas_az" {{ request('sort') == 'kelas_az' ? 'selected' : '' }}>Kelas (A-Z)</option>
                                <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama Siswa (A-Z)</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small">Filter Bulan</label>
                            <select name="bulan" class="form-select">
                                <option value=""> Semua Bulan </option>
                                @foreach(range(1, 12) as $bulan)
                                    <option value="{{ $bulan }}" {{ request('bulan') == $bulan ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label fw-bold small">Filter Tahun</label>
                            <select name="tahun" class="form-select">
                                <option value=""> Semua </option>
                                @for($i = date('Y'); $i >= date('Y')-5; $i--)
                                    <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Tampilkan
                                </button>
                                
                                <a href="{{ route('pembayaran.export', request()->query()) }}" class="btn btn-success w-100 text-white" title="Download Laporan Excel">
                                    <i class="fas fa-file-excel"></i> Excel
                                </a>

                                <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                                    <i class="fas fa-sync"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            
            <div class="card-footer bg-success text-white text-center">
                <h6 class="mb-0">Total Pemasukan (Sesuai Tampilan): <strong>Rp {{ number_format($total_pemasukan, 0, ',', '.') }}</strong></h6>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <a href="{{ route('pembayaran.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Tambah Pembayaran Baru
                </a>

                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Asal Sekolah</th>
                            <th>Kelas</th>
                            <th>Tanggal Bayar</th>
                            <th>Jumlah</th>
                            <th width="15%">Aksi</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pembayarans as $index => $p)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $p->siswa->nama ?? 'Siswa Dihapus' }}</td>
                            <td>{{ $p->siswa->asal_sekolah ?? '-' }}</td>
                            
                            <td>
                                @php
                                    $warna = 'bg-secondary'; // Default SMA/Lainnya
                                    $tingkatan = $p->siswa->tingkatan ?? ''; // Ambil tingkatan (cegah error jika siswa dihapus)

                                    if ($tingkatan == 'TK') $warna = 'bg-success';
                                    elseif ($tingkatan == 'SD') $warna = 'bg-danger';
                                    elseif ($tingkatan == 'SMP') $warna = 'bg-primary';
                                @endphp
                                <span class="badge {{ $warna }}">{{ $p->siswa->kelas ?? '-' }}</span>
                            </td>

                            <td>{{ \Carbon\Carbon::parse($p->tanggal_bayar)->translatedFormat('d F Y') }}</td>
                            <td class="text-success fw-bold">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('pembayaran.cetak', $p->id) }}" target="_blank" class="btn btn-success btn-sm me-1" title="Cetak Kwitansi">
                                    <i class="fas fa-print"></i>
                                </a>
                                <a href="{{ route('pembayaran.edit', $p->id) }}" class="btn btn-warning btn-sm me-1" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('pembayaran.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin mau hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="fas fa-box-open fa-2x mb-2"></i><br>
                                Data tidak ditemukan pada filter ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>