<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaksi;

class PeminjamanRuanganController extends Controller
{
    // ======================
    // HALAMAN UTAMA
    // ======================
    public function index()
    {
        // ======================
        // DATA TRANSAKSI (TABEL)
        // ======================

        $transaksi = Transaksi::with(['ruangan','bidang'])
        ->orderByDesc('id_peminjaman')
        ->get();

        // ======================
        // MASTER BIDANG (UNIK)
        // ======================
        $bidang = DB::table('bidang_pegawai')
            ->select('bidang')
            ->distinct()
            ->orderBy('bidang')
            ->get();

        // ======================
        // MASTER RUANGAN
        // ======================
        $ruangan = DB::table('ruangan')
            ->orderBy('nama_ruangan')
            ->get();

        return view('petugas.form-peminjaman', compact(
            'transaksi',
            'bidang',
            'ruangan'
        ));
    }

    // ======================
    // DETAIL PEMINJAMAN (EDIT MODAL)
    // ======================
    public function show($id)
    {
        return DB::table('transaksi')
            ->join('bidang_pegawai', 'transaksi.id_bidang', '=', 'bidang_pegawai.id_bidang')
            ->where('transaksi.id_peminjaman', $id)
            ->select(
                'transaksi.*',
                'bidang_pegawai.bidang',
                'bidang_pegawai.sub_bidang'
            )
            ->first();
    }

    // ======================
    // GET SUB BIDANG (AJAX)
    // ======================
    public function getSubBidang(Request $request)
    {
        return response()->json(
            DB::table('bidang_pegawai')
                ->where('bidang', $request->bidang)
                ->orderBy('sub_bidang')
                ->get()
        );
    }

    // ======================
    // UPDATE DATA
    // ======================
    public function update(Request $request, $id)
    {
        // ======================
        // CARI id_bidang DARI bidang + sub_bidang
        // ======================
        $idBidang = DB::table('bidang_pegawai')
            ->where('bidang', $request->bidang)
            ->where('sub_bidang', $request->sub_bidang)
            ->value('id_bidang');

        DB::table('transaksi')
            ->where('id_peminjaman', $id)
            ->update([
                'acara'          => $request->acara,
                'jumlah_peserta' => $request->jumlah_peserta,
                'waktu_mulai'    => $request->waktu_mulai,
                'waktu_selesai'  => $request->waktu_selesai,
                'no_wa'          => $request->no_wa,
                'catatan'        => $request->catatan ?? '',
                'id_bidang'      => $idBidang,
                'id_ruangan'     => $request->id_ruangan,
            ]);

        return response()->json(['success' => true]);
    }

    public function batalkan($id)
    {
        DB::table('transaksi')
            ->where('id_peminjaman', $id)
            ->update([
                'status_peminjaman' => 'Dibatalkan'
            ]);

        return response()->json(['success' => true]);
    }

    // ======================
    // TAMBAH DATA
    // ======================



    public function store(Request $request)
{
    // 1️ Validasi
    $request->validate([
        'acara'           => 'required|string',
        'jumlah_peserta'  => 'required|integer',
        'waktu_mulai'     => 'required|date',
        'waktu_selesai'   => 'required|date|after:waktu_mulai',
        'bidang'          => 'required|string',
        'sub_bidang'      => 'required|string',
        'id_ruangan'      => 'required|integer',
        'no_wa'           => 'required|string',
    ]);

    // 2️ Cari id_bidang dari bidang + sub_bidang
    $idBidang = DB::table('bidang_pegawai')
        ->where('bidang', $request->bidang)
        ->where('sub_bidang', $request->sub_bidang)
        ->value('id_bidang');

    //  Safety check
    if (!$idBidang) {
        return back()->withErrors('Bidang tidak valid');
    }

    // 3️ Insert ke transaksi
    DB::table('transaksi')->insert([
        'acara'             => $request->acara,
        'jumlah_peserta'    => $request->jumlah_peserta,
        'waktu_mulai'       => $request->waktu_mulai,
        'waktu_selesai'     => $request->waktu_selesai,
        'id_bidang'         => $idBidang, 
        'id_ruangan'        => $request->id_ruangan,
        'id_user' => session('user_id'),
        'no_wa'             => $request->no_wa,
        'catatan'           => $request->catatan ?? '',
        'status_peminjaman' => 'Menunggu',
    ]);

    return redirect()->back()->with('success', 'Peminjaman berhasil diajukan');
}




}
