<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Bimbel Al-Kautsar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Navbar Styling */
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .navbar-brand { letter-spacing: 1px; }
        
        /* Card Stats Styling */
        .card-stats { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: 0.3s; overflow: hidden; }
        .card-stats:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .icon-box { font-size: 45px; opacity: 0.2; position: absolute; right: 20px; bottom: 10px; }
        
        /* Quick Menu Buttons */
        .sidebar-btn { 
            text-align: left; padding: 12px 20px; font-weight: 600; 
            border-radius: 10px; margin-bottom: 12px; transition: all 0.2s; 
            display: flex; align-items: center;
        }
        .sidebar-btn:hover { padding-left: 25px; background-color: #f8f9fa; }
        .sidebar-btn i { width: 25px; text-align: center; margin-right: 10px; }
        
        /* Responsive Tweaks */
        @media (max-width: 768px) {
            .card-stats { margin-bottom: 15px; }
            .icon-box { font-size: 30px; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fas fa-graduation-cap me-2"></i>SIREDAKSI BIMBEL AL KAUTSAR
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-center">
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white fw-bold d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                            <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                <i class="fas fa-user"></i>
                            </div>
                            <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                            <li><h6 class="dropdown-header text-muted">Aksi Akun</h6></li>
                            
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-cog me-2 text-secondary"></i> Edit Profil</a></li>
                            
                            <li><hr class="dropdown-divider"></li>
                            
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-bold">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        
        <div class="row g-3 mb-4">
            <div class="col-12 col-md-4">
                <div class="card card-stats bg-primary text-white h-100">
                    <div class="card-body position-relative p-4">
                        <h6 class="text-uppercase mb-1 opacity-75">Total Siswa</h6>
                        <h2 class="fw-bold mb-0">{{ $total_siswa }}</h2>
                        <div class="icon-box"><i class="fas fa-users"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card card-stats bg-success text-white h-100">
                    <div class="card-body position-relative p-4">
                        <h6 class="text-uppercase mb-1 opacity-75">Total Uang Masuk</h6>
                        <h2 class="fw-bold mb-0">Rp {{ number_format($total_uang, 0, ',', '.') }}</h2>
                        <div class="icon-box"><i class="fas fa-wallet"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card card-stats bg-warning text-dark h-100">
                    <div class="card-body position-relative p-4">
                        <h6 class="text-uppercase mb-1 opacity-75">Hari Ini</h6>
                        <h4 class="fw-bold mb-0">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</h4>
                        <div class="icon-box"><i class="fas fa-calendar-alt"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            <div class="col-lg-4 col-md-5">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold py-3 border-bottom-0">
                        <i class="fas fa-compass text-primary me-2"></i> Navigasi Cepat
                    </div>
                    <div class="card-body p-3">
                        <a href="{{ route('pembayaran.create') }}" class="btn btn-outline-primary w-100 sidebar-btn">
                            <i class="fas fa-plus-circle"></i> Input Pembayaran
                        </a>
                        <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-success w-100 sidebar-btn">
                            <i class="fas fa-table"></i> Data Pembayaran
                        </a>
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-info w-100 sidebar-btn">
                            <i class="fas fa-users"></i> Data Siswa
                        </a>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-dark w-100 sidebar-btn">
                            <i class="fas fa-user-shield"></i> Kelola Admin
                        </a>
                        <a href="{{ route('riwayat.index') }}" class="btn btn-outline-secondary w-100 sidebar-btn">
                            <i class="fas fa-history"></i> Riwayat Aktivitas
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-7">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white fw-bold py-3 d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-history text-warning me-2"></i> 5 Transaksi Terakhir</span>
                        <a href="{{ route('pembayaran.index') }}" class="badge bg-light text-secondary text-decoration-none border">Lihat Semua</a>
                    </div>
                    
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 text-start">Siswa</th>
                                        <th class="text-start">Sekolah</th> <th class="text-start">Tanggal</th>
                                        <th class="text-start pe-4">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayat as $r)
                                    <tr>
                                        <td class="ps-4 text-start">
                                            <strong>{{ $r->siswa->nama ?? 'Dihapus' }}</strong>
                                            <div class="small text-muted d-md-none">{{ $r->siswa->kelas ?? '-' }}</div> <small class="text-muted d-none d-md-block">{{ $r->siswa->kelas ?? '-' }}</small> </td>
                                        
                                        <td class="text-start">{{ $r->siswa->asal_sekolah ?? '-' }}</td>

                                        <td class="text-start">
                                            {{ \Carbon\Carbon::parse($r->tanggal_bayar)->format('d/m/Y') }}
                                        </td>
                                        
                                        <td class="text-start fw-bold text-success pe-4 text-nowrap">
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
        </div>

        <div class="text-center text-muted py-5 small opacity-50">
            &copy; {{ date('Y') }} Bimbel Al-Kautsar Application.<br>
            Developed with Laravel 12 & Bootstrap 5.
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>