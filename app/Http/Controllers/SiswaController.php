<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Imports\SiswaImport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Exports\SiswaExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
// 1. CRUD: READ
    public function index(Request $request)
    {
        $query = Siswa::query();

        // Filter Tingkatan
        $query->when($request->filled('tingkatan'), function ($q) use ($request) {
            return $q->where('tingkatan', $request->tingkatan);
        });

        // Filter Pencarian (Nama / Sekolah)
        $query->when($request->filled('cari'), function ($q) use ($request) {
            return $q->where('nama', 'like', '%' . $request->cari . '%')
                     ->orWhere('asal_sekolah', 'like', '%' . $request->cari . '%');
        });

        // Logika Sorting
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'nama_az':
                    $query->orderBy('nama', 'asc'); break;
                case 'nama_za':
                    $query->orderBy('nama', 'desc'); break;
                case 'kelas_az':
                    $query->orderBy('kelas', 'asc'); break;
                case 'jenjang_asc':
                    $query->orderByRaw("FIELD(tingkatan, 'TK', 'SD', 'SMP', 'SMA', 'Alumni')"); break;
                case 'jenjang_desc':
                    $query->orderByRaw("FIELD(tingkatan, 'Alumni', 'SMA', 'SMP', 'SD', 'TK')"); break;
                default:
                    $query->latest(); break;
            }
        } else {
            $query->latest();
        }

        $siswas = $query->paginate(10)->withQueryString();

        return view('siswa.index', compact('siswas'));
    }

    // 2. CRUD: CREATE
    public function create()
    {
        return view('siswa.create');
    }

    // 3. CRUD: STORE
    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'tingkatan'    => 'required',
            'kelas'        => 'required',
            'asal_sekolah' => 'nullable|string',
            'no_hp'        => 'nullable|numeric|digits_between:10,15',
        ]);

        Siswa::create($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    // 4. CRUD: EDIT
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'));
    }

    // 5. CRUD: UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'         => 'required|string|max:255',
            'tingkatan'    => 'required|string',
            'asal_sekolah' => 'nullable|string|max:255',
            'kelas'        => 'required|string|max:50',
        ]);

        $siswa = Siswa::findOrFail($id);
        $siswa->update($request->all());

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
    }

    // 6. CRUD: DELETE
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus!');
    }

    // 7. CRUD: SHOW
    public function show(string $id)
    {
        $siswa = Siswa::findOrFail($id);
        return view('siswa.show', compact('siswa'));
    }

    // ==========================================================
    // BAGIAN REKAPITULASI (HIERARKI)
    // ==========================================================

   // 1. LEVEL 1: REKAPITULASI SELURUH SEKOLAH
    public function rekap(Request $request)
    {
        $stats = Siswa::selectRaw("
            count(*) as total,
            count(case when tingkatan = 'TK' then 1 end) as tk,
            count(case when tingkatan = 'SD' then 1 end) as sd,
            count(case when tingkatan = 'SMP' then 1 end) as smp,
            count(case when tingkatan = 'SMA' then 1 end) as sma
        ")->first();

        $total_tk = $stats->tk;
        $total_sd = $stats->sd;
        $total_smp = $stats->smp;
        $total_sma = $stats->sma;
        $total_semua = $stats->total;

        $query = Siswa::select('asal_sekolah', DB::raw('count(*) as total'))
                      ->groupBy('asal_sekolah');

        if ($request->filled('cari')) {
            $query->where('asal_sekolah', 'like', '%' . $request->cari . '%');
        }

        $data_rekap = $query->orderBy('total', 'desc')->get();

        return view('siswa.recap', compact(
            'total_tk', 'total_sd', 'total_smp', 'total_sma', 'total_semua', 'data_rekap'
        ));
    }

   // 2. LEVEL 2: REKAPITULASI PER SEKOLAH
    public function rekapSchool($sekolah)
    {
        $nama_sekolah = urldecode($sekolah);

        $data_kelas = Siswa::where('asal_sekolah', $nama_sekolah)
                           ->select('kelas', 'tingkatan', DB::raw('count(*) as total'))
                           ->groupBy('kelas', 'tingkatan')
                           ->orderBy('kelas', 'asc')
                           ->get();

        return view('siswa.rekap_school', compact('data_kelas', 'nama_sekolah'));
    }

    // 3. LEVEL 3: REKAPITULASI PER KELAS DI SEKOLAH TERPILIH
    public function rekapDetail($sekolah, $kelas)
    {
        $nama_sekolah = urldecode($sekolah);
        $nama_kelas = urldecode($kelas);

        $siswas = Siswa::where('asal_sekolah', $nama_sekolah)
                       ->where('kelas', $nama_kelas)
                       ->orderBy('nama', 'asc')
                       ->get();

        return view('siswa.recap_detail', [
            'siswas' => $siswas,
            'sekolah' => $nama_sekolah,
            'kelas' => $nama_kelas
        ]);
    }

    // ==========================================================
    // BAGIAN IMPORT & EXPORT EXCEL
    // 8. EXPORT EXCEL
    public function export()
    {
        return Excel::download(new SiswaExport, 'Data_Seluruh_Siswa.xlsx');
    }

    // 9. IMPORT EXCEL
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import data. Pastikan format Excel sesuai template.');
        }
    }
}