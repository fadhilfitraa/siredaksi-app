<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Bimbel Al-Kautsar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body { background-color: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .card-profile { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .avatar-circle {
            width: 80px; height: 80px; background: #e9ecef; color: #0d6efd;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 35px; margin: 0 auto 15px;
        }
        .form-control:focus { box-shadow: none; border-color: #0d6efd; }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-primary shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
            </a>
            <span class="text-white"><i class="fas fa-user-cog"></i> Pengaturan Akun</span>
        </div>
    </nav>

    <div class="container pb-5">

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> Profil berhasil diperbarui!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @elseif (session('status') === 'password-updated')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> Password berhasil diubah!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            
            <div class="col-md-6">
                <div class="card card-profile h-100">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="avatar-circle">
                                <i class="fas fa-user"></i>
                            </div>
                            <h5 class="fw-bold">Informasi Profil</h5>
                            <p class="text-muted small">Update nama akun dan alamat email Anda.</p>
                        </div>
                        <hr>

                        <form method="post" action="{{ route('profile.update') }}">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-id-card"></i></span>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required autofocus>
                                </div>
                                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                </div>
                                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary fw-bold">
                                    <i class="fas fa-save me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-profile h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning text-white rounded p-2 me-3">
                                <i class="fas fa-key fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Ganti Password</h5>
                                <small class="text-muted">Pastikan password aman dan panjang.</small>
                            </div>
                        </div>
                        <hr>

                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Password Saat Ini</label>
                                <input type="password" name="current_password" class="form-control" placeholder="Masukan password lama..." required>
                                @error('current_password', 'updatePassword') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold small">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Minimal 8 karakter" required>
                                @error('password', 'updatePassword') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold small">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru..." required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark fw-bold">
                                    <i class="fas fa-lock me-2"></i> Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card card-profile border border-danger border-opacity-25">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
                        <div>
                            <h5 class="fw-bold text-danger mb-1"><i class="fas fa-exclamation-triangle me-2"></i> Hapus Akun</h5>
                            <p class="text-muted small mb-0">Tindakan ini tidak dapat dibatalkan. Semua data Anda akan hilang.</p>
                        </div>
                        <button class="btn btn-outline-danger fw-bold" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            Hapus Akun Saya
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title fw-bold">Konfirmasi Hapus Akun</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <i class="fas fa-trash-alt text-danger fa-3x mb-3"></i>
                        <p class="fw-bold">Apakah Anda yakin ingin menghapus akun ini?</p>
                        <p class="small text-muted">Silakan masukkan password Anda untuk mengonfirmasi.</p>
                        
                        <input type="password" name="password" class="form-control text-center" placeholder="Masukan Password Anda" required>
                        @error('password', 'userDeletion') <span class="text-danger small d-block mt-2">{{ $message }}</span> @enderror
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Ya, Hapus Permanen</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>