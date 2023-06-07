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

      <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
              </div> -->

    </div>
  </div>
</div>
<?php
require_once(APPPATH . "views/parts/Footer.php");
?>

<script src="https://cdn.jsdelivr.net/npm/leaflet@1.7.1/dist/leaflet.js"></script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E&sensor=false&libraries=places" async defer></script> -->
<!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E"></script> -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E"></script>
<script type="text/javascript">
  $(function() {
    var datanormalisasi;
    $(document).ready(function() {
      var where_field = '';
      var where_value = '';
      var table = 'users';

      $.ajax({
        async: false,
        type: "post",
        url: "<?= base_url() ?>C_Proses/GetNormalisasiAwal",
        data: {
          'id': ''
        },
        dataType: "json",
        success: function(response) {
          datanormalisasi = response.data;
          // console.log(response, 'dator')
          bindGrid(response.data);
        }
      });

    });

    $('#bt_proses').click(function() {
      $('#bt_proses').text('Proses, Please wait.....');
      $('#bt_proses').attr('disabled', true);
      $.ajax({
        async: false,
        type: "post",
        url: "<?= base_url() ?>C_Proses/DeleteData",
        data: {
          'id': ''
        },
        dataType: "json",
        success: function(responsex) {
          if (responsex.success == true) {
            console.log("Done Deleting");
          }
        }
      });

      $.ajax({
        async: false,
        type: "post",
        url: "<?= base_url() ?>C_CentroidAwal/Read",
        data: {
          'id': ''
        },
        dataType: "json",
        success: function(response) {
          // bindGrid(response.data);
          var html = "";
          var data_Centroid;
          var max_literasi = 7;
          if (response.success == true) {

            data_Centroid = response.data;
            // console.log(data_Centroid);
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
                // console.log(datanormalisasi[i_normal].ND_LuasPanen - data_Centroid[0].JmlProduksi)
                // console.log(Math.sqrt(datanormalisasi[i_normal].ND_LuasPanen - data_Centroid[0].JmlProduksi))
                // console.log(Math.sqrt(Math.pow(datanormalisasi[i_normal].ND_LuasPanen - data_Centroid[0].JmlProduksi,2)))
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
              // console.log(temp_array)
              // console.log(data_Centroid)
              // console.log(arraysEqual(data_Centroid,temp_array))
              if (arraysEqual(data_Centroid, temp_array)) {
                break;
              }
              data_Centroid = temp_array
              // console.log(temp_array)
            }
            // akhir iterasi

            $('#Hasil').html(html);

            console.log(hasilarray);
            for (var i = 0; i < hasilarray.length; i++) {
              $.ajax({
                async: false,
                type: "post",
                url: "<?= base_url() ?>C_Proses/addhasil",
                data: {
                  'KodeData': hasilarray[i].KodeData,
                  'Keanggotaan': hasilarray[i].Keanggotaan,
                  'iterasi': hasilarray[i].iterasi
                },
                dataType: "json",
                success: function(response) {
                  if (response == true) {
                    console.log('done')
                  }
                }
              });
            }

            $.ajax({
              async: false,
              type: "post",
              url: "<?= base_url() ?>C_Proses/getHasil",
              data: {
                'kelompok': 'C1'
              },
              dataType: "json",
              success: function(response) {
                bindGridHasil(response)
              }
            });

            $.ajax({
              async: false,
              type: "post",
              url: "<?= base_url() ?>C_Proses/getHasil",
              data: {
                'kelompok': 'C2'
              },
              dataType: "json",
              success: function(response) {
                bindGridHasil_C2(response)
              }
            });

            $.ajax({
              async: false,
              type: "post",
              url: "<?= base_url() ?>C_Proses/getHasil",
              data: {
                'kelompok': 'C3'
              },
              dataType: "json",
              success: function(response) {
                bindGridHasil_C3(response)
              }
            });

            $('#bt_proses').text('Proses');
            $('#bt_proses').attr('disabled', false);
          }
        }
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

    function bindGridHasil(data) {
      $("#gridContainerHasil").dxDataGrid({
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "nama",
        showBorders: true,
        allowColumnReordering: true,
        allowColumnResizing: true,
        columnAutoWidth: true,
        showBorders: true,
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
    }

    function bindGridHasil_C2(data) {
      $("#gridContainerHasil_C2").dxDataGrid({
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "nama",
        showBorders: true,
        allowColumnReordering: true,
        allowColumnResizing: true,
        columnAutoWidth: true,
        showBorders: true,
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
    }

    function bindGridHasil_C3(data) {
      $("#gridContainerHasil_C3").dxDataGrid({
        allowColumnResizing: true,
        dataSource: data,
        keyExpr: "nama",
        showBorders: true,
        allowColumnReordering: true,
        allowColumnResizing: true,
        columnAutoWidth: true,
        showBorders: true,
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