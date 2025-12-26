<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Data Penduduk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
    </style>
</head>
<body>
    <h2>Data Penduduk</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIK</th>
                <th>Banjar</th>
                <!-- Tambah kolom lain jika perlu -->
            </tr>
        </thead>
        <tbody>
            @foreach ($penduduk as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nik }}</td>
                    <td>{{ $item->banjar }}</td>
                    <!-- Tambah data lainnya -->
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
