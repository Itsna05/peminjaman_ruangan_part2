@extends('petugas.layout')

@section('title', 'Denah Ruangan')

@section('content')

{{-- HEADER BACKGROUND --}}
<section class="dashboard-hero"></section>

{{-- HEADER INFO --}}
<section class="dashboard-info">
    <div class="container">
        <div class="info-box text-center">
            <h4 class="info-title">
                <span class="line"></span>
                Denah Ruangan
                <span class="line"></span>
            </h4>
            <p class="info-desc">
                Berikut merupakan data Denah Ruangan Kantor DPU BMCK Jateng
            </p>
        </div>
    </div>
</section>

{{-- DENAH EKSISTING --}}
<section class="denah-section">
    <div class="container">
        <div class="denah-card text-center">
            <h3 class="denah-title">Denah Eksisting Lantai 1</h3>
            <img src="{{ asset('img/denah_lantai1.png') }}" class="img-fluid">
        </div>
    </div>
</section>

{{-- DETAIL RUANGAN --}}
<section class="detail-ruangan-section">
    <div class="container">
        <h3 class="text-center fw-bold mb-5">Detail Ruangan</h3>

        {{-- SLIDER --}}
        <div class="ruangan-slider" id="ruanganSlider">
            <div class="ruangan-track">

                @foreach ($ruangan as $r)
                <div class="detail-card" id="detailCard-{{ $r->id_ruangan }}">

                    <div class="detail-card-header">DETAIL RUANGAN</div>

                    {{-- IMAGE --}}
                    <div class="detail-card-image">
                        @if ($r->gambar->count())

                            <div id="foto-ruangan-{{ $r->id_ruangan }}"
                                 class="carousel slide foto-carousel"
                                 data-bs-touch="false"
                                 data-bs-interval="false">

                                <div class="carousel-inner">
                                    @foreach ($r->gambar as $index => $g)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ asset('img/ruangan/'.$g->nama_file) }}">
                                        </div>
                                    @endforeach
                                </div>

                                <button class="carousel-control-prev"
                                        type="button"
                                        data-bs-target="#foto-ruangan-{{ $r->id_ruangan }}"
                                        data-bs-slide="prev">
                                </button>

                                <button class="carousel-control-next"
                                        type="button"
                                        data-bs-target="#foto-ruangan-{{ $r->id_ruangan }}"
                                        data-bs-slide="next">
                                </button>

                            </div>

                        @else
                            <img src="{{ asset('img/default_ruangan.png') }}" class="img-fluid">
                        @endif
                    </div>

                    {{-- BODY --}}
                    <div class="detail-card-body">
                        <h5 class="detail-card-title">{{ $r->nama_ruangan }}</h5>

                        <div class="detail-card-info">

                            {{-- ELEKTRONIK --}}
                            <div class="info-label">
                                <h6>Elektronik</h6>
                                <ul>
                                    @forelse ($r->sarana->where('jenis_sarana','elektronik') as $s)
                                        <li>{{ $s->nama_sarana }} : {{ $s->jumlah }}</li>
                                    @empty
                                        <li>-</li>
                                    @endforelse
                                </ul>
                            </div>

                            {{-- NON ELEKTRONIK --}}
                            <div class="info-label">
                                <h6>Non Elektronik</h6>
                                <ul>
                                    @forelse ($r->sarana->where('jenis_sarana','non-elektronik') as $s)
                                        <li>{{ $s->nama_sarana }} : {{ $s->jumlah }}</li>
                                    @empty
                                        <li>-</li>
                                    @endforelse
                                </ul>
                            </div>

                        </div>
                    </div>

                </div>
                @endforeach

            </div>
        </div>
    </div>
</section>
@endsection