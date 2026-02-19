<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonitorController extends Controller
{
    public function index()
    {
        /* ======================
           JADWAL HARI INI
        ====================== */

        $hariIni = DB::table('transaksi')
            ->join('ruangan', 'transaksi.id_ruangan', '=', 'ruangan.id_ruangan')
            ->join('bidang_pegawai', 'transaksi.id_bidang', '=', 'bidang_pegawai.id_bidang')

            ->whereDate('waktu_mulai', Carbon::today())
            ->whereRaw('LOWER(status_peminjaman) = "disetujui"')

            ->select(
                'transaksi.*',
                'ruangan.nama_ruangan',
                'bidang_pegawai.bidang'
            )
            ->orderBy('waktu_mulai')
            ->get();


        /* ======================
           JADWAL MENDATANG
        ====================== */

        $mendatang = DB::table('transaksi')
            ->join('ruangan', 'transaksi.id_ruangan', '=', 'ruangan.id_ruangan')
            ->join('bidang_pegawai', 'transaksi.id_bidang', '=', 'bidang_pegawai.id_bidang')

            ->whereDate('waktu_mulai', '>', Carbon::today())
            ->whereRaw('LOWER(status_peminjaman) = "disetujui"')

            ->select(
                'transaksi.*',
                'ruangan.nama_ruangan',
                'bidang_pegawai.bidang'
            )
            ->orderBy('waktu_mulai')
            ->limit(20)
            ->get();


        /* ======================
           GALERI KEGIATAN
        ====================== */

        $galeri = DB::table('transaksi')
            ->join('ruangan', 'transaksi.id_ruangan', '=', 'ruangan.id_ruangan')

            ->whereNotNull('foto_kegiatan')
            ->where('foto_kegiatan', '!=', '')
            ->whereRaw('LOWER(status_peminjaman) = "disetujui"')

            ->select(
                'transaksi.foto_kegiatan',
                'ruangan.nama_ruangan',
                'transaksi.acara'
            )

            ->orderByDesc('waktu_mulai')
            ->limit(15)
            ->get();


        return view('monitor.landingpage', compact(
            'hariIni',
            'mendatang',
            'galeri'
        ));
    }
}
