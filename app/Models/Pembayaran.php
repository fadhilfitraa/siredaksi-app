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
    'bulan_bayar',       
    'jumlah_bayar',
    'metode_pembayaran', 
    'keterangan',        
];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}