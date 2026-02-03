<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PeminjamanExport;

class ExportPeminjamanController extends Controller
{
    /**
     * =====================================
     * EXPORT EXCEL (IKUT FILTER)
     * =====================================
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new PeminjamanExport(
                $request->search ?? null,
                $request->status ?? null,
                $request->bulan  ?? null,
                $request->tahun  ?? null
            ),
            'peminjaman_ruangan.xlsx'
        );
    }

    /**
     * =====================================
     * EXPORT PDF (IKUT FILTER)
     * =====================================
     */
    public function exportPdf(Request $request)
    {
        $query = Transaksi::with(['ruangan', 'bidang']);

        // FILTER SEARCH
        if ($request->filled('search')) {
            $query->where('acara', 'like', '%' . $request->search . '%');
        }

        // FILTER STATUS
        if ($request->filled('status')) {
            $query->where('status_peminjaman', $request->status);
        }

        // FILTER BULAN
        if ($request->filled('bulan')) {
            $query->whereMonth('waktu_mulai', $request->bulan);
        }

        // FILTER TAHUN
        if ($request->filled('tahun')) {
            $query->whereYear('waktu_mulai', $request->tahun);
        }

        $transaksi = $query
            ->orderBy('waktu_mulai', 'desc')
            ->get();

        $pdf = Pdf::loadView('superadmin.export.pdf', [
            'transaksi' => $transaksi,
            'filter'    => [
                'status' => $request->status,
                'bulan'  => $request->bulan,
                'tahun'  => $request->tahun,
            ]
        ])->setPaper('A4', 'portrait');

        return $pdf->download('peminjaman_ruangan.pdf');
    }
}
