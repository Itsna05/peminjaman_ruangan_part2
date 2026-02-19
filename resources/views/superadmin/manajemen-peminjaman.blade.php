
@extends('superadmin.layout')

@section('title', 'Manajemen Peminjaman')

@section('content')

{{-- TENTUKAN TAB DARI URL--}}
@php
    $tab = request('tab', 'persetujuan');
@endphp


{{-- =======================
   HEADER BACKGROUND
   ======================= --}}
<section class="dashboard-hero"></section>

{{-- ================= HEADER CONTAINER CLICKABLE ================= --}}
<section class="dual-header-section">
    <div class="container">

        <div class="dual-header-wrapper">

            {{-- KIRI - AKTIF --}}
            <a href="{{ route('superadmin.manajemen-peminjaman') }}"
                class="dual-header {{ $tab == 'persetujuan' ? 'active' : '' }}">


                <h4 class="dual-header-title">
                    <span class="line"></span>
                    Persetujuan Peminjaman
                    <span class="line"></span>
                </h4>

                <p class="dual-header-desc">
                    Kelola dan verifikasi setiap pengajuan peminjaman
                    ruangan yang diajukan oleh pemohon.
                </p>

            </a>

            {{-- KANAN --}}
            <a href="{{ route('superadmin.manajemen-peminjaman', ['tab' => 'form']) }}"
                class="dual-header {{ $tab == 'form' ? 'active' : '' }}">


                <h4 class="dual-header-title">
                    <span class="line muted"></span>
                    Peminjaman Ruangan
                    <span class="line muted"></span>
                </h4>

                <p class="dual-header-desc">
                    Lengkapi formulir untuk melakukan peminjaman
                    ruangan sesuai kebutuhan.
                </p>

            </a>

        </div>

    </div>
</section>


{{-- =======================
   PERSETUJUAN PEMINJAMAN RUANGAN
   ======================= --}}

@if ($tab == 'persetujuan')
<section class="manajemen-peminjaman">
    <div class="container"> 
        <div class="status-wrapper">
            <div class="status-card">


            {{-- SEARCH & FILTER --}}
            <div class="status-toolbar">
                <div class="search-box">
                    <button type="button" class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                    <input type="text" placeholder="Pencarian" id="searchInputPersetujuan">
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

            </div>

            {{-- TABLE --}}
            <div class="riwayat-wrapper status-peminjaman-ruangan">
                <div class="status-card-table">
                    <div class="status-table-wrap search-item">
                        <table class="approval-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ruangan</th>
                                    <th>Sub Bidang</th>
                                    <th>Bidang</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody id="tableBody">
                                @forelse ($transaksi as $t)
                                <tr data-status="{{ strtolower($t->status_peminjaman) }}">

                                    <td>{{ $loop->iteration }}</td>

                                    <td>{{ $t->ruangan->nama_ruangan ?? '-' }}</td>
                                    <td>{{ $t->bidang->sub_bidang ?? '-' }}</td>
                                    <td>{{ $t->bidang->bidang ?? '-' }}</td>



                                    <td class="text-center">
                                        <span class="badge-status {{ strtolower($t->status_peminjaman) }}">
                                            {{ $t->status_peminjaman }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @if (in_array($t->status_peminjaman, ['Menunggu', 'Disetujui']))
                                            <button class="btn-edit btn-open-modal"
                                                    data-id="{{ $t->id_peminjaman }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        @else
                                            <button class="btn-edit disabled" disabled>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        @endif
                                    </td>


                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Belum ada pengajuan peminjaman
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>
                                    
                    </div>
                </div>
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
    </div>
</section>
@endif

@if ($tab == 'form')
    @php
        $formAction = route('peminjaman.store');
    @endphp

    @include('partials.form-peminjaman', [
        'bidang' => $bidang,
        'ruangan' => $ruangan,
        'transaksi' => $transaksi
    ])
@endif


<!-- ================= MODAL DETAIL PEMINJAMAN ================= -->
<div class="modal-overlay" id="detailModal">

    <div class="modal-card">

        <!-- HEADER -->
        <div class="modal-header">
            <h4>Detail Pengajuan Peminjaman</h4>
            <button class="modal-close">&times;</button>
        </div>

        <div class="modal-body">

            <div class="modal-row">
                <label>Nama Acara</label><span>:</span>
                <input type="text" id="mAcara" readonly>
            </div>

            <div class="modal-row">
                <label>Jumlah Peserta</label><span>:</span>
                <input type="text" id="mPeserta" readonly>
            </div>

            <div class="modal-row">
                <label>Tanggal</label><span>:</span>
                <input type="text" id="mTanggal" readonly>
            </div>

            <div class="modal-row">
                <label>Waktu</label><span>:</span>
                <input type="text" id="mWaktu" readonly>
            </div>

            <div class="modal-row">
                <label>Bidang</label><span>:</span>
                <input type="text" id="mBidang" readonly>
            </div>

            <div class="modal-row">
                <label>Sub Bidang</label><span>:</span>
                <input type="text" id="mSubBidang" readonly>
            </div>

            <div class="modal-row">
                <label>Ruangan</label><span>:</span>
                <input type="text" id="mRuangan" readonly>
            </div>

            <div class="modal-row">
                <label>No WhatsApp</label><span>:</span>
                <input type="text" id="mWa" readonly>
            </div>

            <div class="modal-row textarea">
                <label>Catatan</label><span>:</span>
                <textarea id="mCatatan" readonly></textarea>
            </div>

            <div id="actionUpload" class="hidden mt-3">
            <p class="upload-label">Upload Foto Setelah Kegiatan</p>
            <!-- Upload Card -->
            <div id="uploadArea" class="upload-card hidden">

                <img src="/img/upload.png" class="upload-icon">

                <p class="upload-text">
                    Klik atau drag foto ke sini
                </p>

            </div>

            <!-- Preview -->
            <div id="fotoPreviewBox" class="mb-2"></div>

            <!-- Controls -->
            <div class="foto-actions">

                <input type="file" id="fotoKegiatan" accept="image/*" hidden>

                <button id="btnUploadFoto" class="btn-foto btn-upload hidden">
                    Upload Foto
                </button>

                <button id="btnGantiFoto" class="btn-foto btn-ganti hidden">
                    Ganti Foto
                </button>

                <button id="btnHapusFoto" class="btn-foto btn-hapus hidden">
                    Hapus Foto
                </button>


            </div>
        </div>


        </div>


        <div class="modal-footer">

            {{-- Approve / Reject --}}
            <div id="actionApprove" class="hidden">
                <button class="btn-approve">Setujui</button>
                <button class="btn-reject">Tolak</button>
            </div>

            {{-- Disabled --}}
            <div id="actionDisabled" class="hidden">
                <button disabled class="btn-disabled">
                    Tidak ada aksi
                </button>
            </div>

        </div>

    </div>


    </div>
</div>

<!-- ================= MODAL KONFIRMASI ================= -->
<div class="modal-overlay" id="confirmModal">

    <div class="modal-card modal-confirm">

        <!-- HEADER -->
        <div class="modal-header confirm-header">
            <h4>KONFIRMASI</h4>
        </div>

        <!-- BODY -->
        <div class="confirm-body">
            <p>Anda yakin dengan jawaban anda?</p>
        </div>

        <!-- FOOTER -->
        <div class="confirm-footer">
            <button class="btn-confirm-yes">Benar</button>
            <button class="btn-confirm-no">Batal</button>
        </div>

    </div>
</div>
@endsection