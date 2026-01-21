<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Exports\PembayaranExport;
use Maatwebsite\Excel\Facades\Excel;

class PembayaranController extends Controller
{
    // ... (Code index tetap sama, tidak perlu diubah) ...
    public function index(Request $request)
    {
        $query = Pembayaran::select('pembayarans.*')->with('siswa');

        if ($request->sort == 'nama_az' || $request->sort == 'kelas_az') {
            $query->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id');
        }

        if ($request->has('bulan') && $request->bulan != '') {
            $query->whereMonth('tanggal_bayar', $request->bulan);
        }
        if ($request->has('tahun') && $request->tahun != '') {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }

        switch ($request->sort) {
            case 'nama_az': $query->orderBy('siswas.nama', 'asc'); break;
            case 'kelas_az': $query->orderBy('siswas.kelas', 'asc'); break;
            case 'tanggal_terlama': $query->orderBy('tanggal_bayar', 'asc'); break;
            case 'tanggal_terbaru': $query->orderBy('tanggal_bayar', 'desc'); break;
            case 'input_terbaru':
            default: $query->latest(); break;
        }

        $pembayarans = $query->paginate(10); 
        $total_pemasukan = $query->clone()->sum('jumlah_bayar');

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