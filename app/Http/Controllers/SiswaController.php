<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    // tampilan
public function index(Request $request)
{
    $query = Siswa::query();

    // Filter Tingkatan (sudah ada)
    if ($request->has('tingkatan') && $request->tingkatan != null) {
        $query->where('tingkatan', $request->tingkatan);
    }

    // Filter Pencarian (sudah ada)
    if ($request->has('cari')) {
        $query->where('nama', 'like', '%' . $request->cari . '%');
    }

    // --- LOGIKA SORTING BARU ---
    if ($request->has('sort')) {
        switch ($request->sort) {
            case 'nama_az':
                $query->orderBy('nama', 'asc'); break;
            case 'nama_za':
                $query->orderBy('nama', 'desc'); break;
            case 'kelas_az':
                $query->orderBy('kelas', 'asc'); break;
            // Ini logika jenjang custom (manual karena string)
            case 'jenjang_asc':
                // Urutan manual: TK, SD, SMP, SMA
                $query->orderByRaw("FIELD(tingkatan, 'TK', 'SD', 'SMP', 'SMA', 'Alumni')"); break;
            case 'jenjang_desc':
                $query->orderByRaw("FIELD(tingkatan, 'Alumni', 'SMA', 'SMP', 'SD', 'TK')"); break;
            default: // terbaru
                $query->latest(); break;
        }
    } else {
        $query->latest();
    }

    $siswas = $query->get();
    return view('siswa.index', compact('siswas'));
}

    // 2. HALAMAN TAMBAH
    public function create()
    {
        return view('siswa.create');
    }

    // 3. PROSES SIMPAN
    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'tingkatan' => 'required',
        'kelas' => 'required',
        'asal_sekolah' => 'nullable|string',
        'no_hp' => 'nullable|numeric|digits_between:10,15', // Validasi angka 10-15 digit
    ]);

    Siswa::create($request->all());

    return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
}

    // 4. HALAMAN EDIT
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    // 5. PROSES UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tingkatan' => 'required|string',
            'asal_sekolah' => 'nullable|string|max:255',
            'kelas' => 'required|string|max:50',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus!');
    }

    // 7. HALAMAN REKAP (JUMLAH SISWA)
    public function rekap(Request $request)
    {
        $total_tk = Siswa::where('tingkatan', 'TK')->count();
        $total_sd = Siswa::where('tingkatan', 'SD')->count();
        $total_smp = Siswa::where('tingkatan', 'SMP')->count();
        $total_sma = Siswa::where('tingkatan', 'SMA')->count();
        $total_semua = Siswa::count();

        $query = Siswa::select('asal_sekolah', 'kelas', 'tingkatan', DB::raw('count(*) as total'))
                      ->groupBy('asal_sekolah', 'kelas', 'tingkatan');

        // LOGIKA SEARCH BAR
        if ($request->has('cari') && $request->cari != '') {
            $keyword = $request->cari;
            $query->where(function($q) use ($keyword) {
                $q->where('asal_sekolah', 'like', '%' . $keyword . '%')
                  ->orWhere('kelas', 'like', '%' . $keyword . '%');
            });
        }

        $query->orderByRaw("FIELD(tingkatan, 'TK', 'SD', 'SMP', 'SMA')");
        
        $query->orderBy('asal_sekolah', 'asc'); 
        $query->orderBy('kelas', 'asc');

        $data_rekap = $query->get();

        return view('siswa.recap', compact('total_tk', 'total_sd', 'total_smp', 'total_sma', 'total_semua', 'data_rekap'));
    }
    // 8. DETAIL REKAP
    public function rekapDetail(Request $request)
{
    $sekolah = $request->query('sekolah'); 
    $kelas = $request->query('kelas');

    $query = Siswa::where('kelas', $kelas)->latest();

    if ($sekolah == 'Tidak Diketahui' || $sekolah == '') {
        $query->whereNull('asal_sekolah')->orWhere('asal_sekolah', '');
    } else {
        $query->where('asal_sekolah', $sekolah);
    }

    $siswas = $query->get();

    return view('siswa.recap_detail', compact('siswas', 'sekolah', 'kelas'));
}

    // 9. SHOW (Opsional, untuk tombol mata biru)
    public function show(string $id)
{
    $siswa = Siswa::findOrFail($id);

    return view('siswa.show', compact('siswa'));
}

    // 10. EXPORT EXCEL (INI YANG TADI ERROR / HILANG)
    public function export()
    {
        return Excel::download(new SiswaExport, 'Data_Seluruh_Siswa.xlsx');
    }
}