@extends('theme.flexstart.layouts.app')

@section('content')

    <!-- Page Title -->
    <div class="page-title">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
            <br>
              <h1>Informasi Layanan</h1>
              {{-- <p class="mb-0">Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p> --}}
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ url("/beranda") }}">Beranda</a></li>
            <li class="current">Informasi Layanan</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    

    <!-- Faq Section -->
    <section id="faq" class="faq section">

      <div class="container">

        <div class="row">

          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">
            <div class="accordion" id="accordionExample">
              @foreach($services as $services)
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $services['id'] }}" aria-expanded="false" aria-controls="{{ $services['id'] }}">
                    {{ $services->name }}
                  </button>
                </h2>
                <div id="{{ $services->id }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                  <div class="accordion-body"  style="max-width: 100%;max-height: 100%;overflow: auto;box-sizing: border-box; ">
                    
                    <b>Nama Layanan :</b><br>
                    {!! $services->name !!}<br>
                    <b>Persyaratan :</b><br>
                    {!! $services->requirement !!}<br>
                    <b>Mekanisme/Prosedur :</b><br>
                    {!! $services->procedure !!}<br>
                    <b>Waktu Penyelesaian :</b><br>
                    {!! $services->time !!}<br>
                    <b>Biaya :</b><br>
                    {!! $services->cost !!}<br>
                    <b>Produk Layanan :</b><br>
                    {!! $services->product !!}<br>
                    <b>Pengaduan :</b><br>
                    {!! $services->complaint !!}<br>
                  </div>
                </div>
              </div>
              @endforeach            
            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section><!-- /Faq Section -->  
    
@endsection
@section('description', $profil->seo_desc)
@section('keyword', $profil->seo_desc)
@section('title', 'Informasi Layanan')
@section('name', $profil->name)
@section('image',   url('storage/' . $profil->logo)  )

