<?php

namespace App\Imports;

use App\Models\Penduduk;
use App\Models\Banjar;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class PendudukImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Cari banjar_id berdasarkan nama banjar di Excel (case-insensitive)
        $banjar = Banjar::whereRaw('LOWER(nama) = ?', [strtolower($row['banjar_id'])])->first();

        return Penduduk::updateOrCreate([
            'nik'           => $row['nik'],
            'nama'          => $row['nama'],
            'jenis_kelamin' => $row['jenis_kelamin']=== 'laki-laki' ? 'L' : 'P',
            'tanggal_lahir' => is_numeric($row['tanggal_lahir'])
                                ? Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d')
                                : Carbon::parse($row['tanggal_lahir'])->format('Y-m-d'),
            'agama'         => $row['agama'] ?? null, // kalau belum ada bisa null
            'alamat'        => $row['alamat'],
            'banjar_id'     => $banjar ? $banjar->id : null, // auto konversi nama jadi ID
        ]);
    }
}

// namespace App\Imports;

// use App\Models\Penduduk;
// use Maatwebsite\Excel\Concerns\ToModel;
// use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use PhpOffice\PhpSpreadsheet\Shared\Date;
// use Carbon\Carbon;
// class PendudukImport implements ToModel,WithHeadingRow
// {
//     /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//     public function model(array $row)
//     {
//         return new Penduduk([
//             'nama'               => $row['nama'],
//             'nik'                => $row['nik'],
//             'alamat'             => $row['alamat'],
//             'jenis_kelamin'      => $row['jenis_kelamin'] === 'Laki-laki' ? 'L' : 'P',
//              'tanggal_lahir' => is_numeric($row['tanggal_lahir'])
//                                 ? Date::excelToDateTimeObject($row['tanggal_lahir'])->format('Y-m-d')
//                                 : Carbon::parse($row['tanggal_lahir'])->format('Y-m-d'),,
//             'agama' => $row['agama'],
//             // 'status_perkawinan' => $row['status_perkawinan'],
//             // 'pekerjaan' => $row['pekerjaan'],
//             'banjar_id'           => $row['banjar_id'], 
//         ]);
//     }
// }
