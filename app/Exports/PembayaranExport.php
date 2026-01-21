<?php

namespace App\Exports;

use App\Models\Pembayaran;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Http\Request;

class PembayaranExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    // 1. QUERY DATA (Sama persis dengan logika di Controller)
    public function query()
    {
        $query = Pembayaran::query()->with('siswa'); // Pakai query() bukan select()

        // Filter Bulan
        if ($this->request->has('bulan') && $this->request->bulan != '') {
            $query->whereMonth('tanggal_bayar', $this->request->bulan);
        }

        // Filter Tahun
        if ($this->request->has('tahun') && $this->request->tahun != '') {
            $query->whereYear('tanggal_bayar', $this->request->tahun);
        }

        // Sorting
        $sort = $this->request->sort;
        if ($sort == 'nama_az' || $sort == 'kelas_az') {
            $query->join('siswas', 'pembayarans.siswa_id', '=', 'siswas.id')
                  ->select('pembayarans.*'); // Ambil kolom pembayaran saja biar ID gak bentrok
            
            if ($sort == 'nama_az') $query->orderBy('siswas.nama', 'asc');
            if ($sort == 'kelas_az') $query->orderBy('siswas.kelas', 'asc');
        } elseif ($sort == 'tanggal_terlama') {
            $query->orderBy('tanggal_bayar', 'asc');
        } else {
            $query->orderBy('tanggal_bayar', 'desc');
        }

        return $query;
    }

    // 2. JUDUL KOLOM DI EXCEL
    public function headings(): array
    {
        return [
            'No Kwitansi',
            'Nama Siswa',
            'Asal Sekolah',
            'Kelas',
            'Tanggal Bayar',
            'Jumlah (Rp)',
            'Waktu Input',
        ];
    }

    // 3. ISI DATA PER BARIS
    public function map($pembayaran): array
    {
        return [
            '#' . str_pad($pembayaran->id, 4, '0', STR_PAD_LEFT),
            $pembayaran->siswa->nama ?? 'Siswa Dihapus',
            $pembayaran->siswa->asal_sekolah ?? '-',
            $pembayaran->siswa->kelas ?? '-',
            \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('d F Y'),
            $pembayaran->jumlah_bayar,
            $pembayaran->created_at->format('d/m/Y H:i'),
        ];
    }

    // 4. STYLE (Bikin Header Tebal)
    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}