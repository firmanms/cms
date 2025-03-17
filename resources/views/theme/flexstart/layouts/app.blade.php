<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Website - {{ $profil->name }}</title>
  <meta name="description" content="@yield('description')">
  <meta name="keywords" content="@yield('keyword')">
  <meta property="og:title" content="@yield('title')">
  <meta property="og:description" content="@yield('description')">
  <meta property="og:site_name" content="@yield('name')">
  <meta property="og:image" content="@yield('image')">

  <!-- Favicons -->
  <link href="{{ url('storage/' . $profil->favicon) }}" rel="icon">
  <link href="{{ asset("theme/flexstart/assets/img/apple-touch-icon.png")}}" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset("theme/flexstart/assets/vendor/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
  <link href="{{ asset("theme/flexstart/assets/vendor/bootstrap-icons/bootstrap-icons.css")}}" rel="stylesheet">
  <link href="{{ asset("theme/flexstart/assets/vendor/aos/aos.css")}}" rel="stylesheet">
  <link href="{{ asset("theme/flexstart/assets/vendor/glightbox/css/glightbox.min.css")}}" rel="stylesheet">
  <link href="{{ asset("theme/flexstart/assets/vendor/swiper/swiper-bundle.min.css")}}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset("theme/flexstart/assets/css/main.css")}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: FlexStart
  * Template URL: https://bootstrapmade.com/flexstart-bootstrap-startup-template/
  * Updated: Nov 01 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <!--header -->
  @include('theme.flexstart.partial.topbar')
  <!--end header -->

  <main class="main">

  @yield('content')   

  </main>

  <footer id="footer" class="footer">

    <div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center text-center">
          {{-- <div class="col-lg-6">
            <h4>Join Our Newsletter</h4>
            <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
            <form action="forms/newsletter.php" method="post" class="php-email-form">
              <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your subscription request has been sent. Thank you!</div>
            </form>
          </div> --}}
        </div>
      </div>
    </div>

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="{{ url('/beranda') }}" class="d-flex align-items-center">
            <span class="sitename">{{ $profil->name }}</span>
          </a>
          <div class="footer-contact pt-3">
            <p>{{ $profil->office_address }}</p>
            <p class="mt-3"><strong>Telp:</strong> <span>{{ $profil->office_telp }}</span></p>
            <p class="mt-3"><strong>Whatsapp:</strong> <span>{{ $profil->office_whatsapp }}</span></p>
            <p class="mt-3"><strong>Email:</strong> <span>{{ $profil->office_email }}</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          {{-- <h4>Useful Links</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Home</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
          </ul> --}}
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          {{-- <h4>Our Services</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
          </ul> --}}
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Ikuti Kami</h4>
          {{-- <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p> --}}
          <div class="social-links d-flex">
            <a href="{{ $profil->tw }}"><i class="bi bi-twitter-x"></i></a>
            <a href="{{ $profil->fb }}"><i class="bi bi-facebook"></i></a>
            <a href="{{ $profil->ig }}"><i class="bi bi-instagram"></i></a>
            <a href="{{ $profil->channel_yt }}"><i class="bi bi-youtube"></i></a>
            <a href="{{ $profil->tiktok }}"><i class="bi bi-tiktok"></i></a>
          </div>
        </div>

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">{{ $profil->singkatan }} X Diskominfo </strong> <span></span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset("theme/flexstart/assets/vendor/bootstrap/js/bootstrap.bundle.min.js")}}"></script>
  <script src="{{ asset("theme/flexstart/assets/vendor/php-email-form/validate.js")}}"></script>
  <script src="{{ asset("theme/flexstart/assets/vendor/aos/aos.js")}}"></script>
  <script src="{{ asset("theme/flexstart/assets/vendor/glightbox/js/glightbox.min.js")}}"></script>
  <script src="{{ asset("theme/flexstart/assets/vendor/purecounter/purecounter_vanilla.js")}}"></script>
  <script src="{{ asset("theme/flexstart/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js")}}"></script>
  <script src="{{ asset("theme/flexstart/assets/vendor/isotope-layout/isotope.pkgd.min.js")}}"></script>
  <script src="{{ asset("theme/flexstart/assets/vendor/swiper/swiper-bundle.min.js")}}"></script>

  <!-- Main JS File -->
  <script src="{{ asset("theme/flexstart/assets/js/main.js")}}"></script>
  <!-- GetButton.io widget -->
<script type="text/javascript">
    (function () {
        var a = "<?php echo $profil->office_whatsapp; ?>";
      	var b = "<?php echo $profil->office_telp; ?>";
        var options = {
            whatsapp: a, // Ganti dengan nomor WhatsApp Anda
            call: b, // Ganti dengan nomor WhatsApp And
            call_to_action: "Hubungi kami", // Pesan yang akan muncul di tombol
            position: "left", // Posisi tombol (left atau right)
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script>

<!-- /GetButton.io widget -->

</body>

</html>