<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruangan;
use Illuminate\Support\Str;

class ManajemenRuanganController extends Controller
{


public function index()
{
    $ruangans = Ruangan::all();
    return view('superadmin.manajemen-ruangan', compact('ruangans'));
}

public function update(Request $request, $id)
{
    DB::transaction(function () use ($request, $id) {

        // ================= RUANGAN =================
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update([
            'nama_ruangan' => $request->nama
        ]);

        // ================= SARANA =================
        DB::table('data_sarana')->where('id_ruangan', $id)->delete();

        foreach ($request->elektronik as $item) {
            DB::table('data_sarana')->insert([
                'id_ruangan'   => $id,
                'jenis_sarana' => 'elektronik',
                'nama_sarana'  => $item['nama'],
                'jumlah'       => $item['jumlah'],
            ]);
        }

        foreach ($request->non as $item) {
            DB::table('data_sarana')->insert([
                'id_ruangan'   => $id,
                'jenis_sarana' => 'non-elektronik',
                'nama_sarana'  => $item['nama'],
                'jumlah'       => $item['jumlah'],
            ]);
        }

        // ================= GAMBAR =================
        DB::table('gambar_ruangan')->where('id_ruangan', $id)->delete();

        foreach ($request->images as $img) {

            // kalau dari JS bentuk object
            $src = is_array($img) ? $img['src'] : $img;

            // ===== GAMBAR LAMA (URL) =====
            if (str_starts_with($src, 'http')) {
                $filename = basename($src);
            }

            // ===== GAMBAR BARU (BASE64) =====
            else if (str_starts_with($src, 'data:image')) {
                [$meta, $content] = explode(',', $src);
                $ext = str_contains($meta, 'png') ? 'png' : 'jpg';

                $filename = Str::uuid() . '.' . $ext;
                file_put_contents(
                    public_path('img/ruangan/' . $filename),
                    base64_decode($content)
                );
            } else {
                continue;
            }

            DB::table('gambar_ruangan')->insert([
                'id_ruangan' => $id,
                'nama_file'  => $filename
            ]);
        }
    });

    return response()->json(['status' => 'ok']);
}

public function store(Request $request)
{
    DB::transaction(function () use ($request) {

        // ================= RUANGAN =================
        $ruangan = Ruangan::create([
            'nama_ruangan' => $request->nama
        ]);

        $idRuangan = $ruangan->id_ruangan; // 🔥 PENTING

        // ================= ELEKTRONIK =================
        if ($request->has('elektronik') && is_array($request->elektronik)) {
            foreach ($request->elektronik as $item) {
                DB::table('data_sarana')->insert([
                    'id_ruangan'   => $idRuangan,
                    'jenis_sarana' => 'elektronik',
                    'nama_sarana'  => $item['nama'],
                    'jumlah'       => $item['jumlah'],
                ]);
            }
        }

        // ================= NON ELEKTRONIK =================
        if ($request->has('non') && is_array($request->non)) {
            foreach ($request->non as $item) {
                DB::table('data_sarana')->insert([
                    'id_ruangan'   => $idRuangan,
                    'jenis_sarana' => 'non-elektronik',
                    'nama_sarana'  => $item['nama'],
                    'jumlah'       => $item['jumlah'],
                ]);
            }
        }

        // ================= GAMBAR =================
        if ($request->has('images') && is_array($request->images)) {
            foreach ($request->images as $img) {
                $src = is_array($img) ? $img['src'] : $img;

                if (str_starts_with($src, 'data:image')) {
                    [$meta, $content] = explode(',', $src);
                    $ext = str_contains($meta, 'png') ? 'png' : 'jpg';

                    $filename = Str::uuid() . '.' . $ext;
                    file_put_contents(
                        public_path('img/ruangan/' . $filename),
                        base64_decode($content)
                    );

                    DB::table('gambar_ruangan')->insert([
                        'id_ruangan' => $idRuangan,
                        'nama_file'  => $filename
                    ]);
                }
            }
        }
    });

    return response()->json(['status' => true]);
}

public function destroy($id)
{
    DB::transaction(function () use ($id) {

        // hapus gambar (file + db)
        $images = DB::table('gambar_ruangan')
            ->where('id_ruangan', $id)
            ->get();

        foreach ($images as $img) {
            $path = public_path('img/ruangan/' . $img->nama_file);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        DB::table('gambar_ruangan')->where('id_ruangan', $id)->delete();
        DB::table('data_sarana')->where('id_ruangan', $id)->delete();
        Ruangan::where('id_ruangan', $id)->delete();
    });

    return response()->json(['status' => true]);
}

}