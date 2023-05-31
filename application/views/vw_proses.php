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
            <h2>Daftar Data Normalisasi</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="dx-viewport demo-container">
              <div id="data-grid-demo">
                <div id="gridContainer">
                </div>
              </div>
            </div>
            <br>
            <div class="item form-group">
              <div class="col-md-3 col-sm-3 ">
                <button name="bt_proses" id="bt_proses" class="form-control btn btn-secondary">Proses</button>
                <!-- <input type="submit" name="button" id="button" required="" placeholder="Jumlah Cluster Dicari" class="form-control "> -->
              </div>
            </div>
            <br>
          </div>
          <div id="Hasil">Ini section hasil</div>
        </div>
      </div>

    </div>

    <div class="row" style="display: block;">
      <div class="col-md-6 col-sm-6  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>C1</h2>
          </div>
          <div class="x_content">
            <div class="dx-viewport demo-container">
              <div id="data-grid-demo">
                <div id="gridContainerHasil">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-sm-6  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>C2</h2>
          </div>
          <div class="x_content">
            <div class="dx-viewport demo-container">
              <div id="data-grid-demo">
                <div id="gridContainerHasil_C2">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-sm-6  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>C3</h2>
          </div>
          <div class="x_content">
            <div class="dx-viewport demo-container">
              <div id="data-grid-demo">
                <div id="gridContainerHasil_C3">
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

<!-- leaflet js  -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

<script>
  // set lokasi latitude dan longitude, lokasinya kota palembang 
  var mymap = L.map('mapid').setView([-2.9547949, 104.6929233], 13);
  //setting maps menggunakan api mapbox bukan google maps, daftar dan dapatkan token      
  L.tileLayer(
    'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibmFiaWxjaGVuIiwiYSI6ImNrOWZzeXh5bzA1eTQzZGxpZTQ0cjIxZ2UifQ.1YMI-9pZhxALpQ_7x2MxHw', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 20,
      id: 'mapbox/streets-v11', //menggunakan peta model streets-v11 kalian bisa melihat jenis-jenis peta lainnnya di web resmi mapbox
      tileSize: 512,
      zoomOffset: -1,
      accessToken: 'your.mapbox.access.token'
    }).addTo(mymap);
</script>


