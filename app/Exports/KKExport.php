<?php

namespace App\Exports;

use App\Models\KK;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class KKExport extends DefaultValueBinder implements
    FromCollection,
    WithHeadings,
    WithCustomValueBinder
{
    protected $user;
    protected $search;

    public function __construct($user, $search = null)
    {
        $this->user   = $user;
        $this->search = $search;
    }

    public function collection()
    {
        $query = KK::with(['penduduk', 'banjar']);

        // 🔐 ROLE FILTER
        if ($this->user->role !== 'superadmin') {
            $query->where('banjar_id', $this->user->banjar_id);
        }

        // 🔍 SEARCH (nomor KK / nama anggota)
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nomor_kk', 'like', "%{$this->search}%")
                  ->orWhereHas('penduduk', function ($p) {
                      $p->where('nama', 'like', "%{$this->search}%");
                  });
            });
        }

        return $query->orderBy('nomor_kk')->get()->map(function ($kk) {
            return [
                $kk->nomor_kk,                      // A (STRING)
                $kk->penduduk->first()->nama ?? '-',// B (nama anggota pertama)
                $kk->penduduk->count(),             // C
                $kk->banjar->nama ?? '-',            // D
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nomor KK',
            'Nama Anggota (Pertama)',
            'Jumlah Anggota',
            'Banjar',
        ];
    }

    /**
     * 🔑 Paksa No KK sebagai STRING
     */
    public function bindValue(Cell $cell, $value)
    {
        // Kolom A = Nomor KK
        if ($cell->getColumn() === 'A') {
            $cell->setValueExplicit((string) $value, DataType::TYPE_STRING);
            return true;
        }

        return parent::bindValue($cell, $value);
    }
}
