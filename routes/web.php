<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController; // TAMBAHAN: Import Controller User
use App\Models\Siswa;
use App\Models\Pembayaran;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $total_siswa = Siswa::count();
    $total_uang = Pembayaran::sum('jumlah_bayar');
    $riwayat = Pembayaran::with('siswa')->latest()->take(5)->get();
    return view('dashboard', compact('total_siswa', 'total_uang', 'riwayat'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('user', App\Http\Controllers\UserController::class);

    // MANAJEMEN ADMIN (USER)
    Route::resource('user', UserController::class);

    // PEMBAYARAN
    Route::get('/pembayaran/{id}/cetak', [PembayaranController::class, 'cetak'])->name('pembayaran.cetak');
    
    // Route Export Excel
    Route::get('/pembayaran/export', [PembayaranController::class, 'export'])->name('pembayaran.export');
    Route::resource('pembayaran', PembayaranController::class);

    // SISWA
    Route::get('/siswa/export', [SiswaController::class, 'export'])->name('siswa.export');
    
    // Rute Rekap Siswa
    Route::get('/rekap-siswa', [SiswaController::class, 'rekap'])->name('siswa.rekap');
    Route::get('/rekap-siswa/detail', [SiswaController::class, 'rekapDetail'])->name('siswa.rekapDetail');
    
    // Resource Siswa (Cukup satu baris ini saja)
    Route::resource('siswa', SiswaController::class);
});

require __DIR__.'/auth.php';