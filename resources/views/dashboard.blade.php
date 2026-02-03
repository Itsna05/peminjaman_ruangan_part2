@extends('superadmin.layout')

@section('title', 'Dashboard Superadmin')

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
@endsection