<?php

namespace App\Observers;

use App\Models\Pembayaran;
use App\Models\RiwayatAktivitas;
use Illuminate\Support\Facades\Auth;

class PembayaranObserver
{
    public function created(Pembayaran $pembayaran): void
    {
        // Kita load relasi siswa biar bisa ambil namanya
        $pembayaran->load('siswa');
        $nama_siswa = $pembayaran->siswa->nama ?? 'Siswa Terhapus';

        RiwayatAktivitas::create([
            'user_id' => Auth::id() ?? 1,
            'aksi' => 'Tambah',
            'tipe_objek' => 'Pembayaran',
            'deskripsi' => "Menerima pembayaran Rp " . number_format($pembayaran->jumlah_bayar) . " dari {$nama_siswa}"
        ]);
    }

    public function deleted(Pembayaran $pembayaran): void
    {
        RiwayatAktivitas::create([
            'user_id' => Auth::id() ?? 1,
            'aksi' => 'Hapus',
            'tipe_objek' => 'Pembayaran',
            'deskripsi' => "Menghapus data pembayaran ID #{$pembayaran->id}"
        ]);
    }
}