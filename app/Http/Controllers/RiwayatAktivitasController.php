<?php

namespace App\Http\Controllers;

use App\Models\RiwayatAktivitas;
use Illuminate\Http\Request;

class RiwayatAktivitasController extends Controller
{
    public function index()
    {
        $riwayat = RiwayatAktivitas::with('user')->latest()->paginate(20);
        
        return view('riwayat.index', compact('riwayat'));
    }

    public function destroy($id)
    {
    $data = \App\Models\RiwayatAktivitas::findOrFail($id);
    $data->delete();
    return back()->with('success', 'Berhasil dihapus.');
    }
}
