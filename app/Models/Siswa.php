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
        'asal_sekolah', // <--- TAMBAHAN BARU
        'kelas'
    ];

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}