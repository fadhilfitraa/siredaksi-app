<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'tanggal_bayar',
        'jumlah_bayar',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}