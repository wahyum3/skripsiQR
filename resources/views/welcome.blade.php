<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Sistem Receive Material</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="bootstrap/img/TTLCno_bg.png" rel="icon">
  <link href="bootstrap/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="bootstrap/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="bootstrap/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="bootstrap/vendor/aos/aos.css" rel="stylesheet">
  <link href="bootstrap/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="bootstrap/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="bootstrap/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: QuickStart
  * Template URL: https://bootstrapmade.com/quickstart-bootstrap-startup-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-pag">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <img src="bootstrap/img/TTLCno_bg.png" alt="">
        <h1 class="sitename">Warehouse V to V Export</h1>
      </a>

      <!-- Navigasi disembunyikan tapi tetap ada agar tidak error -->
      <nav id="navmenu" class="navmenu d-none">
        <!-- kosong -->
      </nav>

      <!-- <i class="mobile-nav-toggle d-xl-none bi bi-list"></i> -->

      <!-- <a class="btn-getstarted" href="index.html#about">Get Started</a> -->

    </div>
  </header>
  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-bg">
        <img src="bootstrap/img/hero-bg-light.webp" alt="">
      </div>
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center">
          <h1 data-aos="fade-up">Welcome To <br><span>Sistem Receive Material</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Gunakan Login Sesuai Akun Yang Sudah Dibuat<br></p>
          <div class="d-flex gap-3" data-aos="fade-up" data-aos-delay="200">
            <a href="{{ route('login') }}" class="btn-get-started">Login</a>
          </div>
          <img src="bootstrap/img/warehouse_no_bg.png" class="img-fluid hero-img" alt="" data-aos="zoom-out" data-aos-delay="300">
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section light-background">

      <div class="container">

        <div class="row gy-4">

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-sign-stop"></i></div>
              <div>
                <h4 class="title">STOP</h4>
                <p class="description">Berhenti saat ada ubnormal pada proses kerja</p>
              </div>
            </div>
          </div>
          <!-- End Service Item -->

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-person-raised-hand"></i></div>
              <div>
                <h4 class="title"><a href="#" class="stretched-link">CALL</a></h4>
                <p class="description">Panggil pimpinan atau atasan pada unit kerja tersebut</p>
              </div>
            </div>
          </div><!-- End Service Item -->

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="300">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-person-standing"></i></div>
              <div>
                <h4 class="title"><a href="#" class="stretched-link">WAIT</a></h4>
                <p class="description">Menunggu sampai pimpinan unit datang dan memberi keputusan</p>
              </div>
            </div>
          </div><!-- End Service Item -->


          <!-- Scroll Top -->
          <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

          <!-- Preloader -->
          <div id="preloader"></div>

          <!-- Vendor JS Files -->
          <script src="bootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
          <script src="bootstrap/vendor/php-email-form/validate.js"></script>
          <script src="bootstrap/vendor/aos/aos.js"></script>
          <script src="bootstrap/vendor/glightbox/js/glightbox.min.js"></script>
          <script src="bootstrap/vendor/swiper/swiper-bundle.min.js"></script>

          <!-- Main JS File -->
          <script src="bootstrap/js/main.js"></script>

</body>

</html>