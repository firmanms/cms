<section id="faq" class="faq section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Pertanyaan Umum</h2>
        <p>{{ $profil->singkatan }}</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row">

          <div class="col-lg-12" data-aos="fade-up" data-aos-delay="100">

            <div class="faq-container">

              @foreach($faq as $faqItem)
              <div class="faq-item">
                <h3>{!! $faqItem->question !!}</h3>
                <div class="faq-content">
                  <p>{!! $faqItem->answer !!}</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->
              @endforeach

            </div>

          </div><!-- End Faq Column-->

        </div>

      </div>

    </section>