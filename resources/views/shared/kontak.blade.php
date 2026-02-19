@extends('shared.layout')

@section('title', 'Kontak')

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
                Kontak
                <span class="line"></span>
            </h4>

            <p class="info-desc">
                Halaman ini menyediakan informasi kontak resmi pengelolaan sistem<br>
                peminjaman ruangan DPU Bina Marga dan Cipta Karya Provinsi Jawa Tengah.
            </p>

        </div>
    </div>
</section>

<section class="dashboard-content">
<div class="container">
<div class="row g-4">

{{-- KIRI --}}
<div class="col-lg-8">

{{-- MAP --}}
<div class="contact-card mb-4">

<h4 class="contact-title fw-bold">
<i class="bi bi-map"></i> Maps
</h4>

<iframe
src="https://www.google.com/maps?q=DPU%20Bina%20Marga%20dan%20Cipta%20Karya%20Jawa%20Tengah&output=embed"
width="100%"
height="260"
style="border:0;"
allowfullscreen
loading="lazy">
</iframe>

</div>


{{-- FAQ --}}
<div class="contact-card faq-card">

<div class="faq-header d-flex justify-content-between mb-3">

<h4 class="contact-title fw-bold">
<i class="bi bi-question-lg"></i> Pertanyaan Umum (FAQ)
</h4>

@if(session('role')=='superadmin')
<button id="btnKelolaFaq" class="kelola-btn">
Kelola FAQ
</button>
@endif

</div>


{{-- VIEW MODE --}}
<div id="faqViewMode">

@forelse($faqs as $faq)

<details class="faq-item">
<summary>{{ $faq->pertanyaan }}</summary>
<p>{{ $faq->jawaban }}</p>
</details>

@empty
<p class="text-muted">Belum ada FAQ.</p>
@endforelse

</div>


{{-- EDIT MODE --}}
@if(session('role')=='superadmin')

<div id="faqEditMode" class="faq-scroll" style="display:none">
    

{{-- HEADER ACTION --}}
<div class="d-flex justify-content-end mb-3 gap-2">

<button id="btnTambahFaq" class="btn-tambah">
+ Tambah FAQ
</button>

<button 
    id="btnSimpanFaq"
    type="submit"
    form="formFaq"
    class="btn-simpan">
Simpan
</button>


<button id="btnBatalFaq" class="btn-batal">
Batal
</button>

</div>

{{-- TAMBAH --}}
<div id="formTambahFaq" style="display:none">

<form id="formFaq" action="/faq" method="POST" class="mb-4">


@csrf

<h6>Tambah FAQ</h6>

<input
name="pertanyaan"
class="form-control mb-2"
placeholder="Pertanyaan"
required>

<textarea
name="jawaban"
class="form-control mb-2"
placeholder="Jawaban"
rows="3"
required></textarea>

</form>

</div>

<hr>


@foreach($faqs as $faq)

<div class="faq-edit-item border p-3 mb-4 rounded position-relative">

    <p class="fw-bold mb-1">
        {{ $faq->pertanyaan }}
    </p>

    <p class="mb-2">
        {{ $faq->jawaban }}
    </p>

    {{-- DELETE --}}
    <form
        action="/faq/{{ $faq->id }}"
        method="POST"
        onsubmit="return confirm('Hapus FAQ ini?')">

        @csrf
        @method('DELETE')

        <button
            type="submit"
            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2">
            <i class="bi bi-trash"></i>
        </button>

    </form>

</div>

@endforeach


</div>
@endif


</div>
</div>


{{-- KANAN --}}
<div class="col-lg-4">

<div class="contact-card">

<h4 class="contact-title fw-bold">
Alamat Kantor
</h4>


<div class="contact-info">
<i class="bi bi-map"></i>
<div>
<strong>Lokasi</strong>
<p>
Jl. Madukoro Blok AB-38, Tawangsari,<br>
Kec. Semarang Barat, Kota Semarang,<br>
Provinsi Jawa Tengah (50144)
</p>
</div>
</div>


<div class="contact-info">
<i class="bi bi-telephone"></i>
<div>
<strong>Telepon & Fax</strong>
<p>
(024) 7600380<br>
(024) 7613881
</p>
</div>
</div>


<div class="contact-info">
<i class="bi bi-envelope"></i>
<div>
<strong>Email</strong>
<p>dpubimargajtg@jatengprov.go.id</p>
</div>
</div>


<div class="contact-info">
<i class="bi bi-globe"></i>
<div>
<strong>Website</strong>
<p>
<a href="https://dpubinmarcipka.jatengprov.go.id/" target="_blank">
https://dpubinmarcipka.jatengprov.go.id
</a>
</p>
</div>
</div>

</div>

</div>

</div>
</div>
</section>


@endsection
