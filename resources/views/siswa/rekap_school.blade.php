<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kelas - {{ $nama_sekolah }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .navbar-brand { letter-spacing: 1px; }
        .table-hover tbody tr:hover { background-color: #f1f4f9; }
        .btn-back { border-radius: 50px; padding: 8px 25px; font-weight: 600; }
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
                <h6 class="text-uppercase text-muted mb-1 ls-1 small fw-bold">Detail Sekolah</h6>
                <h2 class="fw-bold text-primary mb-0">
                    <i class="fas fa-school me-2 text-dark opacity-75"></i> {{ $nama_sekolah }}
                </h2>
            </div>
            <a href="{{ route('siswa.rekap') }}" class="btn btn-outline-primary btn-back shadow-sm">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Rekap
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white fw-bold py-3 border-bottom-0">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="fas fa-chalkboard me-2 text-secondary"></i> Daftar Kelas Terdaftar
                </h5>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3" width="30%">Nama Kelas</th>
                                <th class="py-3 text-center">Jenjang</th>
                                <th class="py-3 text-center">Jumlah Siswa</th>
                                <th class="py-3 text-center pe-4" width="20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data_kelas as $d)
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-dark fs-5">{{ $d->kelas }}</span>
                                </td>
                                
                                <td class="text-center">
                                    @if($d->tingkatan == 'TK') 
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3">TK</span>
                                    @elseif($d->tingkatan == 'SD') 
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-3">SD</span>
                                    @elseif($d->tingkatan == 'SMP') 
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3">SMP</span>
                                    @else 
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3">SMA</span>
                                    @endif
                                </td>
                                
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fs-6 shadow-sm">
                                        {{ $d->total }} Siswa
                                    </span>
                                </td>
                                
                                <td class="text-center pe-4">
                                    <a href="{{ route('siswa.rekapDetail', ['sekolah' => $nama_sekolah, 'kelas' => $d->kelas]) }}" 
                                       class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm fw-bold">
                                        <i class="fas fa-users me-1"></i> Lihat Siswa
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <div class="mb-3"><i class="fas fa-chalkboard-teacher fa-3x opacity-25"></i></div>
                                    <h6 class="fw-bold">Belum ada kelas terdaftar untuk sekolah ini.</h6>
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