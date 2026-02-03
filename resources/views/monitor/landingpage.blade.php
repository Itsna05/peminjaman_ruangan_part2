@extends('monitor.layout')

@section('title', 'Landing Page Monitor')

@section('content')

<main class="monitor-main">

    {{-- KIRI --}}
    <section class="monitor-card-harian">
        <h5 class="section-title">Jadwal Pemakaian Ruangan Hari Ini</h5>

        <div class="today-slider" id="todaySlider">
            <div class="today-card">
                <span class="badge-status red">SEDANG DIGUNAKAN</span>
                <h6>RUANG STUDIO</h6>
                <p><i class="bi bi-clock"></i> <small>WAKTU :</small> 10.00 - 12.00</p>
                <p><i class="bi bi-calendar2-event"></i><small> NAMA ACARA :</small><strong> Rapat Koordinasi</strong></p>
                <p><i class="bi bi-people"></i><small> BIDANG :</small> Bidang Pembangunan Jalan</p>
            </div>

            <div class="today-card">
                <span class="badge-status red">SEDANG DIGUNAKAN</span>
                <h6>RUANG STUDIO</h6>
                <p><i class="bi bi-clock"></i> <small>WAKTU :</small> 10.00 - 12.00</p>
                <p><i class="bi bi-calendar2-event"></i><small> NAMA ACARA :</small><strong> Rapat Koordinasi</strong></p>
                <p><i class="bi bi-people"></i><small> BIDANG :</small> Bidang Pembangunan Jalan</p>
            </div>

            <div class="today-card">
                <span class="badge-status red">SEDANG DIGUNAKAN</span>
                <h6>RUANG STUDIO</h6>
                <p><i class="bi bi-clock"></i> <small>WAKTU :</small> 10.00 - 12.00</p>
                <p><i class="bi bi-calendar2-event"></i><small> NAMA ACARA :</small><strong> Rapat Koordinasi</strong></p>
                <p><i class="bi bi-people"></i><small> BIDANG :</small>Bidang Pembangunan Jalan</p>
            </div>
        </div>
    </section>

    {{-- KANAN --}}
    <section class="monitor-card-mendatang">
        <h5 class="section-title">Jadwal Pemakaian Ruangan Mendatang</h5>

        <table class="monitor-table monitor-table-head">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>Ruangan</th>
                    <th>Nama Acara</th>
                    <th>Bidang</th>
                </tr>
            </thead>
        </table>

        <div class="table-body-wrapper">
            <table class="monitor-table">
                <tbody id="autoScrollTable">
                    <tr>
                        <td>15 Jan 2026<br>10.00–13.00</td>
                        <td>R. Rapat Barat II</td>
                        <td><strong>Rapat Bendungan</strong></td>
                        <td>Bidang Prancangan Jalan</td>
                    </tr>
                    <tr>
                        <td>16 Jan 2026<br>08.00–11.00</td>
                        <td>R. Rapat Barat II</td>
                        <td><strong>Evaluasi Proyek</strong></td>
                        <td>Bidang Prancangan Jalan</td>
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </section>


</main>



{{-- GALERI --}}
<section class="monitor-gallery">
    <h3 class="gallery-title">RUANGAN RAPAT</h3>

    <div class="gallery-slider" id="gallerySlider">
        <div class="slide active">
            <img src="{{ asset('img/ruang_studio.png') }}">
        </div>
        <div class="slide active">
            <img src="{{ asset('img/ruang_studio.png') }}">
        </div>
        <div class="slide active">
            <img src="{{ asset('img/ruang_studio.png') }}">
        </div>
        <div class="slide active">
            <img src="{{ asset('img/ruang_studio.png') }}">
        </div>
        <div class="slide active">
            <img src="{{ asset('img/ruang_studio.png') }}">
        </div>
        <div class="slide active">
            <img src="{{ asset('img/ruang_studio.png') }}">
        </div>
        <div class="slide active">
            <img src="{{ asset('img/ruang_studio.png') }}">
        </div>
        <div class="slide active">
            <img src="{{ asset('img/ruang_studio.png') }}">
        </div>
        <div class="slide active">
            <img src="{{ asset('img/ruang_studio.png') }}">
        </div>
        <div class="slide active">
            <img src="{{ asset('img/ruang_studio.png') }}">
        </div>
    </div>

    <div class="gallery-indicator">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</section>


@endsection