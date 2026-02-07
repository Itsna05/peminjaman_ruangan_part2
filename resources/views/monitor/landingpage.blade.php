@extends('monitor.layout')

@section('title', 'Landing Page Monitor')

@section('content')

<main class="monitor-main">

    {{-- KIRI --}}
    <section class="monitor-card-harian">
        <h5 class="section-title">Jadwal Pemakaian Ruangan Hari Ini</h5>

        <div class="today-slider" id="todaySlider">


    @forelse($hariIni as $item)

        @php
            $now = now();
            $status = ($now >= $item->waktu_mulai && $now <= $item->waktu_selesai)
                        ? 'SEDANG DIGUNAKAN'
                        : 'MENUNGGU';
        @endphp

        <div class="today-card">

            <span class="badge-status red">
                {{ $status }}
            </span>

            <h6>{{ strtoupper($item->nama_ruangan) }}</h6>

            <p>
                <i class="bi bi-clock"></i>
                <small>WAKTU :</small>
                {{ date('H:i', strtotime($item->waktu_mulai)) }}
                -
                {{ date('H:i', strtotime($item->waktu_selesai)) }}
            </p>

            <p>
                <i class="bi bi-calendar2-event"></i>
                <small> NAMA ACARA :</small>
                <strong>{{ $item->acara }}</strong>
            </p>

            <p>
                <i class="bi bi-people"></i>
                <small> BIDANG :</small>
                {{ $item->bidang }}
            </p>

        </div>

    @empty

        <p class="text-center">Tidak ada jadwal hari ini</p>

    @endforelse

</div>


        <!-- <div class="today-slider" id="todaySlider">
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
        </div> -->
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

                    @forelse($mendatang as $item)

                    <tr>

                        <td>
                            {{ date('d M Y', strtotime($item->waktu_mulai)) }}<br>
                            {{ date('H:i', strtotime($item->waktu_mulai)) }}
                            –
                            {{ date('H:i', strtotime($item->waktu_selesai)) }}
                        </td>

                        <td>{{ $item->nama_ruangan }}</td>

                        <td>
                            <strong>{{ $item->acara }}</strong>
                        </td>

                        <td>{{ $item->bidang }}</td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada jadwal
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>
        </div>
    </section>


</main>



{{-- GALERI --}}
<section class="monitor-gallery">
    <h3 class="gallery-title">RUANGAN RAPAT</h3>
    <div class="gallery-slider" id="gallerySlider">

@foreach($galeri as $g)

    <div class="slide {{ $loop->first ? 'active' : '' }}">



        <img src="{{ asset('img/ruangan/'.$g->nama_file) }}"
             class="gallery-img"
             alt="{{ $g->nama_ruangan }}">

    </div>

@endforeach

</div>


    <!-- <div class="gallery-slider" id="gallerySlider">
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
    </div> -->


    <div class="gallery-indicator">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</section>


@endsection

