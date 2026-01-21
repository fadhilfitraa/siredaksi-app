<!DOCTYPE html>
<html>
<head>
    <title>Rekapitulasi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light p-5">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>📊 Rekapitulasi Data Siswa</h1>
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Data Siswa
            </a>
        </div>

        <div class="row text-center mb-4">
            <div class="col">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body">
                        <h3>TK</h3>
                        <h1 class="fw-bold">{{ $total_tk }}</h1>
                        <small>Siswa</small>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-danger text-white shadow-sm">
                    <div class="card-body">
                        <h3>SD</h3>
                        <h1 class="fw-bold">{{ $total_sd }}</h1>
                        <small>Siswa</small>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-primary text-white shadow-sm">
                    <div class="card-body">
                        <h3>SMP</h3>
                        <h1 class="fw-bold">{{ $total_smp }}</h1>
                        <small>Siswa</small>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-secondary text-white shadow-sm">
                    <div class="card-body">
                        <h3>SMA</h3>
                        <h1 class="fw-bold">{{ $total_sma }}</h1>
                        <small>Siswa</small>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card bg-dark text-white shadow-sm">
                    <div class="card-body">
                        <h3>TOTAL</h3>
                        <h1 class="fw-bold">{{ $total_semua }}</h1>
                        <small>Seluruh Siswa</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header bg-white p-3">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-6">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-school"></i> Data Siswa per Sekolah & Kelas</h5>
                    </div>
                    
                    <div class="col-md-4">
                        <form action="{{ route('siswa.rekap') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="cari" class="form-control" placeholder="Cari Sekolah atau Kelas..." value="{{ request('cari') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                @if(request('cari'))
                                    <a href="{{ route('siswa.rekap') }}" class="btn btn-secondary" title="Reset">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-hover table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Asal Sekolah</th>
                            <th>Kelas</th>
                            <th>Jenjang</th>
                            <th class="text-center">Jumlah Siswa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data_rekap as $d)
                        <tr>
                            <td class="fw-bold text-primary">
                                {{ $d->asal_sekolah ? $d->asal_sekolah : 'Tidak Diketahui' }}
                            </td>
                            <td class="fw-bold">{{ $d->kelas }}</td>
                            <td>
                                @if($d->tingkatan == 'TK') <span class="badge bg-success">TK</span>
                                @elseif($d->tingkatan == 'SD') <span class="badge bg-danger">SD</span>
                                @elseif($d->tingkatan == 'SMP') <span class="badge bg-primary">SMP</span>
                                @else <span class="badge bg-secondary">SMA</span>
                                @endif
                            </td>
                            <td class="text-center fs-5 fw-bold">{{ $d->total }}</td>
                            <td class="text-center">
                                <a href="{{ route('siswa.rekapDetail', [
                                    'sekolah' => $d->asal_sekolah ?? 'Tidak Diketahui', 
                                    'kelas' => $d->kelas
                                ]) }}" class="btn btn-info btn-sm text-white">
                                    <i class="fas fa-users"></i> Lihat Siswa
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="fas fa-search fa-2x mb-2"></i><br>
                                Data rekap tidak ditemukan.
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