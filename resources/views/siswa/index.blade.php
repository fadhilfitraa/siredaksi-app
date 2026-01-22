<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - SIREDAKSI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Navbar Gradient */
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .navbar-brand { letter-spacing: 1px; }
        
        /* Card Custom */
        .card-custom { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); overflow: hidden; background: white; }
        
        /* Filter Jenjang */
        .jenjang-link {
            text-decoration: none; color: #6c757d; border: 1px solid #dee2e6;
            padding: 6px 18px; border-radius: 50px; font-weight: 600; font-size: 0.85rem;
            transition: all 0.2s; background-color: white; display: inline-block;
        }
        .jenjang-link:hover { background-color: #f8f9fa; border-color: #adb5bd; color: #495057; }
        .jenjang-link.active { background-color: #0d6efd; color: white; border-color: #0d6efd; }

        /* Table Styling */
        .table-custom thead th { 
            background-color: #f1f3f5; border-bottom: 2px solid #dee2e6; color: #495057;
            font-weight: 700; text-transform: uppercase; font-size: 0.8rem;
            vertical-align: middle; white-space: nowrap;
        }
        .table-custom tbody td { vertical-align: middle; font-size: 0.95rem; padding: 10px 15px; border-color: #e9ecef; }
        .table-hover tbody tr:hover { background-color: #f8f9fa; }

        /* Link Nama Siswa */
        .nama-siswa-link { color: #212529; text-decoration: none; transition: color 0.2s; }
        .nama-siswa-link:hover { color: #0d6efd; text-decoration: underline; }

        /* --- STYLE BARU UNTUK TOMBOL AKSI --- */
        .btn-icon {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%; /* Bulat Sempurna */
            transition: all 0.2s;
            margin: 0 3px; /* Jarak antar tombol */
            border: 1px solid #dee2e6;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .btn-icon:hover { transform: scale(1.1); box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        
        /* Warna Spesifik */
        .btn-detail { color: #0dcaf0; } /* Biru Muda */
        .btn-detail:hover { background-color: #0dcaf0; color: white; border-color: #0dcaf0; }
        
        .btn-edit { color: #ffc107; } /* Kuning */
        .btn-edit:hover { background-color: #ffc107; color: black; border-color: #ffc107; }
        
        .btn-delete { color: #dc3545; } /* Merah */
        .btn-delete:hover { background-color: #dc3545; color: white; border-color: #dc3545; }

    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
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
                                    <button type="submit" class="dropdown-item text-danger fw-bold"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Manajemen Data Siswa</h4>
                <p class="text-muted small mb-0">Total {{ $siswas->count() }} siswa terdaftar di Bimbel Al Kautsar.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-secondary shadow-sm fw-bold px-4 py-2 rounded-3">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('siswa.create') }}" class="btn btn-primary shadow-sm fw-bold px-4 py-2 rounded-3">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Siswa
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                <i class="fas fa-check-circle me-2 fs-5"></i> {{ session('success') }}
            </div>
        @endif

        <div class="card card-custom">
            
            <div class="card-header bg-white p-4 border-bottom">
                <form action="{{ route('siswa.index') }}" method="GET">
                    @if(request('tingkatan')) <input type="hidden" name="tingkatan" value="{{ request('tingkatan') }}"> @endif
                    
                    <div class="mb-4">
                        <label class="small text-muted fw-bold text-uppercase mb-2 d-block">Filter Jenjang Pendidikan</label>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('siswa.index', ['sort' => request('sort')]) }}" class="jenjang-link {{ !request('tingkatan') ? 'active' : '' }}">Semua</a>
                            <a href="{{ route('siswa.index', ['tingkatan' => 'TK', 'sort' => request('sort')]) }}" class="jenjang-link {{ request('tingkatan') == 'TK' ? 'active' : '' }}">TK</a>
                            <a href="{{ route('siswa.index', ['tingkatan' => 'SD', 'sort' => request('sort')]) }}" class="jenjang-link {{ request('tingkatan') == 'SD' ? 'active' : '' }}">SD</a>
                            <a href="{{ route('siswa.index', ['tingkatan' => 'SMP', 'sort' => request('sort')]) }}" class="jenjang-link {{ request('tingkatan') == 'SMP' ? 'active' : '' }}">SMP</a>
                            <a href="{{ route('siswa.index', ['tingkatan' => 'SMA', 'sort' => request('sort')]) }}" class="jenjang-link {{ request('tingkatan') == 'SMA' ? 'active' : '' }}">SMA</a>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap align-items-center justify-content-between p-3 bg-light rounded-3 border">
                        <div class="d-flex gap-3 flex-grow-1" style="max-width: 700px;">
                            <select name="sort" class="form-select border border-secondary-subtle" style="width: auto; cursor: pointer;" onchange="this.form.submit()">
                                <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Urutan: Terbaru</option>
                                <option value="nama_az" {{ request('sort') == 'nama_az' ? 'selected' : '' }}>Nama (A-Z)</option>
                                <option value="kelas_az" {{ request('sort') == 'kelas_az' ? 'selected' : '' }}>Kelas (A-Z)</option>
                                <option value="jenjang_asc" {{ request('sort') == 'jenjang_asc' ? 'selected' : '' }}>Jenjang (TK - SMA)</option>
                            </select>
                            <div class="input-group flex-grow-1">
                                <span class="input-group-text bg-white border border-end-0 border-secondary-subtle"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="cari" class="form-control border border-start-0 border-secondary-subtle" placeholder="Cari nama atau sekolah..." value="{{ request('cari') }}">
                            </div>
                        </div>
                        <div class="d-flex gap-2 mt-2 mt-md-0">
                            <a href="{{ route('siswa.rekap') }}" class="btn btn-warning btn-sm text-dark fw-bold border border-warning shadow-sm px-3 d-flex align-items-center">
                                <i class="fas fa-chart-pie me-2"></i> Rekap
                            </a>
                            <a href="{{ route('siswa.export') }}" class="btn btn-success btn-sm text-white fw-bold border border-success shadow-sm px-3 d-flex align-items-center">
                                <i class="fas fa-file-excel me-2"></i> Excel
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-custom mb-0">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-start">Nama Lengkap</th>
                                <th class="text-center" width="10%">Jenjang</th>
                                <th class="text-start">Asal Sekolah</th>
                                <th class="text-center" width="10%">Kelas</th>
                                <th class="text-center" width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($siswas as $index => $s)
                            <tr>
                                <td class="text-center text-muted fw-bold">{{ $index + 1 }}</td>
                                <td class="text-start">
                                    <a href="{{ route('siswa.show', $s->id) }}" class="nama-siswa-link fw-bold" title="Klik untuk lihat detail">
                                        {{ $s->nama }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if($s->tingkatan == 'TK') <span class="badge bg-success bg-opacity-10 text-success border border-success px-2 rounded-pill">TK</span>
                                    @elseif($s->tingkatan == 'SD') <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-2 rounded-pill">SD</span>
                                    @elseif($s->tingkatan == 'SMP') <span class="badge bg-primary bg-opacity-10 text-primary border border-primary px-2 rounded-pill">SMP</span>
                                    @else <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary px-2 rounded-pill">SMA</span>
                                    @endif
                                </td>
                                <td class="text-start text-secondary">{{ $s->asal_sekolah ?? '-' }}</td>
                                <td class="text-center fw-semibold text-dark">{{ $s->kelas }}</td>
                                
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        
                                        <a href="{{ route('siswa.show', $s->id) }}" class="btn btn-icon btn-detail" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        <a href="{{ route('siswa.edit', $s->id) }}" class="btn btn-icon btn-edit" title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus siswa {{ $s->nama }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-delete" title="Hapus Data">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted opacity-50">
                                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                                        <p>Tidak ada data siswa ditemukan.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-footer bg-white py-3 border-top">
                <small class="text-muted">Menampilkan {{ $siswas->count() }} data siswa</small>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>