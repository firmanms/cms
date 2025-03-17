@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp
<section id="recent-posts" class="recent-posts section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Berita Terbaru</h2>
        <p>{{ $profil->singkatan }}</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-5">
        @foreach ($posting as $postingItem)
          <div class="col-xl-4 col-md-6">
            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

              <div class="post-img position-relative overflow-hidden">
                <img src="{{ url('storage/' . $postingItem->image) }}" class="img-fluid" alt="">
                <span class="post-date">{{ Carbon::parse($postingItem->published)->translatedFormat('d F Y') }}</span>
              </div>

              <div class="post-content d-flex flex-column">

                <h3 class="post-title">{{ $postingItem->title}}</h3>

                <div class="meta d-flex align-items-center">
                  <div class="d-flex align-items-center">
                    <i class="bi bi-person"></i> <span class="ps-2">{{ $profil->singkatan }}</span>
                  </div>
                  <span class="px-3 text-black-50">/</span>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-folder2"></i> <span class="ps-2">{{ $postingItem->categories->name }}</span>
                  </div>
                </div>

                <hr>

                <a href="{{ url( '/detailblog/' . $postingItem->slug) }}" class="readmore stretched-link"><span>Selengkapnya</span><i class="bi bi-arrow-right"></i></a>

              </div>

            </div>
          </div><!-- End post item -->
          @endforeach
          <center><a href='{{ url( '/page/statis/blog/') }}' class='btn btn-m btn-info' style='width:50%;'><span>Lihat Semua </span></a></center>

          

        </div>

      </div>

    </section>