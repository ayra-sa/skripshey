<!--A Design by W3layouts
  Author: W3layout
  Author URL: http://w3layouts.com
  License: Creative Commons Attribution 3.0 Unported
  License URL: http://creativecommons.org/licenses/by/3.0/
  -->
<!DOCTYPE html>
<html lang="zxx">

<head>
  <title>Analisa UMKM</title>
  <!--meta tags -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="Mulching Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
      Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
  <script>
    addEventListener("load", function() {
      setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
      window.scrollTo(0, 1);
    }
  </script>
  <!--//meta tags ends here-->
  <!--booststrap-->
  <link href="<?php echo base_url() ?>Assets/web/css/bootstrap.min.css" rel="stylesheet" type="text/css" media="all">
  <!--//booststrap end-->
  <!-- font-awesome icons -->
  <link href="<?php echo base_url() ?>Assets/web/css/font-awesome.min.css" rel="stylesheet">
  <!-- //font-awesome icons -->
  <!--stylesheets-->
  <link href="<?php echo base_url() ?>Assets/web/css/style.css" rel='stylesheet' type='text/css' media="all">
  <!--//stylesheets-->
  <!-- Web-Fonts -->
  <link href="//fonts.googleapis.com/css?family=Poiret+One&amp;subset=cyrillic,latin-ext" rel="stylesheet">
  <link href="//fonts.googleapis.com/css?family=Mada:200,300,400,500,600,700,900&amp;subset=arabic" rel="stylesheet">
  <!-- //Web-Fonts -->

</head>

<body>
  <div class="main-top" id="home">
    <!-- header -->
    <div class="headder-top">
      <!-- nav -->
      <?php include 'parts/Navbar.php'; ?>
      <!-- //nav -->
    </div>
    <!-- //header -->
    <!-- banner -->
    <div class="main-banner text-center position-relative">
      <div class="container">
        <div class="style-banner">
          <h4 class="mb-2">Usaha Mikro, Kecil dan Menengah (UMKM) <br>Kecamatan Tasikmadu <br>Karanganyar</h4>
        </div>
      </div>
    </div>
  </div>
  <!-- //banner -->
  <!-- about -->
  <section class="about py-lg-4 py-md-3 py-sm-3 py-3" id="about">
    <div class="container py-lg-5 py-md-4 py-sm-4 py-3">
      <div class="row">
        <div class="col-sm col-md-6 col-lg-6 about-imgs-txt">
          <img src="<?php echo base_url() ?>Assets/web/images/about.jpeg" alt="about image" class="img-fluid">
        </div>
        <div class="col-sm col-md-6 col-lg-6 text-right about-two-grids">
          <h3 class="title mb-md-4 mb-sm-3 mb-3">About</h3>
          <div class="about-para-txt">
            <p>Sangat banyak dan beraneka ragam Usaha Mikro, Kecil dan Menengah (UMKM) di Kecamatan Tasikmadu, Karanganyar. Untuk memudahkan para pelaku UMKM dalam pengembangan usaha mereka, maka dibuatkanlah Sistem Informasi Geografis UMKM di Kecamatan Tasikmadu</p>
          </div>
          <div class="view-buttn mt-lg-5 mt-md-4 mt-3">
            <a href="<?php echo base_url(); ?>Welcome/about" class=" scroll">Read More</a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- footer -->
  <?php include 'parts/FooterMain.php'; ?>
  <!--//footer -->
</body>

</html>