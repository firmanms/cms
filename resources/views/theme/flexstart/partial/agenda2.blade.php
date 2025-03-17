@php
    use Carbon\Carbon;
    Carbon::setLocale('id');
@endphp
<section id="recent-posts" class="recent-posts section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Agenda</h2>
        <p>{{ $profil->singkatan }}</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-5">
        @foreach ($agenda as $agendaItem)
          <div class="col-xl-4 col-md-6">
            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

              <div class="post-img position-relative overflow-hidden">
                <img src="{{ url('storage/' . $agendaItem->image) }}" class="img-fluid" alt="">
                <span class="post-date">{{ Carbon::parse($agendaItem->published )->translatedFormat('d F Y') }}</span>
              </div>

              <div class="post-content d-flex flex-column">

                <h3 class="post-title">{{ $agendaItem->title }}</h3>

                <div class="meta d-flex align-items-center">
                  <div class="d-flex align-items-center">
                    <i class="bi bi-clock"></i> <span class="ps-2">{{ Carbon::parse($agendaItem->time )->translatedFormat('H:i') }} WIB</span>
                  </div>
                  <span class="px-3 text-black-50">/</span>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-geo-alt"></i> <span class="ps-2">{{ $agendaItem->location }}</span>
                  </div>
                </div>
                {{ $agendaItem->description }}
                {{-- <hr>

                <a href="#" class="readmore stretched-link"><span>Selengkapnya</span><i class="bi bi-arrow-right"></i></a> --}}

              </div>

            </div>
          </div><!-- End post item -->
          @endforeach
          {{-- <center><a href='#' class='btn btn-m btn-info' style='width:50%;'><span>Lihat Semua </span></a></center> --}}

          

        </div>

      </div>

    </section>