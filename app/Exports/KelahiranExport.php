<?php

namespace App\Exports;

use App\Models\Kelahiran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class KelahiranExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithCustomValueBinder
{
    protected $user;
    protected $q;

    public function __construct($user, $q = null)
    {
        $this->user = $user;
        $this->q    = $q;
    }

    public function collection()
    {
        $query = Kelahiran::with(['penduduk', 'kkTujuan']);

        // 🔐 ROLE (samain dengan index)
        if ($this->user->role !== 'superadmin') {
            $query->whereHas('penduduk', function ($p) {
                $p->where('banjar_id', $this->user->banjar_id);
            });
        }

        // 🔍 SEARCH (nama / NIK bayi)
        if ($this->q) {
            $query->whereHas('penduduk', function ($p) {
                $p->where('nama', 'like', "%{$this->q}%")
                  ->orWhere('nik', 'like', "%{$this->q}%");
            });
        }

        return $query->get()->map(function ($k) {
            return [
                $k->penduduk->nama ?? '-',                            // A
                $k->penduduk->nik ?? '-',                             // B (TEXT)
                $k->penduduk->jenis_kelamin ?? '-',                  // C
                optional($k->tanggal_lahir)
                    ? date('Y-m-d', strtotime($k->tanggal_lahir))
                    : '-',                                           // D (DATE)
                $k->kkTujuan->nomor_kk ?? '-',                        // E (TEXT)
                $k->keterangan ?? '-',                                // F
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama',
            'NIK',
            'Jenis Kelamin',
            'Tanggal Lahir',
            'No KK',
            'Keterangan',
        ];
    }

    /**
     * 🔑 Paksa kolom tertentu jadi STRING (anti E+14 / 0)
     */
    public function bindValue(Cell $cell, $value)
    {
        // Kolom B = NIK, Kolom E = No KK
        if (in_array($cell->getColumn(), ['B', 'E'])) {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
