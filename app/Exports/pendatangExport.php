<?php

namespace App\Exports;

use App\Models\Pendatang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class PendatangExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithCustomValueBinder
{
    public function collection()
    {
        return Pendatang::with(['penduduk', 'kkTujuan'])
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($p) {

                $penduduk = $p->penduduk;

                return [
                    $penduduk?->nama ?? '-',              // A
                    $penduduk?->nik ?? '-',               // B (TEXT)
                    $p->asal ?? '-',                      // C
                    $p->kkTujuan?->nomor_kk ?? '-',       // D (TEXT)
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'Asal',
            'KK Tujuan',
        ];
    }

    /**
     * Paksa NIK & No KK sebagai STRING
     */
    public function bindValue(Cell $cell, $value)
    {
        // Kolom B = NIK, Kolom D = No KK
        if (in_array($cell->getColumn(), ['B', 'D'])) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
