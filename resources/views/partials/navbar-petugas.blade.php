<nav class="navbar navbar-expand-lg navbar-dark navbar-petugas px-4">
    <div class="container-fluid">

        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center gap-2" href="/monitor">
            <img src="{{ asset('img/logo_nav.png') }}" alt="Logo" height="38">
        </a>

        {{-- TOGGLER (MUNCUL DI MOBILE SAJA) --}}
        <button class="navbar-toggler d-lg-none" type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasPetugas">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- MENU DESKTOP --}}
        <div class="collapse navbar-collapse d-none d-lg-flex justify-content-end">
            <ul class="nav nav-underline align-items-center gap-3">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"
                       href="{{ route('petugas.dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('petugas.denah') ? 'active' : '' }}"
                    href="{{ route('petugas.denah') }}">
                        Denah Ruangan
                    </a>
                </li>

                

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('petugas.peminjaman') ? 'active' : '' }}"
                    href="{{ route('petugas.peminjaman') }}">
                        Peminjaman Ruangan
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('shared.kontak') ? 'active' : '' }}"
                    href="{{ route('shared.kontak') }}">
                        Kontak
                    </a>
                    
                </li>

            </ul>

            {{-- Logout DESKTOP --}}
            <form action="{{ route('logout') }}" method="POST" class="ms-3">
                @csrf
                <button type="submit" class="btn btn-logout">
                    <i class="bi bi-arrow-right-circle"></i>
                </button>
            </form>

        </div>

    </div>
</nav>

{{-- OFFCANVAS MOBILE ONLY --}}
<div class="offcanvas offcanvas-end navbar-petugas d-lg-none" id="offcanvasPetugas">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-white">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body nav-menu-wrapper">

        <ul class="nav nav-underline flex-column gap-2 mb-3">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}"
                   href="{{ route('petugas.dashboard') }}">
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('petugas.denah') ? 'active' : '' }}"
                    href="{{ route('petugas.denah') }}">
                     Denah Ruangan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('petugas.peminjaman') ? 'active' : '' }}"
                    href="{{ route('petugas.peminjaman') }}">
                    Peminjaman Ruangan
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('shared.kontak') ? 'active' : '' }}"
                    href="{{ route('shared.kontak') }}">Kontak</a>
            </li>

            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link">
                        Logout
                    </button>
                </form>
            </li>

        </ul>
    </div>
</div>