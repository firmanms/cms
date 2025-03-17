@extends('theme.flexstart.layouts.app')

@section('content')
    <!-- Page Title -->
    <div class="page-title">
      <div class="heading">
        <div class="container">
          <div class="row d-flex justify-content-center text-center">
            <div class="col-lg-8">
              {{-- <h1>{{ $data['page']['title'] }}</h1> --}}
              {{-- <p class="mb-0">Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione sint. Sit quaerat ipsum dolorem.</p> --}}
            </div>
          </div>
        </div>
      </div>
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="{{ url("/beranda") }}">Beranda</a></li>
            <li class="current">{{ $page->title }}</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Halaman</h2>
        <p>{{ $page->title }}</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" style="max-width: 100%;max-height: 100%;overflow: auto;box-sizing: border-box; ">
       {!!  $page->description  !!}
      </div>

    </section><!-- /Starter Section Section -->
@endsection
@section('description', $profil->seo_desc)
@section('keyword', $profil->seo_desc)
@section('title', $page->title)
@section('name', $profil->name)
@section('image',   url('storage/' . $profil->logo)  )
