<?php
require_once(APPPATH . "views/parts/Header.php");
require_once(APPPATH . "views/parts/Sidebar.php");
$active = 'dashboard';
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Input Data Awal</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nama Pemilik UMKM <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" name="Nama" id="Nama" required="" placeholder="Nama Pemilik UMKM" class="form-control ">
                  <input type="hidden" name="id" id="id">
                  <input type="hidden" name="formtype" id="formtype" value="add">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Asset<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="number" name="Asset" id="Asset" required="" placeholder="Jml Produksi" class="form-control ">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Jml pekerja<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="number" name="JmlPekerja" id="JmlPekerja" required="" placeholder="Jmlpekerja" class="form-control ">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Omset<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="number" name="Omset" id="Omset" required="" placeholder="Omset" class="form-control ">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Jenis Usaha<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" name="JenisUsaha" id="JenisUsaha" required="" placeholder="Jenis Usaha" class="form-control ">
                </div>
              </div>
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Alamat<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                  <input type="text" name="Alamat" id="Alamat" required="" placeholder="Alamat" class="form-control ">
                  <br>
                  <input type="hidden" name="Koordinat" id="Koordinat">
                </div>
              </div>

              <div class="item form-group">
                <div class="col-md-12 col-sm-12 ">
                  <!-- <input id="pac-input" class="controls" type="text" placeholder="Search Box"> -->
                  <!-- <div id="map-canvas" style="width:100%;height: 400px;"></div> -->
                </div>
              </div>
              <div id="map"></div>
              <div class="item" form-group>
                <button class="btn btn-primary" id="btn_Save">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="item form-group">
      <input type="text" id="addressInput" placeholder="Masukkan alamat" />
      <button onclick="geocodeAddress()">Cari</button>
    </div>

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Daftar Data Awal</h2>
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
</div>
<!-- /page content -->

<div class="modal fade bs-example-modal-lg" role="dialog" aria-hidden="true" id="modal_">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">

      </div>

    </div>
  </div>
</div>
<?php
require_once(APPPATH . "views/parts/Footer.php");
?>

<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script>
  const map = L.map('map').setView([-7.56713, 110.8990126], 13);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // Tambahkan marker
  // const marker = L.marker([-8.001467877016337, 110.94236324186754]).addTo(map);
  // const marker2 = L.marker([-7.996078013095501, 110.94451458390513]).addTo(map);
  // const marker3 = L.marker([-8.001048128587708, 110.94041378403283]).addTo(map);

  // Tambahkan popup pada marker
  // marker.bindPopup("<b>1</b>").openPopup();
  // marker2.bindPopup("<b>2</b>").openPopup();
  // marker3.bindPopup("<b>3</b>").openPopup();

  function codeAddress(address) {
    const geocoder = L.Control.Geocoder.nominatim();
    geocoder.geocode(address, function(results) {
      console.log(results, results.length)
      let latitude, longitude, country, county;
      for (let i = 0; i < results.length; i++) {
        const location = results[i].center;
        latitude = location.lat;
        longitude = location.lng;
        country = results[i].properties.address.country;
        county = results[i].properties.address.county;
        console.log(country, county)

        if (country === 'Indonesia' && county === 'Karanganyar') {
          break;
        }
      }

      if (country === 'Indonesia' && county === 'Karanganyar') {
        addMarker(latitude, longitude);
      } else {
        alert('The location is outside the map bounds or not in Indonesia.');
      }
    });
  }

  function isLocationWithinBounds(latitude, longitude) {
    const bounds = map.getBounds();
    const sw = bounds.getSouthWest();
    const ne = bounds.getNorthEast();

    return (
      latitude >= sw.lat &&
      latitude <= ne.lat &&
      longitude >= sw.lng &&
      longitude <= ne.lng
    );
  }


  function getAddressComponents(result) {
    try {
      var address = result.properties.address;
      return address ? address : '';
    } catch (error) {
      console.log(error)
      return '';
    }
  }

  function getAddressComponentValue(addressComponents, type) {
    if (Array.isArray(addressComponents)) {
      var component = addressComponents.find(function(component) {
        return component[type] != undefined;
      });

      return component ? component[type] : '';
    }

    return '';
  }

  function addMarker(latitude, longitude) {
    var marker = L.marker([latitude, longitude], {
      draggable: false
    }).addTo(map);
  }

  function initSearchBox() {
    var searchBox = L.Control.geocoder().addTo(map);
    searchBox.on('markgeocode', function(e) {
      var latLng = e.geocode.center;
      addMarker(latLng);
    });
  }

  function geocodeAddress() {
    var address = document.getElementById('addressInput').value;
    codeAddress(address);
  }

  const popup = L.popup();

  function onMapClick(e) {
    console.log(e)
    popup
      .setLatLng(e.latlng)
      .setContent("koordinat : " + e.latlng.toString())
      .openOn(map);

    document.getElementById('Alamat').value = `${e.latlng.lat}, ${e.latlng.lng}`
  }

  map.on('click', onMapClick);
  
