<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Admin - Bimbel Al-Kautsar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Navbar Styling */
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .navbar-brand { letter-spacing: 1px; }

        /* Card & Table Styling */
        .card { border-radius: 12px; }
        .table-hover tbody tr:hover { background-color: #f1f4f9; }
        
        /* Button Styling */
        .btn-add { border-radius: 50px; padding: 8px 25px; font-weight: 600; }
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
                <h2 class="fw-bold text-dark mb-1">
                    <i class="fas fa-user-shield text-primary me-2"></i>Manajemen Admin & Staff
                </h2>
                <p class="text-muted mb-0 ms-4 ps-2">Kelola akun yang memiliki akses login ke sistem.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-back shadow-sm bg-white text-dark border-0">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom-0 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-users-cog me-2"></i> Daftar Admin Terdaftar</h5>
                <a href="{{ route('user.create') }}" class="btn btn-primary btn-add shadow-sm">
                    <i class="fas fa-user-plus me-2"></i> Tambah Admin
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3" width="5%">No</th>
                                <th class="py-3">Nama Lengkap</th>
                                <th class="py-3">Email</th>
                                <th class="py-3">Bergabung Sejak</th>
                                <th class="py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $u)
                            <tr>
                                <td class="ps-4 text-muted fw-bold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light text-primary rounded-circle d-flex justify-content-center align-items-center me-3 border" style="width: 40px; height: 40px; font-weight: bold;">
                                            {{ substr($u->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $u->name }}</div>
                                            
                                            @if($u->id == Auth::id())
                                                <div class="mt-1">
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-1 fw-normal">
                                                        <i class="fas fa-check-circle me-1" style="font-size: 10px;"></i> Anda (Sedang Login)
                                                    </span>
                                                </div>
                                            @endif
                                            
                                        </div>
                                    </div>
                                </td>
                                <td class="text-secondary">{{ $u->email }}</td>
                                <td class="text-muted small">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $u->created_at->format('d M Y') }}
                                </td>
                                <td class="text-center">
                                    @if($u->id != Auth::id())
                                    <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('⚠️ PERINGATAN: Menghapus admin ini akan mencabut akses loginnya secara permanen. Lanjutkan?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm rounded-pill px-3" title="Hapus Akses">
                                            <i class="fas fa-trash-alt me-1"></i> Hapus
                                        </button>
                                    </form>
                                    @else
                                        <button class="btn btn-light btn-sm rounded-pill px-3 text-muted border" disabled title="Tidak bisa menghapus akun sendiri">
                                            <i class="fas fa-lock me-1"></i> Terkunci
                                        </button>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3">
                <div class="alert alert-info mb-0 d-flex align-items-center border-0 bg-info bg-opacity-10 text-info">
                    <i class="fas fa-info-circle fa-lg me-3"></i>
                    <div>
                        <strong>Catatan Keamanan:</strong><br>
                        <small class="text-dark opacity-75">Hanya Admin yang terdaftar di halaman ini yang memiliki akses Login ke Dashboard. Pastikan menghapus akun staff yang sudah tidak aktif.</small>
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