{{-- =======================
   ISI PEMINJAMAN
   ======================= --}}
<section>
    <div class="container">

        {{-- FORM PEMINJAMAN --}}
        <div class="form-wrapper">
            <h4 class="form-title text-center">
                Form Peminjaman Ruangan
            </h4>

            <form method="POST" action="{{ $formAction ?? route('peminjaman.store') }}">
                @csrf
                <div class="row g-4">

                    <div class="col-md-6">
                        <label class="form-label">Nama Acara <span class="text-danger">*</span></label>
                        <input type="text" name="acara" class="form-control" placeholder="Masukkan Nama Acara" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jumlah Peserta <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah_peserta" class="form-control" placeholder="Masukkan Jumlah Peserta" required>
                    </div>

                    <div class="col-12">

                    <label class="form-label">
                        Waktu Peminjaman <span class="text-danger">*</span>
                    </label>

                    <div class="waktu-flex">

                        <!-- MULAI -->
                        <div class="waktu-blok">
                            <small class="text-muted">Mulai</small>

                            <div class="waktu-row">
                                <input
                                    type="date"
                                    id="tgl_mulai"
                                    required
                                    class="form-control"
                                    onchange="gabungWaktu()">

                                <input
                                    type="time"
                                    id="jam_mulai"
                                    required
                                    class="form-control waktu-jam"
                                    onchange="gabungWaktu()">
                            </div>
                        </div>

                        <span class="waktu-sep">~</span>

                        <!-- SELESAI -->
                        <div class="waktu-blok">
                            <small class="text-muted">Selesai</small>

                            <div class="waktu-row">
                                <input
                                    type="date"
                                    id="tgl_selesai"
                                    required
                                    class="form-control"
                                    onchange="gabungWaktu()">

                                <input
                                    type="time"
                                    id="jam_selesai"
                                    required
                                    class="form-control waktu-jam"
                                    onchange="gabungWaktu()">
                            </div>
                        </div>

                    </div>
                </div>



                    <input type="hidden" name="waktu_mulai" id="waktu_mulai" required>
                    <input type="hidden" name="waktu_selesai" id="waktu_selesai" required>


                    <div class="col-md-6">
                        <label class="form-label">Bidang <span class="text-danger">*</span></label>
                        <select name="bidang" id="bidang" class="form-select" required>
                            <option value="" disabled selected hidden>Pilih Bidang</option disabled>
                            @foreach ($bidang as $b)
                                <option value="{{ $b->bidang }}">
                                    {{ $b->bidang }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label">Sub Bidang <span class="text-danger">*</span></label>
                        <select name="sub_bidang" id="sub_bidang" class="form-select" required>
                            <option value="" disabled selected hidden>Pilih Sub Bidang</option>
                            <option value="">Pilih Sub Bidang</option disabled>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Ruangan <span class="text-danger">*</span></label >
                        <select name="id_ruangan" class="form-select" required>
                            <option value="" disabled selected hidden>Pilih Ruangan</option>
                            @foreach ($ruangan as $r)
                                <option value="{{ $r->id_ruangan }}">
                                    {{ $r->nama_ruangan }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label class="form-label">Nomor WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="no_wa" class="form-control" placeholder="Masukkan Nomor WhatsApp" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control textarea-catatan" rows="3"
                            placeholder="Tambahkan Catatan Internal Jika diperlukan" name="catatan"></textarea>
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn-ajukan" onclick="gabungWaktu()">
                            Ajukan Peminjaman
                        </button>
                    </div>

                </div>
            </form>
        </div>

        {{-- STATUS PEMINJAMAN --}}
        <div class="status-wrapper">
            <h4 class="status-title text-center">
                Status Peminjaman Ruangan
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
                </div>

                {{-- TABLE --}}
                <div class="table-responsive table-scroll-x search-item ">
                    <table class="status-table">
                        <colgroup>
                            <col style="width:50px">     <!-- No -->
                            <col style="width:160px">    <!-- Nama Ruangan -->
                            <col>                        <!-- Acara (fleksibel) -->
                            <col style="width:180px">    <!-- Waktu -->
                            <col style="width:220px">    <!-- Bidang -->
                            <col style="width:140px">    <!-- No WA -->
                            <col style="width:160px">    <!-- Status -->
                            <col style="width:80px">     <!-- Aksi -->
                        </colgroup>

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ruangan</th>
                                <th>Acara</th>
                                <th>Waktu</th>
                                <th>Bidang</th>
                                <th>No WhatsApp</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody">
                            @forelse ($transaksi as $item)
                                <tr data-status="{{ strtolower($item->status_peminjaman) }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->ruangan?->nama_ruangan ?? '-' }}</td>
                                    <td>{{ $item->acara }}</td>
                                    <td>
                                        <div class="tanggal">
                                            {{ \Carbon\Carbon::parse($item->waktu_mulai)->translatedFormat('d F Y') }}
                                        </div>
                                        <div class="jam">
                                            {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}
                                            -
                                            {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }} WIB
                                        </div>
                                    </td>

                                    <td>
                                        <div class="bidang-nama">
                                            {{ $item->bidang?->bidang ?? '-' }}
                                        </div>
                                        <div class="sub-bidang">
                                            {{ $item->bidang?->sub_bidang ?? '-' }}
                                        </div>
                                    </td>

                                    
                                    <td>{{ $item->no_wa }}</td>

                                    <td class="text-center">
                                        <span class="badge-status {{ strtolower($item->status_peminjaman) }}">
                                            {{ $item->status_peminjaman }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @if ($item->status_peminjaman === 'Menunggu')
                                            <button class="btn-aksi btn-edit"
                                                data-bs-toggle="modal"
                                                data-bs-target="#modalEditPeminjaman"
                                                data-id="{{ $item->id_peminjaman }}">
                                                ✎
                                            </button>
                                        @else
                                            <button class="btn-aksi disabled" disabled>✎</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
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
    </div> 

{{-- MODAL EDIT PEMINJAMAN --}}
<div class="modal fade" id="modalEditPeminjaman" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content modal-custom">

            {{-- HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title mx-auto text-white fw-bold">
                    Form Peminjaman Ruangan
                </h5>
                <button type="button" class="btn-close btn-close-custom" data-bs-dismiss="modal"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">
                <form id="formEditPeminjaman">
                    @csrf
                    <input type="hidden" id="edit_id">

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nama Acara</label>
                            <input type="text" name="acara" class="form-control edit-field">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jumlah Peserta</label>
                            <input type="number" name="jumlah_peserta" class="form-control edit-field">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Waktu Peminjaman</label>
                            <div class="waktu-wrapper">
                                <input type="date" id="edit_tgl_mulai" class="form-control edit-field">
                                <input type="time" id="edit_jam_mulai" class="form-control edit-field">
                                <span class="separator">~</span>
                                <input type="date" id="edit_tgl_selesai" class="form-control edit-field">
                                <input type="time" id="edit_jam_selesai" class="form-control edit-field">
                            </div>
                        </div>

                        <input type="hidden" name="waktu_mulai" id="edit_waktu_mulai">
                        <input type="hidden" name="waktu_selesai" id="edit_waktu_selesai">

                        <div class="col-md-6">
                            <label class="form-label">Bidang</label>
                            <select name="bidang" id="edit_bidang" class="form-select edit-field">
                                @foreach($bidang as $b)
                                    <option value="{{ $b->bidang }}">{{ $b->bidang }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Sub Bidang</label>
                            <select name="sub_bidang" id="edit_sub_bidang" class="form-select edit-field">
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Ruangan</label>
                            <select name="id_ruangan" id="edit_ruangan" class="form-select edit-field">
                                @foreach($ruangan as $r)
                                    <option value="{{ $r->id_ruangan }}">{{ $r->nama_ruangan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Nomor WhatsApp</label>
                            <input type="text" name="no_wa" class="form-control edit-field">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Catatan</label>
                            <textarea name="catatan" class="form-control edit-field"></textarea>
                        </div>

                    </div>
                </form>
            </div>

            {{-- FOOTER --}}
            <div class="modal-footer modal-footer-custom">
                <div id="footerView" class="footer-actions">
                    <button class="btn btn-primary" id="btnEdit">Edit</button>
                    <button class="btn btn-danger" id="btnBatalkanPeminjaman">Batalkan Peminjaman</button>
                </div>

                <div id="footerEdit" class="footer-actions d-none">
                    <button class="btn btn-success" id="btnSimpan">Simpan</button>
                    <button class="btn btn-secondary" id="btnBatal">Batal</button>
                </div>
            </div>

        </div>
    </div>
</div>