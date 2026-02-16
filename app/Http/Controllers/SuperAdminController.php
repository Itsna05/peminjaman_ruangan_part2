<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use App\Models\Ruangan;
use Carbon\Carbon;


class SuperAdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'superadmin')->get();

        // =====================
        // SUMMARY CARD
        // =====================
        $totalPeminjaman = Transaksi::count();

        $menunggu = Transaksi::where('status_peminjaman', 'Menunggu')->count();
        $disetujui = Transaksi::where('status_peminjaman', 'Disetujui')->count();
        $dibatalkan = Transaksi::where('status_peminjaman', 'Dibatalkan')->count();

        // =====================
        // RUANGAN
        // =====================
        
        $totalRuangan = Ruangan::count();

        // Ruangan tersedia HARI INI
        $ruanganTersedia = Ruangan::whereNotIn('id_ruangan', function ($query) {
            $query->select('id_ruangan')
                ->from('transaksi')
                ->whereDate('waktu_mulai', Carbon::today())
                ->where('status_peminjaman', 'Disetujui');
        })->count();
        
        // =====================
        // GRAFIK BULANAN
        // =====================
        $statistikBulanan = Transaksi::select(
                DB::raw('MONTH(waktu_mulai) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('waktu_mulai', now()->year)
            ->groupBy(DB::raw('MONTH(waktu_mulai)'))
            ->get();

        // =====================
        // RIWAYAT PEMINJAMAN (TABLE)
        // =====================
        $transaksi = Transaksi::with(['ruangan', 'bidang'])
            ->orderBy('id_peminjaman', 'desc')
            ->get();

        return view(
            'superadmin.dashboard',
            compact(
                'admins',
                'totalPeminjaman',
                'menunggu',
                'disetujui',
                'dibatalkan',
                'totalRuangan',
                'ruanganTersedia',
                'statistikBulanan',
                'transaksi'
            )
        );
    }



    public function manajemenuser()
    {
        $users = User::all();
        $bidangPegawai = DB::table('bidang_pegawai')->get();
        $bidangList = DB::table('bidang_pegawai')
                ->select('bidang')
                ->distinct()
                ->pluck('bidang');
        return view('superadmin.manajemen-user', compact('users', 'bidangPegawai', 'bidangList'));
    }

    public function storeBidang(Request $request)
    {
        $request->validate([
            'bidang' => 'required',
            'sub_bidang' => 'required',
        ]);

        DB::table('bidang_pegawai')->insert([
            'bidang' => $request->bidang,
            'sub_bidang' => $request->sub_bidang,
        ]);

        return back()->with('success', 'Bidang pegawai berhasil ditambahkan');
    }

    public function updateBidang(Request $request)
    {
        $request->validate([
            'id_bidang' => 'required',
            'bidang' => 'required',
            'sub_bidang' => 'required',
        ]);

        DB::table('bidang_pegawai')
            ->where('id_bidang', $request->id_bidang)
            ->update([
                'bidang' => $request->bidang,
                'sub_bidang' => $request->sub_bidang,
            ]);

        return back()->with('success', 'Bidang berhasil diupdate');
    }

    // public function storeUser(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required',
    //         'username' => 'required|unique:users,username',
    //         'password' => 'required|min:6',
    //         'role' => 'required|in:superadmin,petugas',
    //     ]);

    //     DB::table('users')->insert([
    //         'nama' => $request->nama,
    //         'username' => $request->username,
    //         'password' => Hash::make($request->password),
    //         'role' => $request->role,
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     return back()->with('success', 'User berhasil ditambahkan');
    // }

    // public function updateUser(Request $request)
    // {
    //     $request->validate([
    //         'id_user' => 'required',
    //         'nama' => 'required',
    //         'username' => 'required|unique:user,username,' . $request->id_user . ',id_user',
    //         'role' => 'required|in:superadmin,petugas',
    //     ]);

    //     DB::table('user')
    //         ->where('id_user', $request->id_user)
    //         ->update([
    //             'nama' => $request->nama,
    //             'username' => $request->username,
    //             'role' => $request->role,
    //         ]);

    //     return back()->with('success', 'User berhasil diupdate');
    // }
    public function updateUser(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'nama' => 'required',
            'username' => 'required|unique:user,username,' . $request->id_user . ',id_user',
            'role' => 'required|in:superadmin,petugas',
            // password TIDAK wajib
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'role' => $request->role,
        ];

        // 👉 INI KUNCI UTAMANYA
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('user')
            ->where('id_user', $request->id_user)
            ->update($data);

        return back()->with('success', 'User berhasil diupdate');
    }



    public function create()
    {
        return view('superadmin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required',
            'username' => 'required|unique:user,username',
            'password' => 'required|min:6',
        ]);

        User::create([
            'nama'     => $request->nama,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role'     => $request -> role, // 🔑 DIPAKSA
        ]);

        return redirect('/superadmin/manajemen-user')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $admin = User::where('role', 'superadmin')->findOrFail($id);
        return view('superadmin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'     => 'required',
            'username' => 'required|unique:user,username,' . $id . ',id_user',
        ]);

        $admin = User::where('role', 'superadmin')->findOrFail($id);

        $data = [
            'nama'     => $request->nama,
            'username' => $request->username,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect('/superadmin')->with('success', 'Super Admin berhasil diubah');
    }

    public function destroy($id)
    {
        $admin = User::where('role', 'superadmin')->findOrFail($id);
        $admin->delete();

        return redirect('/superadmin')->with('success', 'Super Admin berhasil dihapus');
    }

    public function manajemenPeminjaman()
    {
        $transaksi = Transaksi::with(['ruangan','bidang'])
            ->orderBy('id_peminjaman','desc')
            ->get();

        return view('superadmin.manajemen-peminjaman', compact('transaksi'));
    }
}
