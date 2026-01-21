<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bimbel Al-Kautsar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-login {
            width: 100%;
            max-width: 400px;
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
        .logo-icon { font-size: 50px; color: #0d6efd; margin-bottom: 10px; }
        .input-group-text { cursor: pointer; } /* Agar ikon mata bisa diklik */
    </style>
</head>
<body>

    <div class="card card-login p-3">
        <div class="card-header">
            <i class="fas fa-graduation-cap logo-icon"></i>
            <h4 class="fw-bold text-primary">BIMBEL AL-KAUTSAR</h4>
            <p class="text-muted small">Sistem Informasi Rekapitulasi</p>
        </div>
        <div class="card-body">
            
            @if ($errors->any())
                <div class="alert alert-danger py-2 small">
                    Email atau Password salah.
                </div>
            @endif
            
            @if (session('status'))
                <div class="alert alert-success py-2 small">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label small fw-bold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="admin@contoh.com" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control" placeholder="********" required>
                        <span class="input-group-text bg-white" onclick="togglePassword('password', 'icon-eye')">
                            <i class="fas fa-eye" id="icon-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label small" for="remember_me">Ingat Saya</label>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <a class="small text-decoration-none" href="{{ route('password.request') }}">
                            Lupa Password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-pill">
                    MASUK SEKARANG <i class="fas fa-sign-in-alt ms-2"></i>
                </button>

            </form>
        </div>
        
        <div class="card-footer bg-white border-0 text-center pb-4">
            <small class="text-muted">&copy; {{ date('Y') }} Bimbel Al-Kautsar.</small>
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