</script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E"></script>
<script type="text/javascript">
  
  $(function() {
    $(document).ready(function() {
      var where_field = '';
      var where_value = '';
      var table = 'users';

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
    $('#post_').submit(function(e) {
      $('#btn_Save').text('Tunggu Sebentar.....');
      $('#btn_Save').attr('disabled', true);

      e.preventDefault();
      var me = $(this);
      if ($('#GPS').val() != '') {
        $.ajax({
          type: 'post',
          url: '<?= base_url() ?>C_Data/CRUD',
          data: me.serialize(),
          dataType: 'json',
          success: function(response) {
            if (response.success == true) {
              // $('#modal_').modal('toggle');
              Swal.fire({
                type: 'success',
                title: 'Horay..',
                text: 'Data Berhasil disimpan!',
              }).then((result) => {
                location.reload();
              });
            } else {
              // $('#modal_').modal('toggle');
              Swal.fire({
                type: 'error',
                title: 'Woops...',
                text: response.message,
              }).then((result) => {
                $('#btn_Save').text('Save');
                $('#btn_Save').attr('disabled', false);
              });
            }
          }
        });
      } else {
        Swal.fire({
          type: 'error',
          title: 'Woops...',
          text: 'Alamat Tidak Valid',
          // footer: '<a href>Why do I have this issue?</a>'
        }).then((result) => {
          // $('#modal_').modal('show');
          $('#btn_Save').text('Save');
          $('#btn_Save').attr('disabled', false);
        });
      }
    });
    $('.close').click(function() {
      location.reload();
    });

    function GetData(id) {
      var where_field = 'id';
      var where_value = id;
      var table = 'users';
      $.ajax({
        type: "post",
        url: "<?= base_url() ?>C_Data/read",
        data: {
          'id': id
        },
        dataType: "json",
        success: function(response) {
          $.each(response.data, function(k, v) {
            // console.log(v.KelompokUsaha, "kusa");
            alert("okekekeke")
            $('#Nama').val(v.Nama);
            $('#Alamat').val(v.Alamat);
            $('#Koordinat').val(v.Koordinat);
            $('#Asset').val(v.Asset);
            $('#JmlPekerja').val(v.JmlPekerja);
            $('#Omset').val(v.Omset);
            $('#JenisUsaha').val(v.JenisUsaha);

            $('#id').val(v.id);
            $('#formtype').val("edit");
          });
        }
      });
    }

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
          allowUpdating: true,
          allowDeleting: true,
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
          fileName: "Daftar Data Awal"
        },
        columns: [{
            dataField: "id",
            caption: "#",
            allowEditing: false
          },
          {
            dataField: "Nama",
            caption: "Pemilik UMKM",
            allowEditing: false
          },
          // {
          //   dataField: "Alamat",
          //   caption: "Alamat",
          //   allowEditing: false,
          //   visible: false,
          // },
          {
            dataField: "Asset",
            caption: "Asset",
            allowEditing: false
          },
          {
            dataField: "JmlPekerja",
            caption: "Jumlah Pekerja",
            allowEditing: false
          },
          {
            dataField: "Omset",
            caption: "Omset",
            allowEditing: false
          },
          {
            dataField: "JenisUsaha",
            caption: "Jenis Usaha",
            allowEditing: false
          },
          {
            dataField: "Alamat",
            caption: "Alamat",
            allowEditing: false
          }
        ],
        onEditingStart: function(e) {
          GetData(e.data.id);
        },
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
        onRowRemoving: function(e) {
          id = e.data.id;
          Swal.fire({
            title: 'Apakah anda yakin?',
            text: "anda akan menghapus data di baris ini !",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
              var table = 'app_setting';
              var field = 'id';
              var value = id;

              $.ajax({
                type: 'post',
                url: '<?= base_url() ?>C_Data/CRUD',
                data: {
                  'id': id,
                  'formtype': 'delete'
                },
                dataType: 'json',
                success: function(response) {
                  if (response.success == true) {
                    Swal.fire(
                      'Deleted!',
                      'Your file has been deleted.',
                      'success'
                    ).then((result) => {
                      location.reload();
                    });
                  } else {
                    Swal.fire({
                      type: 'error',
                      title: 'Woops...',
                      text: response.message,
                      // footer: '<a href>Why do I have this issue?</a>'
                    }).then((result) => {
                      location.reload();
                    });
                  }
                }
              });

            } else {
              location.reload();
            }
          })
        },
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