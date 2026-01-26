<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Siswa([
            'nama'         => $row['nama'],
            'tingkatan'    => $row['tingkatan'],
            'kelas'        => $row['kelas'],
            'asal_sekolah' => $row['asal_sekolah'],
            'no_hp'        => $row['no_hp'],
        ]);
    }
}