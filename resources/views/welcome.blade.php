<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bimbel Alkautsar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="text-center p-10 bg-white shadow-xl rounded-lg">
        <h1 class="text-4xl font-bold text-blue-600 mb-4">SI REDAKSI</h1>
        <p class="text-gray-600 mb-8">Sistem Rekapitulasi Data Siswa dan Siswi Bimbel Al Kautsar</p>

        <div class="space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">Masuk (Login)</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Daftar (Register)</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>

</body>
</html>
