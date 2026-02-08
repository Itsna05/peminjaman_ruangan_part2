@extends('superadmin.layout')

@section('title', 'Dashboard Superadmin')

@section('content')

{{-- =======================
   HEADER BACKGROUND
   ======================= --}}
<section class="dashboard-hero"></section>

{{-- =======================
   HEADER INFO BOX
   ======================= --}}
<section class="dashboard-info">
    <div class="container">
        <div class="info-box text-center">

            <h4 class="info-title">
                <span class="line"></span>
                Informasi Peminjaman Ruangan
                <span class="line"></span>
            </h4>

            <p class="info-desc">
                Peminjaman ruangan hanya dapat digunakan apabila telah memperoleh persetujuan resmi
                dari pihak terkait sesuai alur yang ditetapkan oleh Dinas Pekerjaan Umum Bina Marga
                dan Cipta Karya (DPU BMCK) Provinsi Jawa Tengah.
            </p>


        </div>
    </div>
</section>



           
{{-- =======================
   SUMMARY CARD
   ======================= --}}
<section> 
    
     <div class="container my-4">

        <div class="row g-4">

            <div class="col-md-6">
                <div class="summary-card h-100">
                    <p>Total Peminjaman</p>
                    <h3>{{ $totalPeminjaman }}</h3>
                    <small>+2 dari bulan lalu</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="summary-card warning h-100">
                    <p>Menunggu Persetujuan</p>
                    <h3>{{ $menunggu }}</h3>
                    <small>Perlu tindakan</small>
                </div>
            </div>

        </div>

    </div>

    {{-- =======================
            GRAFIK
    ======================= --}}
    <div class="container my-5">
        <div class="card p-4">
            <h4 class="fw-bold mb-3">Statistik Peminjaman</h4>

            <canvas id="loanChart"></canvas>
            <script>
                window.dataBulanan = Array(12).fill(0);

                @foreach ($statistikBulanan as $item)
                    window.dataBulanan[{{ $item->bulan - 1 }}] = {{ $item->total }};
                @endforeach
            </script>



            

        </div> 
    </div> 

</section>

{{-- =======================
   RIWAYAT PEMINJAMAN RUANGAN
   ======================= --}}
<section>
    <div class="riwayat-wrapper">

        <h4 class="status-title text-center">
            Riwayat Peminjaman Ruangan
        </h4>

        <div class="status-card rp-card">

            {{-- TOOLBAR --}}
            <div class="status-toolbar">
                <div class="search-box">
                    <button type="button" class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                    <input type="text" placeholder="Pencarian" id="searchInput">
                </div>


                <div class="unduh-box">
                    <div class="unduh-stack" id="unduhToggle">
                        <div class="unduh-header">
                            <span>Unduh</span>
                            <span class="arrow">▾</span>
                        </div>

                        <div class="unduh-dropdown">
                            <a href="{{ route('superadmin.peminjaman.export.pdf') }}"
   id="downloadPdf"
   class="unduh-item">
                                PDF
                            </a>

                            <a href="{{ route('superadmin.peminjaman.export.excel') }}"
   id="downloadExcel"
   class="unduh-item">

                                Excel
                            </a>
                        </div>

                    </div>
                </div>
                
            </div>

            {{-- TABLE --}}
            <div class="search-item dash-slider rp-table-scroll">
                <table class="status-table rp-table">
                        <colgroup>
                            <col style="width:45px">     <!-- No -->
                            <col style="width:140px">    <!-- Nama Ruangan -->
                            <col style="width:auto">     <!-- Acara -->
                            <col style="width:160px">    <!-- Waktu -->
                            <col style="width:190px">    <!-- Bidang -->
                            <col style="width:120px">    <!-- No WA -->
                            <col style="width:110px">    <!-- Status -->
                        </colgroup>


                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ruangan</th>
                                <th>Acara</th>
                                <th class="time-filter-wrap">
                                    <button
                                        type="button"
                                        class="time-filter__btn"
                                        data-dropdown-button="timeFilterMenu"
                                    >
                                        Waktu <span class="arrow">▾</span>
                                    </button>

                                    <div
                                        class="time-filter__menu"
                                        id="timeFilterMenu"
                                        data-dropdown-menu
                                    >
                                    <input
                                            type="text"
                                            id="timeFilter"
                                            class="time-filter__input"
                                            placeholder="Pilih Bulan & Tahun"
                                            readonly
                                        >

                                        <button
                                            type="button"
                                            class="time-filter__clear"
                                            id="timeFilterClear"
                                        >
                                            Reset
                                        </button>
                                    </div>
                                </th>

                                <th>Bidang</th>
                                <th>No WhatsApp</th>
                                <th class="text-center status-filter-wrap">
                                    <button
                                        type="button"
                                        class="status-filter__btn"
                                        data-dropdown-button="statusFilterMenu"
                                    >
                                        Status <span class="arrow">▾</span>
                                    </button>

                                    <div
                                        class="status-filter__menu"
                                        id="statusFilterMenu"
                                        data-dropdown-menu
                                    >

                                        <button class="status-filter__item" data-status="">
                                            Tampilkan Semua
                                        </button>
                                        <button class="status-filter__item" data-status="menunggu">
                                            Menunggu
                                        </button>
                                        <button class="status-filter__item" data-status="disetujui">
                                            Disetujui
                                        </button>
                                        <button class="status-filter__item" data-status="ditolak">
                                            Ditolak
                                        </button>
                                        <button class="status-filter__item" data-status="dibatalkan">
                                            Dibatalkan
                                        </button>

                                    </div>
                                </th>
                            </tr>
                        </thead>

                        <tbody id="tableBody">
                        @forelse ($transaksi as $item)
                        <tr data-status="{{ strtolower($item->status_peminjaman) }}">
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->ruangan->nama_ruangan ?? '-' }}
                            </td>

                            <td>{{ $item->acara }}</td>

                            <td
                                data-date="{{ $item->waktu_mulai->format('Y-m-d') }}"
                            >
                                <div class="tanggal">
                                    {{ $item->waktu_mulai->translatedFormat('d F Y') }}
                                </div>
                                <div class="jam">
                                    {{ $item->waktu_mulai->format('H:i') }}
                                    -
                                    {{ $item->waktu_selesai->format('H:i') }} WIB
                                </div>
                            </td>

                            <td>
                                <div class="bidang-nama">
                                    {{ $item->bidang->bidang ?? '-' }}
                                </div>
                                <div class="sub-bidang">
                                    {{ $item->bidang->sub_bidang ?? '-' }}
                                </div>
                            </td>

                            <td>{{ $item->no_wa }}</td>

                            <td class="text-center">
                                <span
                                    class="badge-status {{ strtolower($item->status_peminjaman) }}"
                                    data-status="{{ strtolower($item->status_peminjaman) }}"
                                >
                                    {{ $item->status_peminjaman }}
                                </span>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Data peminjaman belum ada
                            </td>
                        </tr>
                        @endforelse
                        </tbody>

                    </table>
            </div>

            {{-- FOOTER --}}    
            <div class="status-footer">
                <div class="rows-info">
                    Jumlah Baris :
                    <select id="rowsPerPage">
                        <option value="5">5</option>
                        <option value="10">10</option>
                    </select>
                </div>


                <div class="pagination" id="pagination"></div>
            </div>

        </div>
    </div>
</section>


@endsection

<script>
    window.exportPdfUrl = "{{ route('superadmin.peminjaman.export.pdf') }}";
    window.exportExcelUrl = "{{ route('superadmin.peminjaman.export.excel') }}";
</script>
