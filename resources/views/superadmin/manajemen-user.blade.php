@extends('superadmin.layout')

@section('title', 'Manajemen User')

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
                Bidang Pegawai
                <span class="line"></span>
            </h4>

            <p class="info-desc">
                 Daftar bidang dan sub bidang pegawai pada Dinas Pekerjaan Umum Bina Marga dan Cipta Karya.
            </p>

        </div>
    </div>
</section>

{{-- =======================
   BIDANG PEGAWAI (STATIS)
   ======================= --}}
<section class="container my-5 user-bidang-section user-table-wrapper">
        <div class="d-flex justify-content-between mb-3 user-bidang-toolbar">
            <div class="search-box">
                <button type="button" class="search-btn">
                    <i class="bi bi-search"></i>
                </button>
                <input type="text" placeholder="Pencarian" id="searchBidang">
            </div>

            <button class="tambah-btn" type="button" id="tambahToggle"
                data-bs-toggle="modal"
                data-bs-target="#modalTambahBidang">
                    Tambah
                    <i class="bi bi-plus-circle"></i>
            </button>
        </div>
        <div>
            <div class="search-item">
                <table class="approval-table user-table">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="50">No</th>
                            <th>Bidang</th>
                            <th>Sub Bidang</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse ($bidangPegawai as $index => $bidang)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $bidang->bidang }}</td>
                                <td>{{ $bidang->sub_bidang }}</td>
                                <td class="text-center">
                                    <button
                                        class="btn btn-sm btn-primary btn-edit-bidang"
                                        data-id="{{ $bidang->id_bidang }}"
                                        data-bidang="{{ $bidang->bidang }}"
                                        data-sub="{{ $bidang->sub_bidang }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalEditBidang"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Data bidang pegawai belum tersedia
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
            
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

{{-- =======================
   USER (DINAMIS)
   ======================= --}}
<section class="dashboard-info">
    <div class="container">
        <div class="info-box text-center">

            <h4 class="info-title">
                <span class="line"></span>
                User
                <span class="line"></span>
            </h4>

            <p class="info-desc">
                Daftar akun Super Admin dan Petugas yang terdaftar dalam sistem.
            </p>

        </div>
    </div>
</section>

<section class="container mb-5 user-section">

    <div class="card shadow-sm border-0 user-card user-table-wrapper">

            <div class="d-flex justify-content-between mb-3 user-toolbar">
                <div class="search-box">
                    <button type="button" class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                    <input type="text" placeholder="Pencarian" id="searchUser">
                </div>

                <div class="d-flex gap-2">
                    <div class="user-filter-box">
                        <button class="user-filter-btn" type="button" id="filterToggle">
                            Filter
                            <span class="arrow">▾</span>
                        </button>

                        <div class="filter-dropdown" id="filterDropdown">
                            <button class="filter-item fw-bold" data-value="">Semua</button>
                            <button class="filter-item fw-bold" data-value="superadmin">Super Admin</button>
                            <button class="filter-item fw-bold" data-value="petugas">Petugas</button>
                        </div>
                    </div>


                    <button class="tambah-btn" type="button" id="tambahToggle"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTambahUser">
                        Tambah
                        <i class="bi bi-plus-circle"></i>
                    </button>

                </div>
            </div>

            <div class="user-table-responsive">
                <div class="user-table-responsive">
                    <table class="table table-bordered align-middle user-table">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="50">No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Peran</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableBody">
                            @forelse ($users as $index => $user)
                                <tr data-role="{{ $user->role }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>{{ $user->nama }}</td>
                                    <td>{{ $user->username }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <button
                                            class="btn btn-sm btn-primary btn-edit-user"
                                            data-id="{{ $user->id_user }}"
                                            data-nama="{{ $user->nama }}"
                                            data-username="{{ $user->username }}"
                                            data-role="{{ $user->role }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEditUser"
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Data user belum tersedia
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

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

{{-- =======================
   MODAL TAMBAH PENGGUNA
   ======================= --}}
<div class="modal fade" id="modalTambahBidang" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">

            {{-- HEADER --}}
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Tambah Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            {{-- FORM --}}
            <form action="{{ route('superadmin.bidang.store') }}" method="POST">
            @csrf

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Bidang</label>
                    <input type="text" name="bidang" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Sub Bidang</label>
                    <input type="text" name="sub_bidang" class="form-control" required>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                <button class="btn btn-success">Simpan</button>
            </div>
            </form>


        </div>
    </div>
</div>

<div class="modal fade" id="modalEditBidang" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Bidang</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('superadmin.bidang.update') }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="id_bidang" id="editIdBidang">

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Bidang</label>
                        <input type="text" name="bidang" id="editBidang" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Sub Bidang</label>
                        <input type="text" name="sub_bidang" id="editSubBidang" class="form-control">
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>


{{-- =======================
   MODAL TAMBAH USER
   ======================= --}}
<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            {{-- HEADER --}}
            <div class="modal-header border-bottom">
                <h5 class="modal-title fw-bold">Tambah Pengguna</h5>
                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"></button>
            </div>

            {{-- FORM --}}
            <form action="{{ route('superadmin.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    {{-- NAMA --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text"
                               name="nama"
                               class="form-control"
                               placeholder="Masukkan nama lengkap"
                               required>
                    </div>

                    {{-- USERNAME --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username</label>
                        <input type="text"
                               name="username"
                               class="form-control"
                               placeholder="Masukkan username"
                               required>
                    </div>

                    {{-- PASSWORD --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password</label>

                        <div class="input-group">
                            <input
                                type="password"
                                name="password"
                                class="form-control password-input"
                                placeholder="Masukkan password"
                                required
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary toggle-password"
                            >
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>



                    {{-- PERAN --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Peran</label>
                        <select name="role" class="form-select" required>
                            <option value="">Pilih peran</option>
                            <option value="superadmin">Super Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer border-top d-flex justify-content-end gap-2">
                    <button type="button"
                            class="btn btn-danger px-4"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-success px-4">
                        Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="modalEditUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit User</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('superadmin.user.update') }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="id_user" id="editUserId">

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" id="editUserNama" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" id="editUserUsername" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Peran</label>
                        <select name="role" id="editUserRole" class="form-select">
                            <option value="superadmin">Super Admin</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success">Update</button>
                </div>

            </form>
        </div>
    </div>
</div>


@push('scripts')
<script src="{{ asset('js/user-search.js') }}"></script>
@endpush
@endsection
