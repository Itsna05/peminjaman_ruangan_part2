<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        // HANYA ambil user role petugas
        $petugas = User::where('role', 'petugas')->get();
        return view('petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('petugas.create');
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
            'role'     => 'petugas', // 🔑 DIPAKSA
        ]);

        return redirect('/petugas')->with('success', 'Petugas berhasil ditambahkan');
    }

    public function edit($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        return view('petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama'     => 'required',
            'username' => 'required|unique:user,username,' . $id . ',id_user',
        ]);

        $petugas = User::where('role', 'petugas')->findOrFail($id);

        $data = [
            'nama'     => $request->nama,
            'username' => $request->username,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $petugas->update($data);

        return redirect('/petugas')->with('success', 'Petugas berhasil diubah');
    }

    public function destroy($id)
    {
        $petugas = User::where('role', 'petugas')->findOrFail($id);
        $petugas->delete();

        return redirect('/petugas')->with('success', 'Petugas berhasil dihapus');
    }
}
