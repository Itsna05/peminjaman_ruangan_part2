<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h3>Riwayat Peminjaman Ruangan</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Ruangan</th>
            <th>Acara</th>
            <th>Waktu</th>
            <th>Bidang</th>
            <th>No WA</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                <td>{{ $item->acara }}</td>
                <td>
                    {{ $item->waktu_mulai->format('d F Y') }} <br>
                    {{ $item->waktu_mulai->format('H:i') }} - {{ $item->waktu_selesai->format('H:i') }}
                </td>
                <td>
                    {{ $item->bidang->bidang ?? '-' }} <br>
                    <small>{{ $item->bidang->sub_bidang ?? '' }}</small>
                </td>
                <td>{{ $item->no_wa }}</td>
                <td>{{ $item->status_peminjaman }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
