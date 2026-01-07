<?php

namespace App\Exports;

use App\Models\Kematian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class KematianExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithCustomValueBinder
{
    public function collection()
    {
        return Kematian::orderBy('tanggal_kematian', 'desc')->get()->map(function ($k) {
            return [
                $k->nama ?? '-',                              // A
                $k->nik ?? '-',                               // B (TEXT)
                '-',                                          // C (Jenis Kelamin - tidak disimpan)
                $k->tanggal_kematian
                    ? date('Y-m-d', strtotime($k->tanggal_kematian))
                    : '-',                                   // D
                $k->no_kk ?? '-',                             // E (TEXT)
                '-',                                          // F (Sebab Kematian - belum ada)
                '-',                                          // G (Keterangan - belum ada)
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'Jenis Kelamin',
            'Tanggal Kematian',
            'No KK',
            'Sebab Kematian',
            'Keterangan',
        ];
    }

    /**
     * Paksa kolom NIK & No KK sebagai STRING
     */
    public function bindValue(Cell $cell, $value)
    {
        if (in_array($cell->getColumn(), ['B', 'E'])) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}


