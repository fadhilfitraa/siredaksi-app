<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Exports\PembayaranExport;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::with('siswa');

        // 1. Filter Pencarian Bulan
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }

        // 2. Filter Pencarian Tahun
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }

        // 3. LOGIKA BARU: Filter Rentang Tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            // Jika user isi Tanggal Awal DAN Akhir (Misal: 1 Jan - 5 Jan)
            $query->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
        } elseif ($request->filled('start_date')) {
            // Jika user CUMA isi Tanggal Awal (Misal: 20 Jan), otomatis cari HANYA tanggal itu
            $query->whereDate('tanggal_bayar', $request->start_date);
        }

        // 4. Logika Sorting (Sama seperti sebelumnya)
        if ($request->sort == 'tanggal_terbaru') {
            $query->orderBy('tanggal_bayar', 'desc');
        } elseif ($request->sort == 'tanggal_terlama') {
            $query->orderBy('tanggal_bayar', 'asc');
        } elseif ($request->sort == 'nama_az') {
            $query->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
                  ->orderBy('siswas.nama', 'asc')
                  ->select('pembayarans.*'); 
        } else {
            $query->latest(); // Default input terbaru
        }

        $pembayarans = $query->paginate(10);
        
        // Hitung total pemasukan berdasarkan filter yang aktif
        $total_pemasukan = $query->sum('jumlah_bayar');

        return view('pembayaran.index', compact('pembayarans', 'total_pemasukan'));
    }

    // 2. PERBAIKAN DI SINI (Ubah $siswa jadi $siswas)
    public function create()
    {
        // Gunakan $siswas (jamak) agar sesuai dengan View
        $siswas = Siswa::orderBy('nama', 'asc')->get(); 
        return view('pembayaran.create', compact('siswas'));
    }

    // 3. STORE (Tetap sama)
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_bayar' => 'required|date',
            'bulan_bayar' => 'required|string',
            'jumlah_bayar' => 'required|numeric|min:1000',
            'metode_pembayaran' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        Pembayaran::create([
            'siswa_id' => $request->siswa_id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'bulan_bayar' => $request->bulan_bayar,
            'jumlah_bayar' => $request->jumlah_bayar,
            'metode_pembayaran' => $request->metode_pembayaran,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil disimpan!');
    }

    // 4. PERBAIKAN DI SINI JUGA (Ubah $siswa jadi $siswas)
    public function edit($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        // Gunakan $siswas (jamak)
        $siswas = Siswa::orderBy('nama', 'asc')->get();
        return view('pembayaran.edit', compact('pembayaran', 'siswas'));
    }

    // ... (Sisa function update, destroy, cetak, export tetap sama) ...
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_bayar' => 'required|date',
            'bulan_bayar' => 'required|string',
            'jumlah_bayar' => 'required|numeric',
            'metode_pembayaran' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update($request->all());

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran berhasil dihapus!');
    }

    public function cetak($id)
    {
        $pembayaran = Pembayaran::with('siswa')->findOrFail($id);
        $terbilang = $this->penyebut($pembayaran->jumlah_bayar);
        return view('pembayaran.cetak', compact('pembayaran', 'terbilang'));
    }

    public function export(Request $request)
    {
        return Excel::download(new PembayaranExport($request->bulan, $request->tahun), 'laporan_pembayaran.xlsx');
    }

    public function penyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->penyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai/10)." puluh". $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai/100) . " ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai/1000) . " ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai/1000000) . " juta" . $this->penyebut($nilai % 1000000);
        }
        return $temp;
    }
}