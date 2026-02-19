<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        'status_peminjaman' => $t->status_peminjaman,
        'foto_kegiatan' => $t->foto_kegiatan,

    ]);
}

// ==========================
// SETUJUI PEMINJAMAN
// ==========================
public function approve($id)
{
    $peminjaman = Transaksi::findOrFail($id);
    $peminjaman->status_peminjaman = 'Disetujui';
    $peminjaman->save();

    return response()->json([
        'success' => true,
        'message' => 'Peminjaman berhasil disetujui'
    ]);
}

// ==========================
// TOLAK PEMINJAMAN
// ==========================
public function reject($id)
{
    $peminjaman = Transaksi::findOrFail($id);
    $peminjaman->status_peminjaman = 'Ditolak';
    $peminjaman->save();

    return response()->json([
        'success' => true,
        'message' => 'Peminjaman berhasil ditolak'
    ]);
}

// ==========================
// UPLOAD FOTO KEGIATAN
// ==========================
public function uploadFoto(Request $request, $id)
{
    $request->validate([
        'foto' => 'required|image|max:2048'
    ]);

    $peminjaman = Transaksi::findOrFail($id);

    // simpan file
    $file = $request->file('foto');
    $nama = time() . '_' . $file->getClientOriginalName();

    $file->storeAs('public/foto_kegiatan', $nama);

    // simpan ke DB
    $peminjaman->foto_kegiatan = $nama;
    $peminjaman->save();

    return response()->json([
        'status' => true,
        'message' => 'Foto berhasil disimpan'
    ]);
}

// ==========================
// HAPUS FOTO KEGIATAN
// ==========================

public function hapusFoto($id)
{
    $p = Transaksi::findOrFail($id);

    if ($p->foto_kegiatan) {

        Storage::delete('public/foto_kegiatan/' . $p->foto_kegiatan);

        $p->foto_kegiatan = null;
        $p->save();
    }

    return response()->json([
        'status' => true
    ]);
}



}


