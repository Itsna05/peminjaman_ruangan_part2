@extends('superadmin.layout')

@section('title', 'Manajemen Ruangan')

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
                Manajemen Ruangan
                <span class="line"></span>
            </h4>

            <p class="info-desc">
                Berikut merupakan Denah dan Data Ruangan Kantor DPU BMCK Jateng 
            </p>


        </div>
    </div>
</section>

{{-- DENAH EKSISTING --}}
<section class="denah-section">
    <div class="container">
        <div class="denah-card text-center">
            <h3 class="denah-title">Denah Eksisting Lantai 1</h3>
            <img src="{{ asset('img/denah_lantai1.png') }}" class="img-fluid">
        </div>
    </div>
</section>

{{-- DETAIL RUANGAN --}}
<section class="detail-ruangan-section">
    <div class="container">
        <div class="status-card">
            <h3 class="text-center fw-bold mb-5">Detail Ruangan</h3>

              {{-- SEARCH & TAMBAH RUANGAN --}}
              <div class="status-toolbar">
                  <div class="search-box">
                      <button type="button" class="search-btn">
                          <i class="bi bi-search"></i>
                      </button>
                      <input type="text" placeholder="Pencarian" id="searchInput">
                  </div>

                <div class="tambah-box">
                    <button class="tambah-btn" type="button" id="tambahToggle">
                        Tambah Ruangan
                        <span class="icon-plus">+</span>
                    </button>
                </div>


        </div>

        <div class="ruangan-slider">
            <div class="ruangan-track">

            {{-- ================= CARD 1 ================= --}}
            @php
            $elektronik = [
                ['nama' => 'AC', 'jumlah' => 2],
                ['nama' => 'Sound System', 'jumlah' => 1],
                ['nama' => 'Layar LED', 'jumlah' => 0],
                ['nama' => 'Alat Musik', 'jumlah' => 1],
            ];

            $nonelektronik = [
                ['nama' => 'Kursi', 'jumlah' => 10],
                ['nama' => 'Meja', 'jumlah' => 5],
            ];

            $images = [
                asset('img/ruang_SKPD_TP1.png'),
                asset('img/ruang_SKPD_TP2.png'),
                asset('img/ruang_SKPD_TP3.png'),
                asset('img/ruang_SKPD_TP4.png'),
            ];
            @endphp

            <div class="detail-card search-item"
                data-nama="Ruang SKPD TP"
                data-elektronik='@json($elektronik)'
                data-nonelektronik='@json($nonelektronik)'
                data-images='@json($images)'>

                <div class="detail-card-header">Ruang SKPD TP</div>

                <div class="detail-card-image photo-frame">
                    <div id="foto-skpd-timur"
                         class="carousel slide foto-carousel"
                         data-bs-touch="false"
                         data-bs-interval="false">

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('img/ruang_SKPD_TP1.png') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/ruang_SKPD_TP2.png') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/ruang_SKPD_TP3.png') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/ruang_SKPD_TP4.png') }}">
                            </div>
                        </div>

                        <button class="carousel-control-prev"
                                type="button"
                                data-bs-target="#foto-skpd-timur"
                                data-bs-slide="prev"></button>

                        <button class="carousel-control-next"
                                type="button"
                                data-bs-target="#foto-skpd-timur"
                                data-bs-slide="next"></button>
                    </div>
                    <button class="btn-lihat-detail">
                        Lihat Detail
                    </button>
                </div>
            </div>

            {{-- ================= CARD 2 ================= --}}
           @php
            $elektronik = [
                ['nama' => 'AC', 'jumlah' => 10],
                ['nama' => 'Sound System', 'jumlah' => 5],
                ['nama' => 'Layar LED', 'jumlah' => 1],
                ['nama' => 'Alat Musik', 'jumlah' => 4],
            ];

            $nonelektronik = [
                ['nama' => 'Kursi', 'jumlah' => 30],
                ['nama' => 'Meja', 'jumlah' => 10],
            ];

            $images = [
                asset('img/ruang_SKPD_TP3.png'),
                asset('img/ruang_SKPD_TP2.png'),
                asset('img/ruang_SKPD_TP1.png'),
                asset('img/ruang_SKPD_TP4.png'),
            ];
            @endphp

            <div class="detail-card search-item"
            data-nama="Ruang Rapat A"
            data-elektronik='@json($elektronik)'
            data-nonelektronik='@json($nonelektronik)'
            data-images='@json($images)'>

                <div class="detail-card-header">Ruang Rapat A</div>

                <div class="detail-card-image photo-frame">
                    <div id="foto-rapat-a"
                         class="carousel slide foto-carousel"
                         data-bs-touch="false"
                         data-bs-interval="false">

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('img/ruang_SKPD_TP3.png') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/ruang_SKPD_TP2.png') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/ruang_SKPD_TP1.png') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/ruang_SKPD_TP4.png') }}">
                            </div>
                        </div>

                        <button class="carousel-control-prev"
                                type="button"
                                data-bs-target="#foto-rapat-a"
                                data-bs-slide="prev"></button>

                        <button class="carousel-control-next"
                                type="button"
                                data-bs-target="#foto-rapat-a"
                                data-bs-slide="next"></button>
                    </div>
                    <button class="btn-lihat-detail">
                        Lihat Detail
                    </button>
                </div>
            </div>

            {{-- ================= CARD 3 ================= --}}
            @php
            $elektronik = [
                ['nama' => 'AC', 'jumlah' => 3],
                ['nama' => 'Sound System', 'jumlah' => 2],
                ['nama' => 'Layar LED', 'jumlah' => 1],
                ['nama' => 'Alat Musik', 'jumlah' => 0],
            ];

            $nonelektronik = [
                ['nama' => 'Kursi', 'jumlah' => 30],
                ['nama' => 'Meja', 'jumlah' => 10],
            ];

            $images = [
                asset('img/ruang_SKPD_TP4.png'),
                asset('img/ruang_SKPD_TP3.png'),
                asset('img/ruang_SKPD_TP2.png'),
                asset('img/ruang_SKPD_TP1.png'),
            ];
            @endphp

            <div class="detail-card search-item"
            data-nama="Aula Utama"
            data-elektronik='@json($elektronik)'
            data-nonelektronik='@json($nonelektronik)'
            data-images='@json($images)'>

                <div class="detail-card-header">Aula Utama</div>
                
                <div class="detail-card-image photo-frame">
                    <div id="foto-aula-utama"
                         class="carousel slide foto-carousel"
                         data-bs-touch="false"
                         data-bs-interval="false">

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('img/ruang_SKPD_TP4.png') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/ruang_SKPD_TP3.png') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/ruang_SKPD_TP2.png') }}">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('img/ruang_SKPD_TP1.png') }}">
                            </div>
                        </div>

                        <button class="carousel-control-prev"
                                type="button"
                                data-bs-target="#foto-aula-utama"
                                data-bs-slide="prev"></button>

                        <button class="carousel-control-next"
                                type="button"
                                data-bs-target="#foto-aula-utama"
                                data-bs-slide="next"></button>
                    </div>
                    <button class="btn-lihat-detail">
                        Lihat Detail
                    </button>
                </div>
            </div>
            
            </div>
        </div>
    </div>
