<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class DataExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithCustomValueBinder
{

    public function exportExcel()
{
    dd('EXPORT KEPIANGGIL');
    return Excel::download(new DataExport, 'data_penduduk.xlsx');
}

    public function collection()
    {
        return Penduduk::with(['banjar', 'kk'])->get()->map(function ($p) {
            return [
                $p->nama,                               // A
                $p->nik,                                // B (TEXT)
                $p->kk->nomor_kk ?? '-',                   // C (TEXT)
                $p->jenis_kelamin,                      // D
                optional($p->tanggal_lahir)
                    ? date('Y-m-d', strtotime($p->tanggal_lahir))
                    : '-',                               // E (DATE string)
                $p->alamat,                             // F
                $p->banjar->nama ?? '-',                // G
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'No KK',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'Alamat',
            'Banjar',
        ];
    }

    /**
     * 🔑 Paksa NIK & No KK sebagai STRING sejak awal
     */
    public function bindValue(Cell $cell, $value)
    {
        // Kolom B = NIK, Kolom C = No KK
        if (in_array($cell->getColumn(), ['B', 'C'])) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
    
}
