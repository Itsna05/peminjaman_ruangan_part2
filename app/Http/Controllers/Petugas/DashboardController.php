<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan & tahun dari URL
        $month = (int) $request->get('month', now()->month);
        $year  = (int) $request->get('year', now()->year);

        // Validasi
        if ($month < 1 || $month > 12) {
            $month = now()->month;
        }

        // Tanggal acuan kalender
        $currentDate = Carbon::createFromDate($year, $month, 1);

        // =============================
        // EVENT BULAN INI (kalender + running text)
        // =============================
        $eventsMonth = Transaksi::with(['bidang', 'ruangan'])
            ->whereYear('waktu_mulai', $year)
            ->whereMonth('waktu_mulai', $month)
            ->orderBy('waktu_mulai')
            ->get();

        // =============================
        // EVENT HARI INI (panel kanan)
        // =============================
        $eventsToday = Transaksi::with(['bidang', 'ruangan'])
            ->whereDate('waktu_mulai', Carbon::today())
            ->orderBy('waktu_mulai')
            ->get();

        return view('petugas.dashboard', compact(
            'currentDate',
            'eventsMonth',
            'eventsToday'
        ));
    }

    public function detail($id)
    {
        $event = Transaksi::with(['bidang', 'ruangan'])
            ->findOrFail($id);

        return response()->json([
            'acara'          => $event->acara,
            'jumlah_peserta' => $event->jumlah_peserta,
            'waktu_mulai'    => $event->waktu_mulai->format('H:i'),
            'waktu_selesai'  => $event->waktu_selesai->format('H:i'),
            'bidang'         => $event->bidang->bidang ?? '-',
            'sub_bidang'     => $event->bidang->sub_bidang ?? '-',
            'ruangan'        => $event->ruangan->nama_ruangan ?? '-',
            'no_wa'          => $event->no_wa ?? '-',
            'catatan'        => $event->catatan ?? '-',
        ]);
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['bidang', 'ruangan'])
            ->findOrFail($id);

        return response()->json($transaksi);
    }

}
