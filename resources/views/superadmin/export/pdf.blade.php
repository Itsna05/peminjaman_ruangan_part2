    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <style>
            body {
                font-family: DejaVu Sans, sans-serif;
                font-size: 12px;
                margin: 40px;
            }

            .kop {
                position: relative;
                border-bottom: 3px solid #000;
                padding-bottom: 12px;
                margin-bottom: 24px;
            }

            .kop img {
                position: absolute;
                left: 0;
                top: 0;
                width: 90px;
            }

            .kop-text {
                text-align: center;
            }

            .kop-text h2 {
                margin: 0;
                font-size: 18px;
                font-weight: bold;
            }

            .kop-text h3 {
                margin: 2px 0;
                font-size: 16px;
                font-weight: bold;
            }

            .kop-text p {
                margin: 4px 0 0;
                font-size: 11px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 15px;
            }

            th, td {
                border: 1px solid #000;
                padding: 6px;
                font-size: 11px;
            }

            th {
                background: #f2f2f2;
                text-align: center;
            }
        </style>
    </head>
    <body>

        {{-- KOP DPUPR --}}
        <table width="100%" cellspacing="0" cellpadding="0"
            style="border-collapse:collapse; border:none; margin-bottom:20px;">
            <tr>
                <td width="15%"
                    style="border:none; text-align:center; vertical-align:middle; padding:10px;">
                    <img src="{{ public_path('img/logo_jateng.png') }}" width="90">
                </td>

                <td width="85%"
                    style="border:none; text-align:center; padding:10px;">
                    <h2 style="
                        margin:0;
                        font-size:16px;
                        font-weight:bold;
                        letter-spacing:0.5px;
                    ">
                        DINAS PEKERJAAN UMUM DAN PENATAAN RUANG
                    </h2>

                    <h3 style="margin:4px 0; font-size:16px; font-weight:bold;">
                        PROVINSI JAWA TENGAH
                    </h3>
                    <p style="margin:4px 0; font-size:11px;">
                        Jl. Madukoro Blok AA–BB, Tawangsari, Kec. Semarang Barat,<br>
                        Kota Semarang, Provinsi Jawa Tengah, Kode Pos 50144
                    </p>
                </td>
            </tr>
        </table>

    {{-- GARIS BAWAH KOP --}}
    <hr style="border:0; border-top:3px solid #000; margin:0 0 20px 0;">



        <h4 style="text-align:center; margin-bottom:10px;">
            LAPORAN PEMINJAMAN RUANGAN
        </h4>

        @php
use Carbon\Carbon;

$periode = 'Semua Data';

if ($tahun && $bulan) {
    $periode = Carbon::createFromDate($tahun, $bulan, 1)
                ->translatedFormat('F Y');
} elseif ($tahun) {
    $periode = 'Tahun ' . $tahun;
}

$statusText = $status ? ucfirst($status) : 'Semua Status';
@endphp

<p>
    Total Peminjaman : {{ $transaksi->count() }} <br>
    Periode          : {{ $periode }} <br>
    Status           : {{ $statusText }} <br>
    Tanggal Cetak    : {{ now()->translatedFormat('d F Y, H:i') }} WIB
</p>


        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Ruangan</th>
                    <th>Acara</th>
                    <th>Waktu</th>
                    <th>Bidang</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($transaksi as $i => $item)
                <tr>
                    <td align="center">{{ $i + 1 }}</td>
                    <td>{{ $item->ruangan->nama_ruangan ?? '-' }}</td>
                    <td>{{ $item->acara }}</td>
                    <td>
                        {{ $item->waktu_mulai->format('d-m-Y H:i') }} –
                        {{ $item->waktu_selesai->format('H:i') }}
                    </td>
                    <td>{{ $item->bidang->bidang ?? '-' }}</td>
                    <td align="center">{{ ucfirst($item->status_peminjaman) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </body>
    </html>
