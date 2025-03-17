<section id="values" class="values section">
    
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
    <h2>Akses Cepat</h2>
    <p>{{ $profil->singkatan }}<br></p>
    </div><!-- End Section Title -->

    <div class="container">

    <div class="row gy-4">
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card">
                        <img src="{{ asset("theme/flexstart/assets/img/logobkpsdm.png")}}" class="img-fluid" alt="">
                        <a href="{{ url('/page/statis/layanan') }}"><h3>Informasi Layanan</h3></a>
                        <p>{{ $profil->name }}</p>
                    </div>
                </div><!-- End Card Item -->
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card">
                        <img src="{{ asset("theme/flexstart/assets/img/logobkpsdm.png")}}" class="img-fluid" alt="">
                        <a href="{{ url('/page/statis/sarana') }}"><h3>Informasi Sarana</h3></a>
                        <p>{{ $profil->name }}</p>
                    </div>
                </div><!-- End Card Item -->
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card">
                        <img src="{{ asset("theme/flexstart/assets/img/logobkpsdm.png")}}" class="img-fluid" alt="">
                        <a href="{{ url('/page/statis/pengaduan') }}"><h3>Informasi Pengaduan</h3></a>
                        <p>{{ $profil->name }}</p>
                    </div>
                </div><!-- End Card Item -->
                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="card">
                        <img src="{{ asset("theme/flexstart/assets/img/logobkpsdm.png")}}" class="img-fluid" alt="">
                        <a href="{{ url('/page/statis/skm') }}"><h3>Informasi SKM</h3></a>
                        <p>{{ $profil->name }}</p>
                    </div>
                </div><!-- End Card Item -->
    </div>

    </div>

</section>
@foreach ($kategori_banner as $kategori)
<section id="values" class="values section">
    
    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>{{ $kategori }}</h2> <!-- Menampilkan nama kategori -->
        <p>{{ $profil->singkatan }}<br></p>
    </div><!-- End Section Title -->

    <div class="container">
        <div class="row gy-4">
            @foreach ($banner as $bannerItem)
                @if ($bannerItem->kategori == $kategori)
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card">
                            <img src="{{ url('storage/' . $bannerItem->image) }}" class="img-fluid" alt="">
                            <a href="{{ $bannerItem->url }}"><h3>{{ $bannerItem->title }}</h3></a>
                            <p>{{ $bannerItem->description }}</p>
                        </div>
                    </div><!-- End Card Item -->
                @endif
            @endforeach
        </div>
    </div>

</section>
@endforeach