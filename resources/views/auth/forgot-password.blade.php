<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Bimbel Al-Kautsar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: #f4f6f9;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-forgot {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <div class="card card-forgot p-4">
        <div class="text-center mb-4">
            <i class="fas fa-key text-warning" style="font-size: 50px;"></i>
            <h4 class="mt-3 fw-bold">Lupa Password?</h4>
            <p class="text-muted small">
                Jangan panik. Masukkan email Anda, kami akan mengirimkan link untuk me-reset password Anda.
            </p>
        </div>

        @if (session('status'))
            <div class="alert alert-success small">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label small fw-bold">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="admin@contoh.com" required autofocus>
                @error('email')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-warning w-100 fw-bold text-white py-2">
                KIRIM LINK RESET
            </button>
            
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-decoration-none small text-muted">
                    <i class="fas fa-arrow-left"></i> Kembali ke Login
                </a>
            </div>
        </form>
    </div>

</body>
</html>