<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Siswa - Bimbel Al-Kautsar</title>
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

        /* Table Styling Tweaks */
        .table-hover tbody tr:hover { background-color: #f1f4f9; }
        
        /* Custom Button */
        .btn-back { border-radius: 50px; padding: 8px 20px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
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

    <div class="container mb-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">📊 Rekapitulasi Data Siswa</h2>
                <p class="text-muted mb-0">Ringkasan jumlah siswa berdasarkan jenjang dan asal sekolah.</p>
            </div>
            <a href="{{ route('siswa.index') }}" class="btn btn-outline-primary btn-back shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Data Siswa
            </a>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-6 col-md-2"> 
                <div class="card card-stats bg-success text-white h-100">
                    <div class="card-body position-relative p-3">
                        <h6 class="text-uppercase mb-1 opacity-75">TK</h6>
                        <h2 class="fw-bold mb-0">{{ $total_tk }}</h2>
                        <div class="icon-box" style="font-size: 30px;"><i class="fas fa-child"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-2"> 
                <div class="card card-stats bg-danger text-white h-100">
                    <div class="card-body position-relative p-3">
                        <h6 class="text-uppercase mb-1 opacity-75">SD</h6>
                        <h2 class="fw-bold mb-0">{{ $total_sd }}</h2>
                        <div class="icon-box" style="font-size: 30px;"><i class="fas fa-book"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-2"> 
                <div class="card card-stats bg-primary text-white h-100">
                    <div class="card-body position-relative p-3">
                        <h6 class="text-uppercase mb-1 opacity-75">SMP</h6>
                        <h2 class="fw-bold mb-0">{{ $total_smp }}</h2>
                        <div class="icon-box" style="font-size: 30px;"><i class="fas fa-book-reader"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-md-2"> 
                <div class="card card-stats bg-secondary text-white h-100">
                    <div class="card-body position-relative p-3">
                        <h6 class="text-uppercase mb-1 opacity-75">SMA</h6>
                        <h2 class="fw-bold mb-0">{{ $total_sma }}</h2>
                        <div class="icon-box" style="font-size: 30px;"><i class="fas fa-user-graduate"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4"> 
                <div class="card card-stats bg-dark text-white h-100">
                    <div class="card-body position-relative p-3">
                        <h6 class="text-uppercase mb-1 opacity-75">TOTAL KESELURUHAN</h6>
                        <h2 class="fw-bold mb-0">{{ $total_semua }}</h2>
                        <small class="opacity-75">Siswa Aktif</small>
                        <div class="icon-box"><i class="fas fa-users"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold py-3 border-bottom-0">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-6">
                        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-school me-2"></i> Data Sekolah Mitra</h5>
                    </div>
                    
                    <div class="col-md-5">
                        <form action="{{ route('siswa.rekap') }}" method="GET">
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted border-end-0"><i class="fas fa-search"></i></span>
                                <input type="text" name="cari" class="form-control border-start-0 ps-0" placeholder="Cari Nama Sekolah..." value="{{ request('cari') }}">
                                <button class="btn btn-primary px-4" type="submit">Cari</button>
                                @if(request('cari'))
                                    <a href="{{ route('siswa.rekap') }}" class="btn btn-light border" title="Reset">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3" width="5%">No</th>
                                <th class="py-3">Nama Sekolah</th>
                                <th class="py-3 text-center">Total Siswa</th>
                                <th class="py-3 text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_rekap as $index => $d)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark fs-6">
                                    {{ $d->asal_sekolah ? $d->asal_sekolah : 'Tidak Diketahui' }}
                                </td>
                                
                                <td class="text-center">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3 py-2 fs-6">
                                        {{ $d->total }} Siswa
                                    </span>
                                </td>
                                
                                <td class="text-center pe-4">
                                    <a href="{{ route('siswa.rekapSchool', urlencode($d->asal_sekolah ?? 'Tidak Diketahui')) }}" 
                                       class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm">
                                        Lihat Kelas <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    <div class="mb-3"><i class="fas fa-school fa-3x opacity-25"></i></div>
                                    <h6 class="fw-bold">Data Sekolah Tidak Ditemukan</h6>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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