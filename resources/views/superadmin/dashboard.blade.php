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
        <div class="row g-3">

            <div class="col-md-4">
                <div class="summary-card">
                    <p>Total Peminjaman</p>
                    <h3>12</h3>
                    <small>+2 dari bulan lalu</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-card warning">
                    <p>Menunggu Persetujuan</p>
                    <h3>5</h3>
                    <small>Perlu tindakan</small>
                </div>
            </div>

            <div class="col-md-4">
                <div class="summary-card success">
                    <p>Ruangan Tersedia</p>
                    <h3>2 / 4</h3>
                    <small>Hari ini</small>
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
        </div>
    </div>

</section>

{{-- =======================
   RIWAYAT PEMINJAMAN RUANGAN
   ======================= --}}
<section>
    <div class="status-wrapper">

        <h4 class="status-title text-center">
            Riwayat Peminjaman Ruangan
        </h4>

        <div class="status-card">

            {{-- SEARCH & FILTER --}}
            <div class="status-toolbar">
                <div class="search-box">
                    <button type="button" class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                    <input type="text" placeholder="Pencarian" id="searchInput">
                </div>

                <div class="filter-box">
                    <button class="filter-btn" type="button" id="filterToggle">
                        Filter <span class="arrow">▾</span>
                    </button>

                    <div class="filter-dropdown" id="filterDropdown">
                        <button class="filter-item" data-value="tampilkansemua">Tampilkan Semua</button>
                        <button class="filter-item" data-value="menunggu">Menunggu</button>
                        <button class="filter-item" data-value="disetujui">Disetujui</button>
                        <button class="filter-item" data-value="ditolak">Ditolak</button>
                        <button class="filter-item" data-value="dibatalkan">Dibatalkan</button>
                    </div>
                </div>

                <div class="unduh-box">
                    <button class="unduh-btn" type="button" id="unduhToggle">
                        Unduh
                        <span class="arrow">▾</span>
                    </button>

                    <div class="unduh-dropdown" id="unduhDropdown">
                        <button class="unduh-item">PDF</button>
                        <button class="unduh-item">Excel</button>
                    </div>
                </div>

            </div>

            {{-- TABLE --}}
            <div class="search-item dash-slider">
                <table class="status-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Ruangan</th>
                            <th>Acara</th>
                            <th>Bidang</th>
                            <th>Waktu</th>
                            <th>No Whatsapp</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        <tr data-status="menunggu">
                            <td>1</td>
                            <td>Ruang Studio</td>
                            <td>Hari Amal Bakti DPU</td>
                            <td>Teknologi Informasi<br><small>Kasubag</small></td>
                            <td>15 Agustus 2025<br><small>10.00-13.00 WIB</small></td>
                            <td>0849237903</td>
                            <td class="text-center">
                                <span class="badge-status menunggu">Menunggu</span>
                            </td>
                        </tr>

                        <tr data-status="disetujui">
                            <td>2</td>
                            <td>Ruang Bond</td>
                            <td>Perencanaan Masjid At-Taqwa</td>
                            <td>Bidang Rancang Bangun<br><small>Kasubag</small></td>
                            <td>15 Agustus 2025<br><small>10.00-13.00 WIB</small></td>
                            <td>0849237903</td>
                            <td class="text-center">
                                <span class="badge-status disetujui">Disetujui</span>
                            </td>
                        </tr>

                        <tr data-status="ditolak">
                            <td>3</td>
                            <td>Ruang Olahraga</td>
                            <td>Rapat Preservasi Jalan</td>
                            <td>Bidang Pelaksanaan Jalan<br><small>Kasubag</small></td>
                            <td>15 Agustus 2025<br><small>10.00-13.00 WIB</small></td>
                            <td>0849237903</td>
                            <td class="text-center">
                                <span class="badge-status ditolak">Ditolak</span>
                            </td>
                        </tr>

                        <tr data-status="dibatalkan">
                            <td>4</td>
                            <td>Ruang Dharma Wanita</td>
                            <td>Pelatihan Kepenulisan</td>
                            <td>Dharma Wanita Persatuan<br><small>Kasubag</small></td>
                            <td>15 Agustus 2025<br><small>10.00-13.00 WIB</small></td>
                            <td>0849237903</td>
                            <td class="text-center">
                                <span class="badge-status dibatalkan">Dibatalkan</span>
                            </td>
                        </tr>

                        <tr data-status="menunggu">
                            <td>5</td>
                            <td>Ruang Studio</td>
                            <td>Hari Amal Bakti DPU</td>
                            <td>Teknologi Informasi<br><small>Kasubag</small></td>
                            <td>15 Agustus 2025<br><small>10.00-13.00 WIB</small></td>
                            <td>0849237903</td>
                            <td class="text-center">
                                <span class="badge-status menunggu">Menunggu</span>
                            </td>
                        </tr>

                        <tr data-status="menunggu">
                            <td>6</td>
                            <td>Ruang Bond</td>
                            <td>Perencanaan Masjid At-Taqwa</td>
                            <td>Bidang Rancang Bangun<br><small>Kasubag</small></td>
                            <td>15 Agustus 2025<br><small>10.00-13.00 WIB</small></td>
                            <td>0849237903</td>
                            <td class="text-center">
                                <span class="badge-status menunggu">Menunggu</span>
                            </td>
                        </tr>

                        <tr data-status="ditolak">
                            <td>7</td>
                            <td>Ruang Olahraga</td>
                            <td>Rapat Preservasi Jalan</td>
                            <td>Bidang Pelaksanaan Jalan<br><small>Kasubag</small></td>
                            <td>15 Agustus 2025<br><small>10.00-13.00 WIB</small></td>
                            <td>0849237903</td>
                            <td class="text-center">
                                <span class="badge-status ditolak">Ditolak</span>
                            </td>
                        </tr>

                        <tr data-status="dibatalkan">
                            <td>8</td>
                            <td>Ruang Dharma Wanita</td>
                            <td>Pelatihan Kepenulisan</td>
                            <td>Dharma Wanita Persatuan<br><small>Kasubag</small></td>
                            <td>15 Agustus 2025<br><small>10.00-13.00 WIB</small></td>
                            <td>0849237903</td>
                            <td class="text-center">
                                <span class="badge-status dibatalkan">Dibatalkan</span>
                            </td>
                        </tr>

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