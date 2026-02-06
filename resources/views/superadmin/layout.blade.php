<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- GLOBAL --}}
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    {{-- PETUGAS --}}
    <link rel="stylesheet" href="{{ asset('css/superadmin.css') }}">

    {{-- FORM PEMIINJAMAN --}}
    <link rel="stylesheet" href="{{ asset('css/components/form-peminjaman.css') }}">

    {{-- JAVASCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script src="{{ asset('js/search.js') }}"></script>
    <script src="{{ asset('js/persetujuan-search.js') }}"></script>
    <script src="{{ asset('js/item.js') }}"></script>
    <script src="{{ asset('js/filter-item.js') }}"></script>
    <script src="{{ asset('js/unduh-item.js') }}"></script>
    <script src="{{ asset('js/pagination.js') }}"></script>
    <script src="{{ asset('js/card-denah.js') }}"></script>
    <script src="{{ asset('js/modal-ruangan.js') }}"></script>
    <script src="{{ asset('js/user-management.js') }}"></script>
    <script src="{{ asset('js/popup-persetujuan-MR.js') }}"></script>
    <script src="{{ asset('js/manajemen-peminjaman.js') }}"></script>
    <script src="{{ asset('js/peminjaman-waktu.js') }}"></script>
    <script src="{{ asset('js/peminjaman-form-tambah.js') }}"></script>
    <script src="{{ asset('js/edit_peminjaman.js') }}"></script>
    <script src="{{ asset('js/filter-dropdown.js') }}"></script>
    <script src="{{ asset('js/persetujuan.js') }}"></script>



</head>

<body>

{{-- Navbar --}}
@include('partials.navbar-superadmin')

<main>
    @yield('content')
</main>

{{-- Footer --}}
@include('partials.footer')

@stack('scripts')

</body>
</html>
