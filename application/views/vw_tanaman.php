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

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>Assets/devexpress/dx.common.css" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>Assets/devexpress/dx.light.css" />
  <script src="<?php echo base_url(); ?>Assets/devexpress/jszip.min.js"></script>
  <script src="<?php echo base_url(); ?>Assets/devexpress/dx.all.js"></script>

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
              <h2>Data UMKM Di Kecamatan Tasikmadu</h2>
            </center>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="dx-viewport demo-container">
              <div id="data-grid-demo">
                <div id="gridContainer">
                </div>
              </div>
            </div>
          </div>
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
      $.ajax({
        type: "post",
        url: "<?= base_url() ?>C_Data/read",
        data: {
          'id': ''
        },
        dataType: "json",
        success: function(response) {
          bindGrid(response.data);
        }
      });
    });
    // end Handle CSRF token
    function bindGrid(data) {

      $("#gridContainer").dxDataGrid({
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "id",
        showBorders: true,
        allowColumnReordering: true,
        allowColumnResizing: true,
        columnAutoWidth: true,
        showBorders: true,
        paging: {
          enabled: false
        },
        editing: {
          mode: "row",
          texts: {
            confirmDeleteMessage: ''
          }
        },
        searchPanel: {
          visible: true,
          width: 240,
          placeholder: "Search..."
        },
        export: {
          enabled: true,
          fileName: "Daftar Data Kecamatan"
        },
        columns: [{
            dataField: "id",
            caption: "#",
            allowEditing: false
          },
          {
            dataField: "Nama",
            caption: "Kecamatan",
            allowEditing: false
          },
          {
            dataField: "Alamat",
            caption: "Alamat",
            allowEditing: false
          }
        ],
        onEditingStart: function(e) {},
        onInitNewRow: function(e) {
          // logEvent("InitNewRow");
          // $('#modal_').modal('show');
        },
        onRowInserting: function(e) {
          // logEvent("RowInserting");
        },
        onRowInserted: function(e) {
          // logEvent("RowInserted");
          // alert('');
          // console.log(e.data.onhand);
          // var index = e.row.rowIndex;
        },
        onRowUpdating: function(e) {
          // logEvent("RowUpdating");

        },
        onRowUpdated: function(e) {
          // logEvent(e);
        },
        onRowRemoving: function(e) {},
        onRowRemoved: function(e) {
          // console.log(e);
        },
        onEditorPrepared: function(e) {
          // console.log(e);
        }
      });

      // add dx-toolbar-after
      // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
  });
</script>