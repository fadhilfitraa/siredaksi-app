<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Bimbel Al-Kautsar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #198754 0%, #20c997 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            width: 100%;
            max-width: 450px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .card-header {
            background: white;
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
            border-bottom: none;
            text-align: center;
            padding-top: 30px;
        }
        .logo-icon { font-size: 50px; color: #198754; margin-bottom: 10px; }
        .input-group-text { cursor: pointer; }
    </style>
</head>
<body>

    <div class="card card-login p-3">
        <div class="card-header">
            <i class="fas fa-user-plus logo-icon"></i>
            <h4 class="fw-bold text-success">DAFTAR ADMIN BARU</h4>
            <p class="text-muted small">Isi data berikut untuk membuat akun</p>
        </div>
        <div class="card-body">
            
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" required placeholder="Nama Anda">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control" required placeholder="email@contoh.com">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="pass1" class="form-control" required placeholder="Minimal 8 karakter">
                        <span class="input-group-text bg-white" onclick="togglePassword('pass1', 'icon1')">
                            <i class="fas fa-eye" id="icon1"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Ulangi Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="pass2" class="form-control" required placeholder="Ketik ulang password">
                        <span class="input-group-text bg-white" onclick="togglePassword('pass2', 'icon2')">
                            <i class="fas fa-eye" id="icon2"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 fw-bold py-2 rounded-pill">
                    DAFTAR SEKARANG
                </button>

            </form>
        </div>
        <div class="card-footer bg-white border-0 text-center pb-4">
            <small class="text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-decoration-none fw-bold text-success">Login disini</a></small>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

</body>
</html>