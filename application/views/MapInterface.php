<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>K-Means Clustering</title>

  <!-- Bootstrap -->
  <link href="<?php echo base_url(); ?>Assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo base_url(); ?>Assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- NProgress -->
  <link href="<?php echo base_url(); ?>Assets/vendors/nprogress/nprogress.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="<?php echo base_url(); ?>Assets/vendors/animate.css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="<?php echo base_url(); ?>Assets/build/css/custom.min.css" rel="stylesheet">
  <script src="<?php echo base_url(); ?>Assets/js/jquery.min.js"> </script>
</head>

<body class="login">
  <div class="right_col" role="main">
    <div class="page-title">
      <div class="title_left">
        <center>
          <h3>PEMETAAN K - MEANS CLUSTERING</h3>
        </center>
      </div>

      <div class="title_right">
        <div class="col-md-6 col-sm-6 form-group pull-right top_search">
          <a href="<?php echo base_url(); ?>Welcome/">Home</a> |
          <a href="<?php echo base_url(); ?>Welcome/tanaman">Data Tanaman Padi</a> |
          <a href="<?php echo base_url(); ?>Welcome/lokasi">Lokasi Tanaman Padi</a> |
          <a href="<?php echo base_url(); ?>Home/Login">Login</a>
          <div class="input-group">
            <!-- <input type="text" class="form-control" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span> -->
          </div>
        </div>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <center>
              <h2>Hasil Pemetaan UMKM di Kecamatan Tasikmadu dengan Metode K-Means Clustering</h2>
            </center>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <input type="hidden" name="Alamat" id="Alamat">
            <div id="map-canvas" style="width:100%;height: 600px;"></div>
            <br>

          </div>
          <!--Google map-->
          <!-- <div id="map-container-google-1" class="z-depth-1-half map-container" style="height: 500px">
            <iframe src="https://maps.google.com/maps?q=manhatan&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div> -->
        </div>
      </div>
    </div>
  </div>
  <!-- <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          termap
          <section class="login_content">
            <form id="loginform">
              <h1>Login Form</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username" required="" id="username" name="username"/>
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Password" required="" id="password" name="password"/>
              </div>
              <div>
                <button class="btn btn-success">Log in</button>
              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> AIS SYSTEM</h1>
                  <p>©2020 All Rights Reserved. AIS SYSTEM!. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div> -->
  <div class="clearfix"></div>
  <br />
  <div class="row  p-2">
    <div class="col-md-12">
      <center>©2023 All Rights Reserved.</center>
    </div>
  </div>
</body>

</html>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E&libraries=places&callback=initMap" async defer></script>
<script src="<?php echo base_url() ?>Assets/nodemaker/assets/webGisTool-V3.js" type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
    // Handle CSRF token
    $.ajaxSetup({
      beforeSend: function(jqXHR, Obj) {
        var value = "; " + document.cookie;
        var parts = value.split("; csrf_cookie_token=");
        if (parts.length == 2)
          Obj.data += '&csrf_token=' + parts.pop().split(";").shift();
      }
    });
    $(document).ready(function() {
      // body...
    });
    // end Handle CSRF token
    $('#loginform').submit(function(e) {
      $('#btn_login').text('Tunggu Sebentar...');
      $('#btn_login').attr('disabled', true);

      e.preventDefault();
      var me = $(this);
      // alert(me.serialize());
      $.ajax({
        type: "post",
        url: "<?= base_url() ?>Auth/Log_Pro",
        data: me.serialize(),
        dataType: "json",
        success: function(response) {
          if (response.success == true) {
            location.replace("<?= base_url() ?>Home")
          } else {
            if (response.message == 'L-01') {
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'User dan password tidak sesuai dengan database!',
                // footer: '<a href>Why do I have this issue?</a>'
              }).then((result) => {
                $('#username').val('');
                $('#password').val('');
                $('#btn_login').text('Login');
                $('#btn_login').attr('disabled', false);
              });
            } else if (response.message == 'L-02') {
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'User tidak di temukan!',
                footer: '<a href>Why do I have this issue?</a>'
              }).then((result) => {
                $('#username').val('');
                $('#password').val('');
                $('#btn_login').text('Login');
                $('#btn_login').attr('disabled', false);
              });
            } else {
              Swal.fire({
                type: 'error',
                title: 'Oops...',
                text: 'Undefine Error Contact your system administrator!',
                footer: '<a href>Why do I have this issue?</a>'
              }).then((result) => {
                $('#username').val('');
                $('#password').val('');
                $('#btn_login').text('Login');
                $('#btn_login').attr('disabled', false);
              });
            }
          }
        }
      });
    });
  });
</script>