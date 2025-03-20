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
            <li class="current">Dokumen</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Halaman</h2>
        <p>Dokumen</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" style="max-width: 100%;max-height: 100%;overflow: auto;box-sizing: border-box; ">
       <!-- Pencarian -->
            <form method="GET" action="{{ route('dokumenupload') }}">
                <div class="mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Cari nama dokumen..." value="{{ request('search') }}">
                </div>
            </form>

            <!-- Tabel Data -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($fileupload as $index => $file)
                            <tr>
                                <td>{{ $fileupload->firstItem() + $index }}</td>
                                <td>{{ $file->title }}</td>
                                <td>{{ $file->kategori }}</td>
                                <td>
                                    <a href="{{ url('storage/' . $file->url) }}" class="btn btn-primary btn-sm" download>
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Blog Pagination Section -->
                <section id="blog-pagination" class="blog-pagination section">
                    <div class="container">
                        <div class="d-flex justify-content-center">
                            <ul class="pagination">
                                @if($currentPage > 1)
                                    
                                    {{-- <li>
                                        <a href="{{ $baseUrl }}?page={{ $currentPage - 1 }}" class="prev"><<</a>
                                    </li> --}}
                                @endif

                                @php
                                    $range = 2; // Number of pages to show on each side of the current page
                                    $start = max(1, $currentPage - $range);
                                    $end = min($lastPage, $currentPage + $range);

                                    // Ensure the first and last pages are always visible
                                    if ($start > 1) {
                                        echo '<li><a href="' . $baseUrl . '?page=1">1</a></li>';
                                        if ($start > 2) {
                                            echo '<li class="disabled"><span>...</span></li>';
                                        }
                                    }

                                    for ($i = $start; $i <= $end; $i++) {
                                        echo '<li class="' . ($i == $currentPage ? 'active' : '') . '"><a href="' . $baseUrl . '?page=' . $i . '">' . $i . '</a></li>';
                                    }

                                    if ($end < $lastPage) {
                                        if ($end < $lastPage - 1) {
                                            echo '<li class="disabled"><span>...</span></li>';
                                        }
                                        echo '<li><a href="' . $baseUrl . '?page=' . $lastPage . '">' . $lastPage . '</a></li>';
                                    }
                                @endphp

                                @if($currentPage < $lastPage)
                                    {{-- <li>
                                        <a href="{{ $baseUrl }}?page={{ $currentPage + 1 }}" class="next">>></a>
                                    </li> --}}
                                @endif
                            </ul>
                        </div>
                    </div>
                </section><!-- /Blog Pagination Section -->
      </div>

    </section><!-- /Starter Section Section -->
@endsection
@section('description', $profil->seo_desc)
@section('keyword', $profil->seo_desc)
@section('title', 'Produk Hukum')
@section('name', $profil->name)
@section('image',   url('storage/' . $profil->logo)  )
