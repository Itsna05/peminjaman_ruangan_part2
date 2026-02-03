@extends('petugas.layout')

@section('title', 'Dashboard Petugas')

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
                Informasi Peminjaman Ruangan
                <span class="line"></span>
            </h4>

            <p class="info-desc">
                Peminjaman ruangan hanya dapat digunakan apabila telah memperoleh persetujuan resmi
                dari pihak terkait sesuai alur yang ditetapkan oleh Dinas Pekerjaan Umum Bina Marga
                dan Cipta Karya (DPU BMCK) Provinsi Jawa Tengah. Penggunaan ruangan wajib mematuhi
                ketentuan jam operasional, kapasitas ruangan, serta menjaga kebersihan, ketertiban,
                dan keamanan fasilitas selama kegiatan berlangsung.
            </p>

        </div>
    </div>
</section>


{{-- =======================
   RUNNING TEXT
   ======================= --}}
<div class="running-text">
    <marquee>
        @if ($eventsMonth->count())
            @foreach ($eventsMonth as $event)
                {{ strtoupper($event->acara) }}
                ({{ $event->waktu_mulai->translatedFormat('d M') }})
                &nbsp; • &nbsp;
            @endforeach
        @else
            TIDAK ADA KEGIATAN PADA BULAN
            {{ mb_strtoupper($currentDate->translatedFormat('F Y'), 'UTF-8') }}
        @endif
    </marquee>
</div>



{{-- =======================
   KALENDER & DATA KEGIATAN
   ======================= --}}
<section class="dashboard-content">
    <div class="container">
        <div class="row g-4">

            {{-- =======================
            KALENDER (KIRI)
            ======================= --}}
            <div class="col-lg-8">
                <div class="calendar-card">

                    {{-- HEADER KALENDER --}}
                    @php
                        $prevMonth = $currentDate->copy()->subMonthNoOverflow();
                        $nextMonth = $currentDate->copy()->addMonthNoOverflow();
                    @endphp

                    <div class="calendar-header d-flex align-items-center justify-content-center gap-3">
                        <a href="{{ route('petugas.dashboard', [
                            'month' => $prevMonth->month,
                            'year'  => $prevMonth->year
                        ]) }}" class="btn btn-sm btn-primary">&lt;</a>

                        <form method="GET" action="{{ route('petugas.dashboard') }}"
                            class="d-flex align-items-center gap-2">

                            <select name="month" class="form-select form-select-sm" style="min-width: 150px; padding-right: 38px;">
                                @foreach ([1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
                                        5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
                                        9=>'September',10=>'Oktober',11=>'November',12=>'Desember'] as $num => $name)
                                    <option value="{{ $num }}" {{ $currentDate->month == $num ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="year" class="form-select form-select-sm" style="min-width: 100px; padding-right: 20px;">
                                @for ($y = now()->year - 5; $y <= now()->year + 5; $y++)
                                    <option value="{{ $y }}" {{ $currentDate->year == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>

                            <button type="submit" class="btn btn-sm btn-warning fw-semibold">OK</button>
                        </form>

                        <a href="{{ route('petugas.dashboard', [
                            'month' => $nextMonth->month,
                            'year'  => $nextMonth->year
                        ]) }}" class="btn btn-sm btn-primary">&gt;</a>
                    </div>

                    {{-- GRID KALENDER --}}
                    @php
                        $startCalendar = $currentDate->copy()->startOfMonth()->startOfWeek(Carbon\Carbon::MONDAY);
                        $endCalendar   = $currentDate->copy()->endOfMonth()->endOfWeek(Carbon\Carbon::SUNDAY);
                    @endphp

                    <div class="calendar-grid">
                        @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                            <div class="calendar-day">{{ $day }}</div>
                        @endforeach

                        @for ($date = $startCalendar; $date <= $endCalendar; $date->addDay())
                            @php
                                $eventsOnDate = $eventsMonth->filter(fn($e) =>
                                    $e->waktu_mulai->toDateString() === $date->toDateString()
                                );
                            @endphp

                            <div class="calendar-date
                                {{ $date->month != $currentDate->month ? 'text-muted' : '' }}
                                {{ $eventsOnDate->count() ? 'active-event' : '' }}">
                                <span class="date-number">{{ $date->day }}</span>

                                @foreach ($eventsOnDate as $event)
                                    <div class="event event-clickable"
                                        data-id="{{ $event->id_peminjaman }}">
                                        <small>
                                            {{ $event->acara }}<br>
                                            {{ $event->waktu_mulai->format('H:i') }} -
                                            {{ $event->waktu_selesai->format('H:i') }}
                                        </small>
                                    </div>
                                @endforeach
                            </div>
                        @endfor
                    </div>

                </div> {{-- calendar-card --}}
            </div> {{-- col-lg-8 --}}

            {{-- =======================
            PANEL KANAN
            ======================= --}}
            <div class="col-lg-4">
                <div class="event-info-card">
                    <h6 class="event-info-title">Data kegiatan berlangsung hari ini</h6>

                    @forelse ($eventsToday as $event)
                        <div class="event-info-item">
                            <strong>Nama Acara</strong>
                            <p>{{ $event->acara }}</p>
                        </div>

                        <div class="event-info-item">
                            <strong>Jumlah Peserta</strong>
                            <p>{{ $event->jumlah_peserta }} orang</p>
                        </div>

                        <div class="event-info-item">
                            <strong>Waktu</strong>
                            <p>{{ $event->waktu_mulai->format('H:i') }} -
                            {{ $event->waktu_selesai->format('H:i') }}</p>
                        </div>

                        <div class="event-info-item">
                            <strong>Bidang</strong>
                            <p>{{ $event->bidang->bidang ?? '-' }}</p>
                        </div>

                        <div class="event-info-item">
                            <strong>Sub Bidang</strong>
                            <p>{{ $event->bidang->sub_bidang ?? '-' }}</p>
                        </div>

                        <div class="event-info-item">
                            <strong>Ruangan</strong>
                            <p>{{ $event->ruangan->nama_ruangan ?? '-' }}</p>
                        </div>

                        <div class="event-info-item">
                            <strong>Catatan</strong>
                            <p>{{ $event->catatan ?? '-' }}</p>
                        </div>

                        <hr>
                    @empty
                        <p class="text-muted">Tidak ada kegiatan hari ini</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.event-clickable').forEach(item => {
        item.addEventListener('click', function () {

            const modal = new bootstrap.Modal(
                document.getElementById('modalDetailPeminjaman')
            );

            modal.show();
        });
    });

});
</script>

@include('petugas.partials.modal-detail-peminjaman')

@endsection

