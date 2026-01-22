<?php

namespace App\Observers;

use App\Models\Siswa;
use App\Models\RiwayatAktivitas;
use Illuminate\Support\Facades\Auth;

class SiswaObserver
{
    public function created(Siswa $siswa): void
    {
        RiwayatAktivitas::create([
            'user_id' => Auth::id() ?? 1, // Default ID 1 jika dijalankan seeder/bukan login
            'aksi' => 'Tambah',
            'tipe_objek' => 'Siswa',
            'deskripsi' => "Menambahkan siswa baru: {$siswa->nama} ({$siswa->kelas})"
        ]);
    }

    public function updated(Siswa $siswa): void
    {
        RiwayatAktivitas::create([
            'user_id' => Auth::id() ?? 1,
            'aksi' => 'Ubah',
            'tipe_objek' => 'Siswa',
            'deskripsi' => "Mengubah data siswa: {$siswa->nama}"
        ]);
    }

    public function deleted(Siswa $siswa): void
    {
        RiwayatAktivitas::create([
            'user_id' => Auth::id() ?? 1,
            'aksi' => 'Hapus',
            'tipe_objek' => 'Siswa',
            'deskripsi' => "Menghapus siswa: {$siswa->nama}"
        ]);
    }
}