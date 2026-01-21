<!DOCTYPE html>
<html>
<head>
    <title>Detail Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 800px;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="text-muted mb-0">Daftar Siswa dari:</h5>
                <h2 class="text-primary fw-bold">
                    <i class="fas fa-school"></i> {{ $sekolah }}
                </h2>
                <h4><span class="badge bg-warning text-dark">Kelas {{ $kelas }}</span></h4>
            </div>
            <a href="{{ route('siswa.rekap') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Rekap
            </a>
        </div>

        <div class="card shadow border-0">
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Siswa</th>
                            <th>Jenjang</th>
                            <th>Terdaftar Sejak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $index => $s)
                        <tr>
                            <td class="ps-4">{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $s->nama }}</td>
                            <td>{{ $s->tingkatan }}</td>
                            <td>{{ $s->created_at->format('d F Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">Data Error.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white text-muted small text-center">
                Total: <strong>{{ count($siswas) }}</strong> Siswa ditemukan.
            </div>
        </div>

    </div>
</body>
</html>