<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E&sensor=false&libraries=places" async defer></script> -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E"></script>
<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function() {
    var datanormalisasi;
    var where_field = '';
    var where_value = '';
    var table = 'users';

    fetch('<?= base_url() ?>C_Proses/GetNormalisasiAwal', {
        method: 'POST',
        body: JSON.stringify({
          id: ''
        }),
        headers: {
          'Content-Type': 'application/json'
        }
      })
      .then(response => response.json())
      .then(data => {
        datanormalisasi = data.data;
        bindGrid(data.data);
      })
      .catch(error => {
        console.error(error);
      });

    const btProses = document.getElementById('bt_proses');

    btProses.addEventListener('click', function() {
      btProses.textContent = 'Proses, Please wait.....';
      btProses.disabled = true;

      fetch('<?= base_url() ?>C_Proses/DeleteData', {
          method: 'POST',
          body: JSON.stringify({
            id: ''
          }),
          headers: {
            'Content-Type': 'application/json'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            console.log('Done Deleting');
          }
        })
        .catch(error => {
          console.error(error);
        });

      fetch("<?= base_url() ?>C_CentroidAwal/Read", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({
            id: ""
          })
        })
        .then(response => response.json())
        .then(response => {
          var html = "";
          var data_Centroid;
          var max_literasi = 7;
          if (response.success == true) {

            data_Centroid = response.data;
            for (var itt = 1; itt <= max_literasi; itt++) {
              html += "<h3><b>Iterasi ke " + itt + " </b></h3> <br>"
              html += "Centroid Awal : <br>"
              html += "<table border = '1'>" +
                "<tr>" +
                "<td>Cluster</td>" +
                "<td>Asset</td>" +
                "<td>JmlPekerja</td>" +
                "<td>Omset</td>" +
                "</tr>"
              for (var i = 0; i < data_Centroid.length; i++) {
                html += "<tr><td>" + data_Centroid[i].Centroid + "</td>" +
                  "<td>" + data_Centroid[i].Asset + "</td>" +
                  "<td>" + data_Centroid[i].JmlPekerja + "</td>" +
                  "<td>" + data_Centroid[i].Omset + "</td></tr>"
              }

              html += "</table><br><br>"

              html += "<b>Jarak cluster</b> <br>"

              html += "<table border = '1'>" +
                "<tr>" +
                "<td>ID</td>" +
                "<td>Pemilik UMKM</td>" +
                "<td>Asset</td>" +
                "<td>Jml Pekerja</td>" +
                "<td>Omset</td>" +
                "<td>C1</td>" +
                "<td>C2</td>" +
                "<td>C3</td>" +
                "<td>Jarak Terdekat</td>" +
                "</tr>"


              var temp_array = []

              var produksiC1 = 0;
              var produksiC1_count = 0;

              var produksiC2 = 0;
              var produksiC2_count = 0;

              var produksiC3 = 0;
              var produksiC3_count = 0;

              var pekerjaC1 = 0;
              var pekerjaC1_count = 0;

              var pekerjaC2 = 0;
              var pekerjaC2_count = 0;

              var pekerjaC3 = 0;
              var pekerjaC3_count = 0;

              var omsetC1 = 0;
              var omsetC1_count = 0;

              var omsetC2 = 0;
              var omsetC2_count = 0;

              var omsetC3 = 0;
              var omsetC3_count = 0;

              var keanggotaan = "";

              var hasilarray = [];

              for (var i_normal = 0; i_normal < datanormalisasi.length; i_normal++) {
                var c1 = Math.sqrt(Math.pow(datanormalisasi[i_normal].ND_Asset - data_Centroid[0].Asset, 2) + Math.pow(datanormalisasi[i_normal].ND_JmlPekerja - data_Centroid[0].JmlPekerja, 2) + Math.pow(datanormalisasi[i_normal].ND_Omset - data_Centroid[0].Omset, 2))

                var c2 = Math.sqrt(Math.pow(datanormalisasi[i_normal].ND_Asset - data_Centroid[1].Asset, 2) + Math.pow(datanormalisasi[i_normal].ND_JmlPekerja - data_Centroid[1].JmlPekerja, 2) + Math.pow(datanormalisasi[i_normal].ND_Omset - data_Centroid[1].Omset, 2))

                var c3 = Math.sqrt(Math.pow(datanormalisasi[i_normal].ND_Asset - data_Centroid[2].Asset, 2) + Math.pow(datanormalisasi[i_normal].ND_JmlPekerja - data_Centroid[2].JmlPekerja, 2) + Math.pow(datanormalisasi[i_normal].ND_Omset - data_Centroid[2].Omset, 2))

                var color1 = "";
                var color2 = "";
                var color3 = "";

                if (color1 + color2 + color3 == "") {
                  if (c1 == Math.min(c1, c2, c3)) {
                    color1 = "#FFFF00";

                    produksiC1 += parseFloat(datanormalisasi[i_normal].ND_Asset);
                    pekerjaC1 += parseFloat(datanormalisasi[i_normal].ND_JmlPekerja);
                    omsetC1 += parseFloat(datanormalisasi[i_normal].ND_Omset);

                    produksiC1_count += 1;
                    pekerjaC1_count += 1;
                    omsetC1_count += 1;

                    keanggotaan = "C1"
                  } else {
                    color1 = "";
                  }
                }

                if (color2 + color2 + color3 == "") {
                  if (c2 == Math.min(c1, c2, c3)) {
                    color2 = "#FFFF00";

                    produksiC2 += parseFloat(datanormalisasi[i_normal].ND_Asset);
                    pekerjaC2 += parseFloat(datanormalisasi[i_normal].ND_JmlPekerja);
                    omsetC2 += parseFloat(datanormalisasi[i_normal].ND_Omset);

                    produksiC2_count += 1;
                    pekerjaC2_count += 1;
                    omsetC2_count += 1;

                    keanggotaan = "C2"
                  } else {
                    color2 = "";
                  }
                }

                if (color3 + color2 + color3 == "") {
                  if (c3 == Math.min(c1, c2, c3)) {
                    color3 = "#FFFF00";

                    produksiC3 += parseFloat(datanormalisasi[i_normal].ND_Asset);
                    pekerjaC3 += parseFloat(datanormalisasi[i_normal].ND_JmlPekerja);
                    omsetC3 += parseFloat(datanormalisasi[i_normal].ND_Omset);

                    produksiC3_count += 1;
                    pekerjaC3_count += 1;
                    omsetC3_count += 1;

                    keanggotaan = "C3"
                  } else {
                    color3 = "";
                  }
                }
                // console.log(panenC1)
                html += "<tr><td>" + datanormalisasi[i_normal].id + "</td>" +
                  "<td>" + datanormalisasi[i_normal].Nama + "</td>" +
                  "<td>" + datanormalisasi[i_normal].ND_Asset + "</td>" +
                  "<td>" + datanormalisasi[i_normal].ND_JmlPekerja + "</td>" +
                  "<td>" + datanormalisasi[i_normal].ND_Omset + "</td>" +
                  "<td bgcolor = '" + color1 + "'>" + c1 + "</td>" +
                  "<td bgcolor = '" + color2 + "'>" + c2 + "</td>" +
                  "<td bgcolor = '" + color3 + "'>" + c3 + "</td>" +
                  "<td>" + Math.min(c1, c2, c3) + "</td></tr>"
                hasilarray.push({
                  "KodeData": datanormalisasi[i_normal].id,
                  "Keanggotaan": keanggotaan,
                  "iterasi": itt
                });
              }
              html += "</table>"

              // console.log(panenC1_count)

              temp_array.push({
                "id": "1",
                "KodeData": "0",
                "Centroid": "1",
                "Asset": (produksiC1 / produksiC1_count).toString(),
                "JmlPekerja": (pekerjaC1 / pekerjaC1_count).toString(),
                "Omset": (omsetC1 / omsetC1_count).toString()
              });

              temp_array.push({
                "id": "2",
                "KodeData": "0",
                "Centroid": "2",
                "Asset": (produksiC2 / produksiC2_count).toString(),
                "JmlPekerja": (pekerjaC2 / pekerjaC2_count).toString(),
                "Omset": (omsetC2 / omsetC2_count).toString()
              });

              temp_array.push({
                "id": "3",
                "KodeData": "0",
                "Centroid": "3",
                "Asset": (produksiC3 / produksiC3_count).toString(),
                "JmlPekerja": (pekerjaC3 / pekerjaC3_count).toString(),
                "Omset": (omsetC3 / omsetC3_count).toString()
              })
              // console.log(arraysEqual(data_Centroid,temp_array))
              if (arraysEqual(data_Centroid, temp_array)) {
                break;
              }
              data_Centroid = temp_array
              // console.log(temp_array)
            }
            // akhir iterasi

            document.getElementById('Hasil').innerHTML = html;

            console.log(hasilarray, 'hasil');
            for (var i = 0; i < hasilarray.length; i++) {
              fetch("<?= base_url() ?>C_Proses/addhasil", {
                  method: "POST",
                  headers: {
                    "Content-Type": "application/json"
                  },
                  body: JSON.stringify({
                    KodeData: hasilarray[i].KodeData,
                    Keanggotaan: hasilarray[i].Keanggotaan,
                    iterasi: hasilarray[i].iterasi
                  })
                })
                .then(response => response.json())
                .then(data => {
                  console.log(data);
                })
                .catch(error => {
                  console.error("Error:", error);
                });
            }

            fetch("<?= base_url() ?>C_Proses/getHasil", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
                body: JSON.stringify({
                  kelompok: "C1"
                })
              })
              .then(response => response.json())
              .then(data => {
                console.log(data, 'the data')
                bindGridHasil(data);
              })
              .catch(error => {
                console.error("Error:", error);
              });

            fetch("<?= base_url() ?>C_Proses/getHasil", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
                body: JSON.stringify({
                  kelompok: "C2"
                })
              })
              .then(response => response.json())
              .then(data => {
                bindGridHasil_C2(data);
              })
              .catch(error => {
                console.error("Error:", error);
              });

            fetch("<?= base_url() ?>C_Proses/getHasil", {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
                body: JSON.stringify({
                  kelompok: "C3"
                })
              })
              .then(response => response.json())
              .then(data => {
                bindGridHasil_C3(data);
              })
              .catch(error => {
                console.error("Error:", error);
              });

            const btProses = document.getElementById('bt_proses');
            btProses.textContent = 'Proses';
            btProses.disabled = false;
          }
        })
        .catch(error => {
          console.error("Error:", error);
        });
    })

    function arraysEqual(a, b) {
      var JmlProduksi_a = 0;
      var JmlPekerja_a = 0;
      var Omset_a = 0

      var JmlProduksi_b = 0;
      var JmlPekerja_b = 0;
      var Omset_b = 0

      for (var i = 0; i < a.length; i++) {
        JmlProduksi_a += parseFloat(a[i].Asset);
        JmlPekerja_a += parseFloat(a[i].JmlPekerja);
        Omset_a += parseFloat(a[i].Omset);
      }

      for (var x = 0; x < b.length; x++) {
        JmlProduksi_b += parseFloat(b[x].Asset);
        JmlPekerja_b += parseFloat(b[x].JmlPekerja);
        Omset_b += parseFloat(b[x].Omset);
      }

      if ((JmlProduksi_a + JmlPekerja_a + Omset_a) == (JmlPekerja_b + JmlProduksi_b + Omset_b)) {
        return true;
      } else {
        return false;
      }

    }

    const bindGridHasil = (data) => {
      const gridContainerHasil = document.querySelector("#gridContainerHasil");

      new DevExpress.ui.dxDataGrid(gridContainerHasil, {
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "nama",
        showBorders: true,
        allowColumnReordering: true,
        columnAutoWidth: true,
        paging: {
          enabled: false
        },
        columns: [{
            dataField: "nama",
            caption: "Nama",
            allowEditing: false
          },
          {
            dataField: "anggota",
            caption: "Keanggotaan",
            allowEditing: false
          },
          {
            dataField: "Keterangan",
            caption: "Keterangan",
            allowEditing: false
          },
        ],
      });
    };

    const bindGridHasil_C2 = (data) => {
      console.log(data)
      const gridContainerHasil = document.querySelector("#gridContainerHasil_C2");

      new DevExpress.ui.dxDataGrid(gridContainerHasil, {
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "nama",
        showBorders: true,
        allowColumnReordering: true,
        columnAutoWidth: true,
        paging: {
          enabled: false
        },
        columns: [{
            dataField: "nama",
            caption: "Nama",
            allowEditing: false
          },
          {
            dataField: "anggota",
            caption: "Keanggotaan",
            allowEditing: false
          },
          {
            dataField: "Keterangan",
            caption: "Keterangan",
            allowEditing: false
          },
        ],
      });
    };
    
    const bindGridHasil_C3 = (data) => {
      console.log(data)
      const gridContainerHasil = document.querySelector("#gridContainerHasil_C3");

      new DevExpress.ui.dxDataGrid(gridContainerHasil, {
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "nama",
        showBorders: true,
        allowColumnReordering: true,
        columnAutoWidth: true,
        paging: {
          enabled: false
        },
        columns: [{
            dataField: "nama",
            caption: "Nama",
            allowEditing: false
          },
          {
            dataField: "anggota",
            caption: "Keanggotaan",
            allowEditing: false
          },
          {
            dataField: "Keterangan",
            caption: "Keterangan",
            allowEditing: false
          },
        ],
      });
    };

    function bindGrid(data) {
      console.log(data, 'data')
      const gridContainer = document.querySelector("#gridContainer");

      new DevExpress.ui.dxDataGrid(gridContainer, {
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "id",
        showBorders: true,
        allowColumnReordering: true,
        columnAutoWidth: true,
        paging: {
          enabled: false
        },
        editing: {
          mode: "row",
          // allowUpdating: true,
          // allowDeleting: true,
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
            caption: "Nama",
            allowEditing: false
          },
          {
            dataField: "ND_Asset",
            caption: "Asset",
            allowEditing: false
          },
          {
            dataField: "ND_JmlPekerja",
            caption: "Jml Pekerja",
            allowEditing: false
          },
          {
            dataField: "ND_Omset",
            caption: "Omset",
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

              fetch("<?= base_url() ?>C_Data/CRUD", {
                  method: "POST",
                  headers: {
                    "Content-Type": "application/json"
                  },
                  body: JSON.stringify({
                    id: id,
                    formtype: "delete"
                  })
                })
                .then(response => response.json())
                .then(data => {
                  if (data.success) {
                    Swal.fire({
                      title: "Deleted!",
                      text: "Your file has been deleted.",
                      icon: "success"
                    }).then(result => {
                      location.reload();
                    });
                  } else {
                    Swal.fire({
                      title: "Woops...",
                      text: data.message,
                      icon: "error"
                      // footer: '<a href>Why do I have this issue?</a>'
                    }).then(result => {
                      location.reload();
                    });
                  }
                })
                .catch(error => {
                  console.error("Error:", error);
                  location.reload();
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
    }
  });
</script>