<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- GLOBAL --}}
    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    {{-- PETUGAS --}}
    <link rel="stylesheet" href="{{ asset('css/petugas.css') }}">

    {{-- JAVASCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/dashboard-calendar.js') }}"></script>
    <script src="{{ asset('js/faq.js') }}"></script>

</head>
<body>

{{-- Navbar --}}
@if(session('role') === 'petugas')
    @include('partials.navbar-petugas')
@elseif(session('role') === 'superadmin')
    @include('partials.navbar-superadmin')
@endif

<main>
    @yield('content')
</main>

{{-- Footer --}}
@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const slider = document.querySelector('.ruangan-slider');

function updateActiveCard() {
    const cards = document.querySelectorAll('.detail-card');
    let center = slider.scrollLeft + slider.offsetWidth / 2;

    cards.forEach(card => {
        const cardCenter = card.offsetLeft + card.offsetWidth / 2;
        const distance = Math.abs(center - cardCenter);

        card.classList.toggle('is-active', distance < card.offsetWidth / 2);
    });
}

slider.addEventListener('scroll', () => requestAnimationFrame(updateActiveCard));
updateActiveCard();
</script>
</body>
</html>
