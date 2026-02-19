<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // Tampil halaman kontak
    public function index()
    {
        $faqs = Faq::orderBy('id','desc')->get();

        return view('shared.kontak', compact('faqs'));
    }

    // Cek role (security layer)
    private function onlyAdmin()
    {
        if (session('role') !== 'superadmin') {
            abort(403, 'Akses ditolak');
        }
    }

    // Tambah
    public function store(Request $request)
    {
        $this->onlyAdmin();

        $request->validate([
            'pertanyaan' => 'required|max:255',
            'jawaban' => 'required'
        ]);

        Faq::create($request->only([
            'pertanyaan',
            'jawaban'
        ]));

        return back()->with('success','FAQ ditambahkan');
    }

    // Update
    public function update(Request $request, $id)
    {
        $this->onlyAdmin();

        $request->validate([
            'pertanyaan' => 'required|max:255',
            'jawaban' => 'required'
        ]);

        $faq = Faq::findOrFail($id);

        $faq->update($request->only([
            'pertanyaan',
            'jawaban'
        ]));

        return back()->with('success','FAQ diupdate');
    }

    // Hapus
    public function destroy($id)
    {
        $this->onlyAdmin();

        Faq::destroy($id);

        return back()->with('success','FAQ dihapus');
    }
}
