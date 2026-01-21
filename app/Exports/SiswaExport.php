<?php

namespace App\Exports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SiswaExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    // AMBIL SEMUA DATA SISWA
    public function collection()
    {
        return Siswa::orderBy('kelas', 'asc')->orderBy('nama', 'asc')->get();
    }

    public function headings(): array
    {
        return ['Nama Lengkap', 'Jenjang', 'Asal Sekolah', 'Kelas', 'Terdaftar Pada'];
    }

    public function map($siswa): array
    {
        return [
            $siswa->nama,
            $siswa->tingkatan,
            $siswa->asal_sekolah ?? '-',
            $siswa->kelas,
            $siswa->created_at->format('d F Y'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}