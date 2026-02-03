@extends('petugas.layout')

@section('title', 'Peminjaman Ruangan')

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
                Peminjaman Ruangan
                <span class="line"></span>
            </h4>

            <p class="info-desc">
                Halaman ini digunakan untuk mengajukan peminjaman ruangan
                dan melihat status pengajuan peminjaman.
            </p>

        </div>
    </div>
</section>


{{-- =======================
   FORM PEMINJAMAN
   ======================= --}}
@include('partials.form-peminjaman')

@endsection
