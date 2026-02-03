<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;
use App\Models\Ruangan;
use App\Models\BidangPegawai;

class ManajemenPeminjamanController extends Controller
{

public function index()
{
    $transaksi = Transaksi::with(['ruangan', 'bidang'])
        ->orderByDesc('id_peminjaman')
        ->get();

    $bidang = DB::table('bidang_pegawai')
        ->select('bidang')
        ->distinct()
        ->orderBy('bidang')
        ->get();

    $ruangan = DB::table('ruangan')
        ->orderBy('nama_ruangan')
        ->get();

    return view('superadmin.manajemen-peminjaman', compact(
        'transaksi',
        'bidang',
        'ruangan'
    ));
}



public function detail($id)
{
    $t = Transaksi::with(['ruangan', 'bidang'])
        ->findOrFail($id);

    return response()->json([
        'acara'          => $t->acara,
        'jumlah_peserta' => $t->jumlah_peserta,
        'tanggal'        => $t->waktu_mulai->translatedFormat('l, d F Y'),
        'waktu_mulai'    => $t->waktu_mulai->format('H:i'),
        'waktu_selesai'  => $t->waktu_selesai->format('H:i'),
        'bidang'         => $t->bidang->bidang ?? '-',
        'sub_bidang'     => $t->bidang->sub_bidang ?? '-',
        'ruangan'        => $t->ruangan->nama_ruangan ?? '-',
        'no_wa'          => $t->no_wa ?? '-',
        'catatan'        => $t->catatan ?: '-',
    ]);
}


}


