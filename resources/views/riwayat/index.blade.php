<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aktivitas Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .card { border-radius: 12px; }
        .btn-delete { border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body class="bg-light p-4">
    
    <nav class="navbar navbar-dark shadow-sm rounded mb-4 p-3">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
            <span class="text-white fw-bold">Admin Log System</span>
        </div>
    </nav>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-history text-warning me-2"></i> Log Aktivitas</h5>
            <small class="text-muted">Total: {{ $riwayat->total() }} Data</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4" width="15%">Waktu</th>
                            <th width="20%">Nama User</th>
                            <th width="10%">Aksi</th>
                            <th width="15%">Objek</th>
                            <th>Deskripsi Aktivitas</th>
                            <th class="text-center" width="10%">Opsi</th> </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                        <tr>
                            <td class="ps-4 text-muted small">
                                <div class="fw-bold text-dark">{{ $r->created_at->format('d M Y') }}</div>
                                <span class="opacity-75">{{ $r->created_at->format('H:i') }} WIB</span>
                                <div class="fst-italic" style="font-size: 11px;">{{ $r->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2 shadow-sm" style="width: 35px; height: 35px; font-weight: bold;">
                                        {{ substr($r->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $r->user->name ?? 'User Terhapus' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($r->aksi == 'Tambah') <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3">Tambah</span>
                                @elseif($r->aksi == 'Ubah') <span class="badge bg-warning bg-opacity-10 text-warning border border-warning rounded-pill px-3">Ubah</span>
                                @else <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-3">Hapus</span>
                                @endif
                            </td>
                            <td class="fw-semibold text-secondary">{{ $r->tipe_objek }}</td>
                            <td class="text-muted small">{{ $r->deskripsi }}</td>
                            
                            <td class="text-center">
                                <form action="{{ route('riwayat.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                    @csrf
                                    @method('DELETE') <button type="submit" class="btn btn-outline-danger btn-sm btn-delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-history fa-3x opacity-25 mb-3"></i>
                                <p class="mb-0">Belum ada aktivitas tercatat.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white py-3">
            {{ $riwayat->links() }}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>