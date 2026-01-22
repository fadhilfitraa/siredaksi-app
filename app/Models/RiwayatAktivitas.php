<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatAktivitas extends Model
{
    use HasFactory;

    protected $table = 'riwayat_aktivitas';
    protected $guarded = [];

    // Relasi ke User (Admin)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}