</section>

<!-- ================= POPUP TAMBAH RUANGAN ================= -->
<div class="popup-overlay" id="popupTambahRuangan">

  <div class="popup-detail popup-large">

    <div class="popup-header">
      <h5>TAMBAH RUANGAN</h5>
      <button class="popup-close" id="closeTambahRuangan">&times;</button>
    </div>

    <div class="popup-body">

      <!-- FOTO -->
      <div class="edit-foto-section">
        <input type="file" id="inputFotoBaru" accept="image/*" multiple hidden>

        <div class="edit-foto-topbar">
          <button type="button" class="btn-tambah-foto" id="btnTambahFotoBaru">
            <i class="bi bi-plus-lg"></i> Tambah
          </button>
        </div>

        <div class="popup-carousel edit-carousel draggable-frame photo-frame">
          <button class="popup-nav prev">&#10094;</button>
          <img id="previewFotoBaru">
          <button class="popup-nav next">&#10095;</button>
          <button class="btn-hapus-foto" id="hapusFotoBaru">Hapus</button>
        </div>
      </div>

      <!-- IDENTITAS -->
      <h3 class="section-title">Identitas Ruangan</h3>
      <input type="text" id="namaRuanganBaru" class="form-control" placeholder="Masukkan nama ruangan">

      <!-- SARANA -->
      <h3 class="section-title">Sarana Prasarana</h3>

      <div class="fasilitas-box">
        <div class="fasilitas-header">
          <h5>FASILITAS ELEKTRONIK</h5>
          <button class="btn-tambah-item" id="tambahElektronikBaru">+ Tambah</button>
        </div>
        <table class="table">
          <thead><tr><th>No</th><th>Nama Fasilitas</th><th>Jumlah</th><th>Aksi</th></tr></thead>
          <tbody id="elektronikBaru"></tbody>
        </table>
      </div>

      <div class="fasilitas-box">
        <div class="fasilitas-header">
          <h5>FASILITAS NON ELEKTRONIK</h5>
          <button class="btn-tambah-item" id="tambahNonBaru">+ Tambah</button>
        </div>
        <table class="table">
          <thead><tr><th>No</th><th>Nama Fasilitas</th><th>Jumlah</th><th>Aksi</th></tr></thead>
          <tbody id="nonBaru"></tbody>
        </table>
      </div>

      <div class="popup-action">
        <button class="btn-edit" id="simpanRuanganBaru">Simpan</button>
        <button class="btn-delete" id="batalRuanganBaru">Batal</button>
      </div>

    </div>
  </div>
