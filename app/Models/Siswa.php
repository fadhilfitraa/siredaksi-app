<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

   protected $fillable = [
    'nama',
    'tingkatan',
    'kelas',
    'asal_sekolah',
    'no_hp', // <-- Tambahkan ini
];

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}