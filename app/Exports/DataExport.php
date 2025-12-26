<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DataExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Penduduk::select('nama', 'nik', 'alamat', 'banjar')->get();
    }

    public function headings(): array
    {
        return ['Nama', 'NIK', 'Alamat', 'Banjar'];
    }
}
