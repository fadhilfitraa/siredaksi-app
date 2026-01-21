<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Exports\PembayaranExport;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranController extends Controller
{
    // 1. HALAMAN UTAMA (INDEX) - DENGAN FILTER
    public function index(Request $request)
    {
        // 1. Siapkan Query Dasar (Penting: select pembayarans.* agar ID tidak tertimpa saat Join)
        $query = Pembayaran::select('pembayarans.*')->with('siswa');

        // 2. Logika JOIN (Jika user minta urutkan berdasarkan data siswa)
        if ($request->sort == 'nama_az' || $request->sort == 'kelas_az') {
            $query->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id');
        }

        // 3. Logika Filter Bulan & Tahun (Tetap Jalan)
        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }

        // 4. Logika SORTING (Inti Fitur Baru)
        switch ($request->sort) {
            case 'nama_az':
                $query->orderBy('siswas.nama', 'asc'); // Nama A-Z
                break;
            case 'kelas_az':
                $query->orderBy('siswas.kelas', 'asc'); // Kelas A-Z
                break;
            case 'tanggal_terlama':
                $query->orderBy('tanggal_bayar', 'asc'); // Tanggal Lama (Januari dulu)
                break;
            default:
                $query->orderBy('tanggal_bayar', 'desc'); // Default: Tanggal Terbaru
                break;
        }

        // 5. Eksekusi
        $pembayarans = $query->get();
        $total_pemasukan = $pembayarans->sum('jumlah_bayar');

        return view('pembayaran.index', compact('pembayarans', 'total_pemasukan'));
    }

    // 2. HALAMAN TAMBAH DATA (CREATE) <--- INI YANG HILANG TADI
    public function create()
    {
        $siswas = Siswa::latest()->get(); // Ambil data siswa untuk dropdown
        return view('pembayaran.create', compact('siswas'));
    }

    // 3. PROSES SIMPAN DATA (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric', // Pastikan input sudah angka murni (titik dihapus JS)
        ]);

        Pembayaran::create($request->all());

        return redirect()->route('pembayaran.index')->with('success', 'Pembayaran berhasil disimpan!');
    }

    // 4. HALAMAN EDIT DATA
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $siswas = Siswa::latest()->get();
        return view('pembayaran.edit', compact('pembayaran', 'siswas'));
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_bayar' => 'required|date',
            'jumlah_bayar' => 'required|numeric',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update($request->all());

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus!');
    }

    // 7. CETAK KWITANSI
    public function cetak($id)
    {
        $pembayaran = Pembayaran::with('siswa')->findOrFail($id);
        return view('pembayaran.cetak', compact('pembayaran'));
    }

    // DOWNLOAD EXCEL PEMBAYARAN
    public function export(Request $request)
    {
        // Nama file: Laporan_Pembayaran_Januari_2026.xlsx (Contoh)
        $nama_file = 'Laporan_Pembayaran_' . date('Y-m-d_H-i') . '.xlsx';
        return Excel::download(new PembayaranExport($request), $nama_file);
    }
}