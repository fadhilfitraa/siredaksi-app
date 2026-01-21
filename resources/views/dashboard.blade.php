<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Bimbel Al-Kautsar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; }
        .card-stats { border: none; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); transition: 0.3s; }
        .card-stats:hover { transform: translateY(-5px); }
        .icon-box { font-size: 40px; opacity: 0.3; }
        .sidebar-btn { text-align: left; padding: 15px; font-weight: bold; border-radius: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-graduation-cap"></i> BIMBEL AL-KAUTSAR
            </a>
            <div class="d-flex text-white align-items-center">
                <span class="me-3"><i class="fas fa-user-circle"></i> Halo, {{ Auth::user()->name ?? 'Admin' }}!</span>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm rounded-pill px-3">
                        Logout <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card card-stats bg-primary text-white mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center p-4">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Siswa</h6>
                            <h2 class="fw-bold mb-0">{{ $total_siswa }}</h2>
                        </div>
                        <div class="icon-box">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stats bg-success text-white mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center p-4">
                        <div>
                            <h6 class="text-uppercase mb-1">Total Uang Masuk</h6>
                            <h2 class="fw-bold mb-0">Rp {{ number_format($total_uang, 0, ',', '.') }}</h2>
                        </div>
                        <div class="icon-box">
                            <i class="fas fa-wallet"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-stats bg-warning text-dark mb-3">
                    <div class="card-body d-flex justify-content-between align-items-center p-4">
                        <div>
                            <h6 class="text-uppercase mb-1">Hari Ini</h6>
                            <h4 class="fw-bold mb-0">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</h4>
                        </div>
                        <div class="icon-box">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold py-3">
                        <i class="fas fa-compass text-primary"></i> Menu Cepat
                    </div>
                    <div class="card-body">
                        <a href="{{ route('pembayaran.create') }}" class="btn btn-outline-primary w-100 sidebar-btn">
                            <i class="fas fa-plus-circle me-2"></i> Input Pembayaran Baru
                        </a>
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-success w-100 sidebar-btn">
                            <i class="fas fa-table me-2"></i> Lihat Data Pembayaran
                        </a>
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-info w-100 sidebar-btn">
                            <i class="fas fa-users me-2"></i> Kelola Data Siswa
                        </a>
                        
                        <a href="{{ route('user.index') }}" class="btn btn-outline-dark w-100 sidebar-btn">
                            <i class="fas fa-user-shield me-2"></i> Manajemen Admin
                        </a>

                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between">
                        <span><i class="fas fa-history text-warning"></i> 5 Transaksi Terakhir</span>
                        <a href="{{ route('pembayaran.index') }}" class="text-decoration-none text-muted small">Lihat Semua →</a>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-striped mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4 text-start">Siswa</th>
                                    <th class="text-start">Asal Sekolah</th>
                                    <th class="text-start">Tanggal</th>
                                    <th class="text-start">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riwayat as $r)
                                <tr>
                                    <td class="ps-4 text-start">
                                        <strong>{{ $r->siswa->nama ?? 'Dihapus' }}</strong><br>
                                        <small class="text-muted">{{ $r->siswa->kelas ?? '-' }}</small>
                                    </td>
                                    
                                    <td class="text-start">{{ $r->siswa->asal_sekolah ?? '-' }}</td>

                                    <td class="text-start">{{ \Carbon\Carbon::parse($r->tanggal_bayar)->translatedFormat('d F Y') }}</td>
                                    
                                    <td class="text-start fw-bold text-success">
                                        + Rp {{ number_format($r->jumlah_bayar, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Belum ada transaksi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center text-muted py-4 small">
            &copy; {{ date('Y') }} Bimbel Al-Kautsar Application. Built with Laravel 12.
        </div>
    </div>

</body>
</html>