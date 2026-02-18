@extends('shared.layout')

@section('title', 'Kontak')

@section('content')

{{-- =======================
   HERO
   ======================= --}}
<section class="dashboard-hero"></section>

{{-- =======================
   JUDUL HALAMAN
   ======================= --}}
<section class="dashboard-info">
    <div class="container">
        <div class="info-box text-center">

            <h4 class="info-title">
                <span class="line"></span>
                Kontak
                <span class="line"></span>
            </h4>

            <p class="info-desc">
                Halaman ini menyediakan informasi kontak resmi pengelolaan sistem<br>
                peminjaman ruangan DPU Bina Marga dan Cipta Karya Provinsi Jawa Tengah.
            </p>

        </div>
    </div>
</section>

{{-- =======================
   ISI KONTAK
   ======================= --}}
<section class="dashboard-content">
    <div class="container">
        <div class="row g-4">

            {{-- =======================
               KIRI (MAPS + FAQ)
               ======================= --}}
            <div class="col-lg-8">

                {{-- MAPS --}}
                <div class="contact-card mb-4">
                    <h4 class="contact-title fw-bold">
                        <i class="bi bi-map"></i> Maps
                    </h4>

                    <iframe
                        src="https://www.google.com/maps?q=DPU%20Bina%20Marga%20dan%20Cipta%20Karya%20Jawa%20Tengah&output=embed"
                        width="100%"
                        height="260"
                        style="border:0;"
                        allowfullscreen
                        loading="lazy">
                    </iframe>
                </div>

                {{-- FAQ --}}
                <div class="contact-card faq-card">

                    <div class="faq-header d-flex justify-content-between align-items-center mb-3">
                        <h4 class="contact-title fw-bold">
                            <i class="bi bi-question-lg"></i> Pertanyaan Umum (FAQ)
                        </h4>

                        @if(session('role') == 'superadmin')
                            <button id="btnKelolaFaq" class="kelola-btn">
                                Kelola FAQ
                            </button>
                        @endif
                    </div>
                    {{-- FAQ MODE VIEW --}}
                    <div id="faqViewMode">
                    <details class="faq-item">
                        <summary>Bagaimana cara membatalkan pesanan ruangan?</summary>
                        <p>
                            Pembatalan peminjaman dapat dilakukan melalui sistem
                            sebelum jadwal penggunaan ruangan berlangsung.
                        </p>
                    </details>

                    <details class="faq-item">
                        <summary>Bagaimana jika terjadi masalah saat rapat?</summary>
                        <p>
                            Silakan menghubungi petugas atau pengelola ruangan
                            yang bertugas.
                        </p>
                    </details>

                    <details class="faq-item">
                        <summary>Apakah ada layanan konsumsi?</summary>
                        <p>
                            Layanan konsumsi tersedia sesuai kebijakan instansi
                            dan permohonan peminjaman.
                        </p>
                    </details>
                </div>

                {{-- FAQ MODE EDIT--}}
                @if(session('role') == 'superadmin')

                <div id="faqEditMode" style="display: none;">

                    <div class="d-flex justify-content-end mb-3 gap-2">
                        <button id="btnTambahFaq" class="btn-tambah">+ Tambah FAQ</button>
                        <button id="btnSimpanFaq" class="btn-simpan">Simpan</button>
                        <button id="btnBatalFaq" class="btn-batal">Batal</button>
                    </div>

                    <div class="faq-edit-item border p-3 mb-3 rounded position-relative">
                        <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2">
                            <i class="bi bi-trash"></i>
                        </button>

                        <label class="form-label">Pertanyaan</label>
                        <input type="text" class="form-control mb-2">
                        <label class="form-label">Jawaban</label>
                        <textarea class="form-control" rows="3"></textarea>
                    </div>

                </div>

                @endif

                </div>
            </div>

            {{-- =======================
               KANAN (ALAMAT)
               ======================= --}}
            <div class="col-lg-4">
                <div class="contact-card">

                    <h4 class="contact-title fw-bold">Alamat Kantor</h6>

                    <div class="contact-info">
                        <i class="bi bi-map"></i>
                        <div>
                            <strong>Lokasi</strong>
                            <p>
                                Jl. Madukoro Blok AB-38, Tawangsari,<br>
                                Kec. Semarang Barat, Kota Semarang,<br>
                                Provinsi Jawa Tengah (50144)
                            </p>
                        </div>
                    </div>

                    <div class="contact-info">
                        <i class="bi bi-telephone"></i>
                        <div>
                            <strong>Telepon & Fax</strong>
                            <p>
                                Telepon: (024) 7600380<br>
                                Faksimile: (024) 7613881
                            </p>
                        </div>
                    </div>

                    <div class="contact-info">
                        <i class="bi bi-envelope"></i>
                        <div>
                            <strong>Email</strong>
                            <p>dpubimargajtg@jatengprov.go.id</p>
                        </div>
                    </div>

                    <div class="contact-info">
                        <i class="bi bi-globe"></i>
                        <div>
                            <strong>Website</strong>
                            <p>
                                <a href="https://dpubimargajtg.jatengprov.go.id"
                                target="_blank"
                                class="website-link">
                                https://dpubimargajtg.jatengprov.go.id
                                </a>
                            </p>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </div>
</section>

@endsection
