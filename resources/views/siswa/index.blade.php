<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light p-5">
    <div class="container">
        <div class="d-flex justify-content-between mb-4">
            <h1>👨‍🎓 Manajemen Data Siswa</h1>
            <div>
                <a href="{{ route('pembayaran.index') }}" class="btn btn-secondary me-2">
                    <i class="fas fa-money-bill"></i> Ke Pembayaran
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-dark">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow">
            
            <div class="card-header bg-white p-3">
                <form action="{{ route('siswa.index') }}" method="GET">
                    
                    @if(request('tingkatan'))
                        <input type="hidden" name="tingkatan" value="{{ request('tingkatan') }}">
                    @endif

                    <div class="row g-2">
                        
                        <div class="col-lg-3 col-md-12">
                            <div class="d-flex gap-1">
                                <a href="{{ route('siswa.create') }}" class="btn btn-primary w-100" title="Tambah">
                                    <i class="fas fa-plus"></i>
                                </a>
                                <a href="{{ route('siswa.rekap') }}" class="btn btn-warning w-100 text-dark" title="Rekap">
                                    <i class="fas fa-chart-pie"></i>
                                </a>
                                <a href="{{ route('siswa.export') }}" class="btn btn-success w-100 text-white" title="Excel">
                                    <i class="fas fa-file-excel"></i>
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold small">Urutkan</span>
                                <select name="sort" class="form-select" onchange="this.form.submit()">
                                    <option value="jenjang" {{ request('sort') == 'jenjang' ? 'selected' : '' }}>Jenjang (TK - SMA)</option>
                                    <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama (A - Z)</option>
                                    <option value="nama_za" {{ request('sort') == 'nama_za' ? 'selected' : '' }}>Nama (Z - A)</option>
                                    <option value="kelas_az" {{ request('sort') == 'kelas_az' ? 'selected' : '' }}>Kelas (A - Z)</option>
                                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Input Terbaru</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="cari" class="form-control" placeholder="Cari Siswa..." value="{{ request('cari') }}">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-12 text-end">
                            <div class="btn-group w-100">
                                <a href="{{ route('siswa.index', ['sort' => request('sort')]) }}" class="btn btn-outline-secondary {{ !request('tingkatan') || request('tingkatan') == 'Semua' ? 'active' : '' }}">All</a>
                                <a href="{{ route('siswa.index', ['tingkatan' => 'TK', 'sort' => request('sort')]) }}" class="btn btn-outline-success {{ request('tingkatan') == 'TK' ? 'active' : '' }}">TK</a>
                                <a href="{{ route('siswa.index', ['tingkatan' => 'SD', 'sort' => request('sort')]) }}" class="btn btn-outline-danger {{ request('tingkatan') == 'SD' ? 'active' : '' }}">SD</a>
                                <a href="{{ route('siswa.index', ['tingkatan' => 'SMP', 'sort' => request('sort')]) }}" class="btn btn-outline-primary {{ request('tingkatan') == 'SMP' ? 'active' : '' }}">SMP</a>
                                <a href="{{ route('siswa.index', ['tingkatan' => 'SMA', 'sort' => request('sort')]) }}" class="btn btn-outline-secondary {{ request('tingkatan') == 'SMA' ? 'active' : '' }}">SMA</a>
                            </div>
                        </div>

                    </div>
                    <button type="submit" style="display: none;"></button>
                </form>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>Jenjang</th>
                            <th>Asal Sekolah</th> 
                            <th>Kelas</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $s)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $s->nama }}</strong></td>
                            <td>
                                @if($s->tingkatan == 'TK') <span class="badge bg-success">TK</span>
                                @elseif($s->tingkatan == 'SD') <span class="badge bg-danger">SD</span>
                                @elseif($s->tingkatan == 'SMP') <span class="badge bg-primary">SMP</span>
                                @else <span class="badge bg-secondary">SMA</span>
                                @endif
                            </td>
                            <td>{{ $s->asal_sekolah ?? '-' }}</td> 
                            <td>{{ $s->kelas }}</td>
                            <td class="text-center">
                                <a href="{{ route('siswa.show', $s->id) }}" class="btn btn-info btn-sm text-white me-1" title="Lihat Detail">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                                <a href="{{ route('siswa.edit', $s->id) }}" class="btn btn-warning btn-sm me-1" title="Edit Data">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus siswa ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus Data"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Data siswa tidak ditemukan.
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