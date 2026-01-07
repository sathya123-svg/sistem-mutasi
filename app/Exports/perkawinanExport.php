<?php

namespace App\Exports;

use App\Models\Perkawinan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class PerkawinanExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithCustomValueBinder
{
    public function collection()
    {
        return Perkawinan::with([
            'penduduk',
            'kkTujuan'
        ])
        ->orderBy('tanggal', 'desc')
        ->get()
        ->map(function ($p) {

            $penduduk = $p->penduduk;

            return [
                $penduduk?->nama ?? '-',                       // A
                $penduduk?->nik ?? '-',                        // B (TEXT)
                $penduduk?->jenis_kelamin ?? '-',             // C
                ucfirst($p->tipe),                             // D (Masuk / Keluar)
                $p->tanggal
                    ? date('Y-m-d', strtotime($p->tanggal))
                    : '-',                                    // E
                $p->kkTujuan?->nomor_kk ?? '-',                // F (KK Tujuan)
                $p->keterangan ?? '-',                         // G
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'Jenis Kelamin',
            'Tipe Perkawinan',
            'Tanggal',
            'No KK Tujuan',
            'Keterangan',
        ];
    }

    /**
     * Paksa kolom NIK & No KK sebagai STRING (anti E+14)
     */
    public function bindValue(Cell $cell, $value)
    {
        // Kolom B = NIK, Kolom F = No KK
        if (in_array($cell->getColumn(), ['B', 'F'])) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
