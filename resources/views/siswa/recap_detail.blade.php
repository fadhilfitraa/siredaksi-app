<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Siswa - {{ $sekolah }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Navbar Styling */
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .navbar-brand { letter-spacing: 1px; }
        
        /* Table & Card Styling */
        .table-hover tbody tr:hover { background-color: #f1f4f9; }
        .card { border-radius: 12px; }
        
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

    <div class="container mb-5" style="max-width: 1000px;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h6 class="text-uppercase text-muted mb-1 ls-1 small fw-bold">Detail Data Siswa</h6>
                <h2 class="fw-bold text-primary mb-2">
                    <i class="fas fa-school me-2"></i> {{ $sekolah }}
                </h2>
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-chalkboard me-1"></i> Kelas {{ $kelas }}
                </span>
            </div>
            <a href="{{ route('siswa.rekap') }}" class="btn btn-outline-secondary btn-back shadow-sm bg-white text-dark border-0">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Rekap
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-list-ul me-2 text-secondary"></i> Daftar Nama Siswa</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3" width="5%">No</th>
                                <th class="py-3">Nama Siswa</th>
                                <th class="py-3">Jenjang</th>
                                <th class="py-3">Terdaftar Sejak</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $index => $s)
                            <tr>
                                <td class="ps-4 fw-bold text-secondary">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $s->nama }}</td>
                                <td>
                                    @if($s->tingkatan == 'TK') <span class="badge bg-success bg-opacity-10 text-success border border-success px-3">TK</span>
                                    @elseif($s->tingkatan == 'SD') <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3">SD</span>
                                    @elseif($s->tingkatan == 'SMP') <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-3">SMP</span>
                                    @else <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary px-3">SMA</span>
                                    @endif
                                </td>
                                <td class="text-muted small">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $s->created_at->format('d F Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-exclamation-circle fa-2x mb-2 opacity-25"></i><br>
                                    Data siswa tidak ditemukan untuk kategori ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3 text-end">
                <span class="text-muted small me-2">Total Siswa:</span>
                <span class="badge bg-dark rounded-pill px-3">{{ count($siswas) }}</span>
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