<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Pusat Informasi Ruangan')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- CSS MONITOR --}}
    <link rel="stylesheet" href="{{ asset('css/monitor.css') }}">
</head>

<body class="monitor-body">

<header class="monitor-header">
    <a class="header-left" href="/petugas/dashboard">
        <img src="{{ asset('img/logo_nav.png') }}" class="logo">
    </a>


    <div class="header-center">
        <h4>PUSAT INFORMASI RUANGAN</h4>
    </div>

    <div class="header-right">
        <h4 id="clock">00:00:00</h4>
        <small id="date">-</small>
    </div>
</header>

<main class="monitor-content">
    @yield('content')
</main>

<script src="{{ asset('js/monitor-clock.js') }}"></script>
<script src="{{ asset('js/monitor-slider.js') }}"></script>
<script src="{{ asset('js/monitor-table-scroll.js') }}"></script>
<script src="{{ asset('js/monitor-gallery.js') }}"></script>



</body>
</html>
