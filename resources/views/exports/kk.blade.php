<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor KK</th>
            <th>Jumlah Anggota</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($kk as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $item->nomor_kk }}</td>
            <td>{{ $item->penduduk->count() }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