</div>

<!-- ================= POPUP DETAIL RUANGAN ================= -->
<div class="popup-overlay" id="popupDetail">

  <div class="popup-detail">

    <!-- HEADER -->
    <div class="popup-header">
      <h5>DETAIL RUANGAN</h5>
      <button class="popup-close" id="closepopup">&times;</button>
    </div>

<div class="popup-body">

    <!-- FOTO -->
    <div class="mode-view">
    <div class="popup-carousel photo-frame">
      <button class="popup-nav prev">&#10094;</button>
      <img id="popupImage">
      <button class="popup-nav next">&#10095;</button>
    </div>

    <!-- IDENTITAS -->
    <h3 class="section-title">Identitas Ruangan</h3>
    <input type="text" id="popupNama" class="form-control" readonly>

    <!-- SARANA -->
    <h3 class="section-title">Sarana Prasarana</h3>

    <div class="fasilitas-box">
      <h5>FASILITAS ELEKTRONIK</h5>
      <table class="table">
        <thead><tr><th>No</th><th>Nama Fasilitas</th><th>Jumlah</th></tr></thead>
        <tbody id="popupElektronik"></tbody>
      </table>
    </div>

    <div class="fasilitas-box">
      <h5>FASILITAS NON ELEKTRONIK</h5>
      <table class="table">
        <thead><tr><th>No</th><th>Nama Fasilitas</th><th>Jumlah</th></tr></thead>
        <tbody id="popupNonElektronik"></tbody>
      </table>
    </div>

    <!-- ACTION -->
    <div class="popup-action">
      <button id="btnEditMode" class="btn-edit">Edit</button>
      <button class="btn-delete btn-hapus-ruangan">Hapus Ruangan</button>
    </div>
  </div>

<!-- ================= MODE EDIT ================= -->
    <div class="mode-edit" style="display:none;">

        <!-- ===== FOTO EDIT ===== -->
    <div class="edit-foto-section">
        <input type="file" id="inputFoto" accept="image/*" style="display:none">

        <!-- TOP BAR (TAMBAH FOTO DI LUAR FOTO) -->
        <div class="edit-foto-topbar">
            <button class="btn-tambah-foto">
                <i class="bi bi-plus-lg"></i> Tambah
            </button>
        </div>

        <!-- CAROUSEL FOTO -->
        <div class="popup-carousel edit-carousel draggable-frame photo-frame">
            <button class="popup-nav prev">&#10094;</button>
            <img id="editPopupImage">
            <button class="popup-nav next">&#10095;</button>

            <!-- HAPUS FOTO DI DALAM FOTO -->
            <button class="btn-hapus-foto">Hapus</button>
        </div>

    </div>

        <h3 class="section-title">Identitas Ruangan</h3>
        <input type="text" id="editNama" class="form-control">

        <h3 class="section-title">Sarana Prasarana</h3>

        <div class="fasilitas-box">
            <div class="fasilitas-header">
            <h5>FASILITAS ELEKTRONIK</h5>
            <button class="btn-tambah-item" data-target="elektronik">
            <i class="bi bi-plus-lg"></i> Tambah
            </button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Fasilitas</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="editElektronik"></tbody>
            </table>
        </div>

        <div class="fasilitas-box">
            <div class="fasilitas-header">
            <h5>FASILITAS NON ELEKTRONIK</h5>
            <button class="btn-tambah-item" data-target="non">
            <i class="bi bi-plus-lg"></i> Tambah
            </button>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Fasilitas</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="editNonElektronik"></tbody>
            </table>
        </div>

        <div class="popup-action">
        <button id="btnSimpan" class="btn-edit" style="display:none;">Simpan</button>
        <button id="btnBatal" class="btn-delete" style="display:none;">Batal</button>
        </div>
    </div>
</div>

<!-- POPUP TAMBAH FASILITAS -->
<div class="popup-overlay" id="popupTambahFasilitas">

  <div class="popup-detail" style="max-width:500px">

    <div class="popup-header">
      <h5 id="popupTambahTitle">Fasilitas</h5>
      <button class="popup-close" id="closeTambahPopup">&times;</button>
    </div>

    <div class="popup-body">
      <div class="form-group">
        <label>Nama Fasilitas</label>
        <input type="text" id="tambahNama" class="form-control">
      </div>

      <div class="form-group mt-3">
        <label>Jumlah Fasilitas</label>
        <input type="number" id="tambahJumlah" class="form-control">
      </div>

      <div class="popup-action">
        <button id="btnSimpanFasilitas" class="btn-edit">Simpan</button>
        <button id="btnBatalFasilitas" class="btn-delete">Batal</button>
      </div>
    </div>

  </div>
</div>
@endsection