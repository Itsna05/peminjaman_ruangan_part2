<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonitorController extends Controller
{
public function index()
{
    $today = Carbon::today();

    /* ======================
       JADWAL HARI INI
    ====================== */
    $hariIni = DB::table('transaksi')
    ->join('ruangan', 'transaksi.id_ruangan', '=', 'ruangan.id_ruangan')
    ->join('bidang_pegawai', 'transaksi.id_bidang', '=', 'bidang_pegawai.id_bidang')

    // filter tanggal pakai mysql langsung
    ->whereRaw('DATE(waktu_mulai) = CURDATE()')

    // filter status aman
    ->whereRaw('LOWER(TRIM(status_peminjaman)) = "disetujui"')

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

    // tanggal > hari ini (besok dst)
    ->whereRaw('DATE(waktu_mulai) > CURDATE()')

    // status aman
    ->whereRaw('LOWER(TRIM(status_peminjaman)) = "disetujui"')

    ->select(
        'transaksi.*',
        'ruangan.nama_ruangan',
        'bidang_pegawai.bidang'
    )
    ->orderBy('waktu_mulai')
    ->limit(20)
    ->get();


    /* ======================
       GALERI RUANGAN
    ====================== */
    $galeri = DB::table('gambar_ruangan')
        ->join('ruangan', 'gambar_ruangan.id_ruangan', '=', 'ruangan.id_ruangan')
        ->select(
            'gambar_ruangan.*',
            'ruangan.nama_ruangan'
        )
        ->get();

    return view('monitor.landingpage', compact(
        'hariIni',
        'mendatang',
        'galeri'
    ));
}
}