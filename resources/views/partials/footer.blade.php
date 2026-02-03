<footer class="footer-dinas text-white pt-5">
    <div class="container">
        <div class="row gy-4">

            {{-- Logo & Alamat --}}
            <div class="col-md-4">
                <img src="{{ asset('img/logo_nav.png') }}"
                    alt="Logo DPU"
                class="footer-logo img-fluid">

                <p class="small mb-1">
                    Jl. Madukoro Blok AA-BB, Tawangmas, Kec.
                </p>
                <p class="small mb-1">
                    Semarang Barat, Kota Semarang, Provinsi
                </p>
                <p class="small mb-1">
                    Jawa Tengah, Kode Pos (50144)
                </p>
                <p class="small mb-1">
                    Telp/Fax: (024) 7608368
                </p>
                <p class="small mb-1">
                    Faksimil. (024) 7613181
                </p>
                <p class="small mb-1">
                    Email : dpubinmarcipka@jatengprov.go.id
                </p>
                <p class="small mb-1">
                    dpubmckjateng@gmail.com
                </p>

                {{-- WA Center --}}
                <a href="https://wa.me/6281325511513"
                   target="_blank"
                   class="btn btn-warning btn-sm mt-3">
                    SMS Center/WA Center
                </a>
            </div>

            {{-- Layanan --}}
            <div class="col-md-3">
                <h6 class="fw-semibold mb-3">LAYANAN</h6>
                <ul class="list-unstyled small footer-link">

                    @if (session()->has('role') && session('role') === 'petugas')
                        <li>
                            <a href="{{ route('petugas.peminjaman') }}">
                                Peminjaman Ruangan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('petugas.dashboard') }}">
                                Jadwal Rapat
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('petugas.denah') }}">
                                Fasilitas
                            </a>
                        </li>

                    @elseif (session()->has('role') && session('role') === 'superadmin')
                        <li>
                            <a href="{{ route('superadmin.manajemen-peminjaman') }}">
                                Manajemen Peminjaman
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('superadmin.manajemen-ruangan') }}">
                                Manajemen Ruangan
                            </a>
                        </li>
                    @endif

                </ul>
            </div>


            {{-- Bantuan --}}
            <div class="col-md-3">
                <h6 class="fw-semibold mb-3">BANTUAN</h6>
                <ul class="list-unstyled small footer-link">
                    <li><a href="{{ route('shared.kontak') }}">FAQ</a></li>
                    <li><a href="{{ route('shared.kontak') }}">Kontak Admin</a></li>
                </ul>
            </div>

            {{-- Legal --}}
            <div class="col-md-2">
                <h6 class="fw-semibold mb-3">LEGAL</h6>
                <ul class="list-unstyled small footer-link">
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                </ul>
            </div>

        </div>

        {{-- Divider --}}
        <hr class="border-light my-4">

        {{-- Copyright & Sosmed --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap small">
            <span>
                Copyright © 2018 | DPU Bina Marga dan Cipta Karya. All rights reserved.
            </span>

            {{-- Sosial Media --}}
            <div class="d-flex gap-3 footer-social">
                <a href="https://www.tiktok.com/@dpubmckjateng?_r=1&_t=ZS-9307P9rgOns" target="_blank">
                    <i class="bi bi-tiktok"></i>
                </a>
                <a href="https://www.instagram.com/dpubmckjateng?igsh=MXMyODkzaHhucHpxZg==" target="_blank">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://www.facebook.com/share/1GRdgNWZMK/" target="_blank">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://x.com/dpubmckjateng" target="_blank">
                    <i class="bi bi-twitter-x"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
