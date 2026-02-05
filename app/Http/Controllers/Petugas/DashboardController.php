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
            ->whereIn('status_peminjaman', ['menunggu', 'disetujui'])
            ->orderBy('waktu_mulai')
            ->get();


        // =============================
        // EVENT HARI INI (panel kanan)
        // =============================
        $eventsToday = Transaksi::with(['bidang', 'ruangan'])
            ->whereDate('waktu_mulai', Carbon::today())
            ->whereIn('status_peminjaman', ['menunggu', 'disetujui'])
            ->orderBy('waktu_mulai')
            ->get();


        $eventsForJs = $eventsMonth->mapWithKeys(function ($e) {
            return [
                $e->id_peminjaman => [
                    'acara' => $e->acara,
                    'jumlah_peserta' => $e->jumlah_peserta,
                    'waktu_mulai' => $e->waktu_mulai->format('H:i'),
                    'waktu_selesai' => $e->waktu_selesai->format('H:i'),
                    'bidang' => $e->bidang->bidang ?? '-',
                    'sub_bidang' => $e->bidang->sub_bidang ?? '-',
                    'ruangan' => $e->ruangan->nama_ruangan ?? '-',
                    'catatan' => $e->catatan ?? '-',
                    'status' => $e->status_peminjaman ?? '-',
                ]
            ];
        });

        return view('petugas.dashboard', compact(
            'currentDate',
            'eventsMonth',
            'eventsToday',
            'eventsForJs' 
        ));
    }

    public function detail($id)
    {
        $event = Transaksi::with(['bidang', 'ruangan'])
            ->where('id_peminjaman', $id)
            ->whereIn('status_peminjaman', ['menunggu', 'disetujui'])
            ->first();

        if (!$event) {
            return response()->json([
                'message' => 'Detail peminjaman tidak tersedia'
            ], 403);
        }

        return response()->json([
            'acara'              => $event->acara,
            'jumlah_peserta'     => $event->jumlah_peserta,
            'waktu_mulai'        => $event->waktu_mulai->format('H:i'),
            'waktu_selesai'      => $event->waktu_selesai->format('H:i'),
            'bidang'             => $event->bidang->bidang ?? '-',
            'sub_bidang'         => $event->bidang->sub_bidang ?? '-',
            'ruangan'            => $event->ruangan->nama_ruangan ?? '-',
            'no_wa'              => $event->no_wa ?? '-',
            'catatan'            => $event->catatan ?? '-',
            'status_peminjaman'  => $event->status_peminjaman,
        ]);
    }


    public function show($id)
    {
        $transaksi = Transaksi::with(['bidang', 'ruangan'])
            ->where('id_peminjaman', $id)
            ->whereIn('status_peminjaman', ['menunggu', 'disetujui'])
            ->first();

        if (!$transaksi) {
            return response()->json([
                'message' => 'Detail peminjaman tidak tersedia'
            ], 403);
        }

        return response()->json($transaksi);
    }

}
