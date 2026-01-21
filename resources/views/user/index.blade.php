<!DOCTYPE html>
<html>
<head>
    <title>Kelola Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light p-5">
    <div class="container" style="max-width: 900px;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3>👥 Manajemen Admin / Staff</h3>
            <a href="{{ route('dashboard') }}" class="btn btn-dark">
                <i class="fas fa-home"></i> Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow">
            <div class="card-header bg-white p-3">
                <a href="{{ route('user.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Tambah Admin Baru
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Terdaftar Pada</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus akses admin ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger btn-sm" title="Hapus Akses">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="alert alert-info mt-4">
            <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Hanya Admin yang terdaftar di sini yang bisa login dan mengakses aplikasi ini.
        </div>

    </div>
</body>
</html>