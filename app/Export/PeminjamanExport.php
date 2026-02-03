<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PeminjamanExport implements
    FromCollection,
    WithHeadings,
    WithEvents,
    WithCustomStartCell
{
    protected $search;
    protected $status;
    protected $bulan;
    protected $tahun;

    /**
     * ⬅️ HARUS SAMA DENGAN CONTROLLER
     */
    public function __construct(
        $search = null,
        $status = null,
        $bulan  = null,
        $tahun  = null
    ) {
        $this->search = $search;
        $this->status = $status;
        $this->bulan  = $bulan;
        $this->tahun  = $tahun;
    }

    /**
     * DATA (IKUT FILTER DASHBOARD)
     */
    public function collection()
    {
        $query = Transaksi::with(['ruangan', 'bidang']);

        // SEARCH
        if ($this->search) {
            $query->where('acara', 'like', '%' . $this->search . '%');
        }

        // STATUS
        if ($this->status) {
            $query->where('status_peminjaman', $this->status);
        }

        // BULAN
        if ($this->bulan) {
            $query->whereMonth('waktu_mulai', $this->bulan);
        }

        // TAHUN
        if ($this->tahun) {
            $query->whereYear('waktu_mulai', $this->tahun);
        }

        return $query
            ->orderBy('waktu_mulai', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    $item->ruangan->nama_ruangan ?? '-',
                    $item->acara,
                    $item->waktu_mulai->format('d-m-Y'),
                    $item->waktu_mulai->format('H:i') . ' - ' . $item->waktu_selesai->format('H:i'),
                    $item->bidang->bidang ?? '-',
                    $item->bidang->sub_bidang ?? '-',
                    $item->no_wa,
                    $item->status_peminjaman,
                ];
            });
    }

    /**
     * HEADER TABEL
     */
    public function headings(): array
    {
        return [
            'Nama Ruangan',
            'Acara',
            'Tanggal',
            'Waktu',
            'Bidang',
            'Sub Bidang',
            'No WhatsApp',
            'Status',
        ];
    }

    /**
     * HEADER MULAI BARIS 8
     */
    public function startCell(): string
    {
        return 'A8';
    }

    /**
     * KOP EXCEL
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet   = $event->sheet->getDelegate();
                $lastCol = 'H';

                // KOP
                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->setCellValue('A1', 'LAPORAN PEMINJAMAN RUANGAN');

                $sheet->mergeCells("A2:{$lastCol}2");
                $sheet->setCellValue('A2', 'Dinas Pekerjaan Umum dan Penataan Ruang');

                $sheet->mergeCells("A3:{$lastCol}3");
                $sheet->setCellValue('A3', 'Provinsi Jawa Tengah');

                $sheet->mergeCells("A5:{$lastCol}5");
                $sheet->setCellValue(
                    'A5',
                    'Periode : ' . now()->translatedFormat('F Y')
                );

                $sheet->mergeCells("A6:{$lastCol}6");
                $sheet->setCellValue(
                    'A6',
                    'Dicetak : ' . now()->format('d F Y H:i:s')
                );

                // STYLE
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A2:A3')->getFont()->setBold(true);

                $sheet->getStyle('A1:A6')->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);
            }
        ];
    }
}
