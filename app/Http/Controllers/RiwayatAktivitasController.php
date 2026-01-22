<?php

namespace App\Http\Controllers;

use App\Models\RiwayatAktivitas;
use Illuminate\Http\Request;

class RiwayatAktivitasController extends Controller
{
    public function index()
    {
        // Ambil data terbaru, lengkap dengan nama adminnya
        $riwayat = RiwayatAktivitas::with('user')->latest()->paginate(20);
        
        return view('riwayat.index', compact('riwayat'));
    }
}