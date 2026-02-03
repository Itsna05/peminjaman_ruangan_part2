<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruangan;


class DenahRuanganController extends Controller
{
  public function index()
  {
    // Ambil semua ruangan + sarana
    $ruangan = Ruangan::with('sarana',  'gambar')->get();

    return view('petugas.denah_ruangan', compact('ruangan'));
  }
}
