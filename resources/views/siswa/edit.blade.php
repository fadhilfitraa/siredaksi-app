<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa - SIREDAKSI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            background-color: #f4f6f9; 
            font-family: 'Poppins', sans-serif; 
        }
        
        /* Navbar Gradient */
        .navbar { background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%); }
        .navbar-brand { letter-spacing: 1px; }
        
        /* Card Style */
        .card-custom { 
            border: none; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            background: white; 
            overflow: hidden;
        }

        /* Form Styling */
        .form-label { font-weight: 500; color: #495057; font-size: 0.9rem; margin-bottom: 0.5rem; }
        .input-group-text { background-color: #f8f9fa; border-right: none; color: #6c757d; }
        .form-control, .form-select { 
            border-left: none; 
            padding: 10px 15px;
            font-size: 0.95rem;
        }
        .form-control:focus, .form-select:focus { 
            box-shadow: none; 
            border-color: #dee2e6; 
            background-color: #fff;
        }
        .input-group:focus-within .input-group-text { border-color: #86b7fe; }
        .input-group:focus-within .form-control, 
        .input-group:focus-within .form-select { border-color: #86b7fe; }

        .required-star { color: #dc3545; margin-left: 2px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
                <i class="fas fa-graduation-cap me-2"></i>SIREDAKSI BIMBEL AL KAUTSAR
            </a>
            <div class="ms-auto text-white opacity-75 small">
                Admin
            </div>
        </div>
    </nav>

    <div class="container mt-4 mb-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold text-dark mb-1">Edit Data Siswa</h4>
                <p class="text-muted small mb-0">Perbarui informasi siswa di bawah ini.</p>
            </div>
            <a href="{{ route('siswa.index') }}" class="btn btn-secondary shadow-sm fw-bold px-4 py-2 rounded-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card card-custom">
                    
                    <div class="card-header bg-white p-4 border-bottom">
                        <h6 class="mb-0 fw-bold text-warning"><i class="fas fa-user-edit me-2"></i>Formulir Perubahan Data</h6>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-4 mb-4">
                                <div class="col-md-7">
                                    <label class="form-label">Nama Lengkap <span class="required-star">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text border"><i class="fas fa-user"></i></span>
                                        <input type="text" name="nama" class="form-control border @error('nama') is-invalid @enderror" value="{{ old('nama', $siswa->nama) }}" required>
                                    </div>
                                    @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-5">
                                    <label class="form-label">Nomor WhatsApp / HP</label>
                                    <div class="input-group">
                                        <span class="input-group-text border"><i class="fab fa-whatsapp"></i></span>
                                        <input type="number" name="no_hp" class="form-control border @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $siswa->no_hp) }}" placeholder="08xxxxxxxxxx">
                                    </div>
                                    @error('no_hp') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label class="form-label">Jenjang Pendidikan <span class="required-star">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text border"><i class="fas fa-graduation-cap"></i></span>
                                        <select name="tingkatan" class="form-select border @error('tingkatan') is-invalid @enderror" required>
                                            <option value="" disabled>-- Pilih Jenjang --</option>
                                            <option value="TK" {{ old('tingkatan', $siswa->tingkatan) == 'TK' ? 'selected' : '' }}>TK</option>
                                            <option value="SD" {{ old('tingkatan', $siswa->tingkatan) == 'SD' ? 'selected' : '' }}>SD</option>
                                            <option value="SMP" {{ old('tingkatan', $siswa->tingkatan) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                            <option value="SMA" {{ old('tingkatan', $siswa->tingkatan) == 'SMA' ? 'selected' : '' }}>SMA</option>
                                        </select>
                                    </div>
                                    @error('tingkatan') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Kelas Saat Ini <span class="required-star">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text border"><i class="fas fa-chalkboard"></i></span>
                                        <input type="text" name="kelas" class="form-control border @error('kelas') is-invalid @enderror" value="{{ old('kelas', $siswa->kelas) }}" required>
                                    </div>
                                    @error('kelas') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>

                            <div class="mb-5">
                                <label class="form-label">Asal Sekolah</label>
                                <div class="input-group">
                                    <span class="input-group-text border"><i class="fas fa-school"></i></span>
                                    <input type="text" name="asal_sekolah" class="form-control border @error('asal_sekolah') is-invalid @enderror" value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 border-top pt-4">
                                <a href="{{ route('siswa.index') }}" class="btn btn-light text-muted fw-bold px-4 py-2 rounded-3 border">Batal</a>
                                <button type="submit" class="btn btn-warning fw-bold px-5 py-2 rounded-3 shadow-sm text-dark">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>