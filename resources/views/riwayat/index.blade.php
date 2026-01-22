<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Aktivitas Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light p-4">
    
    <nav class="navbar navbar-dark bg-primary rounded mb-4 p-3 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
            <span class="text-white">Admin Log System</span>
        </div>
    </nav>

    <div class="card shadow border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold"><i class="fas fa-history text-warning me-2"></i> Log Aktivitas</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-4">Waktu</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                        <th>Objek</th>
                        <th>Deskripsi Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr>
                        <td class="ps-4 text-muted small">
                            {{ $r->created_at->format('d M Y, H:i') }}<br>
                            <small>{{ $r->created_at->diffForHumans() }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px;">
                                    {{ substr($r->user->name ?? '?', 0, 1) }}
                                </div>
                                <span class="fw-bold">{{ $r->user->name ?? 'User Terhapus' }}</span>
                            </div>
                        </td>
                        <td>
                            @if($r->aksi == 'Tambah') <span class="badge bg-success">Tambah</span>
                            @elseif($r->aksi == 'Ubah') <span class="badge bg-warning text-dark">Ubah</span>
                            @else <span class="badge bg-danger">Hapus</span>
                            @endif
                        </td>
                        <td>{{ $r->tipe_objek }}</td>
                        <td>{{ $r->deskripsi }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada aktivitas tercatat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer bg-white">
            {{ $riwayat->links() }}
        </div>
    </div>

</body>
</html>