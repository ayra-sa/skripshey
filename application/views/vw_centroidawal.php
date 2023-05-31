<?php
    require_once(APPPATH."views/parts/Header.php");
    require_once(APPPATH."views/parts/Sidebar.php");
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
                    <h2>Daftar Centroid Awal</h2>
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
                <form id="post_" data-parsley-validate class="form-horizontal form-label-left">
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Asset <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="number" name="Asset" id="Asset" required="" placeholder="Jumlah Pekerja" class="form-control " step="0.0001">
                      <input type="hidden" name="id" id="id">
                      <input type="hidden" name="formtype" id="formtype" value="edit">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">JmlPekerja <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="number" name="JmlPekerja" id="JmlPekerja" required="" placeholder="JmlPekerja" class="form-control " step="0.0001">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Omset <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 ">
                      <input type="number" name="Omset" id="Omset" required="" placeholder="Omset" class="form-control " step="0.0001">
                    </div>
                  </div>
                  <div class="item" form-group>
                    <button class="btn btn-primary" id="btn_Save">Save</button>
                  </div>
                </form>
              </div>

              <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
              </div> -->

            </div>
          </div>
        </div>
<?php
  require_once(APPPATH."views/parts/Footer.php");
?>
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E&sensor=false&libraries=places" async defer></script> -->
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places&key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E"></script>
<script type="text/javascript">
  $(function () {
        $(document).ready(function () {
          var where_field = '';
          var where_value = '';
          var table = 'users';

          $.ajax({
            type: "post",
            url: "<?=base_url()?>C_CentroidAwal/read",
            data: {'id':''},
            dataType: "json",
            success: function (response) {
              bindGrid(response.data);
            }
          });

        });
        $('#post_').submit(function (e) {
          $('#btn_Save').text('Tunggu Sebentar.....');
          $('#btn_Save').attr('disabled',true);

          e.preventDefault();
          var me = $(this);
          // alert($('#GPS').val());
          if ($('#GPS').val() != '') {
            $.ajax({
                type    :'post',
                url     : '<?=base_url()?>C_CentroidAwal/CRUD',
                data    : me.serialize(),
                dataType: 'json',
                success : function (response) {
                  if(response.success == true){
                    // $('#modal_').modal('toggle');
                    Swal.fire({
                      type: 'success',
                      title: 'Horay..',
                      text: 'Data Berhasil disimpan!',
                      // footer: '<a href>Why do I have this issue?</a>'
                    }).then((result)=>{
                      location.reload();
                    });
                  }
                  else{
                    // $('#modal_').modal('toggle');
                    Swal.fire({
                      type: 'error',
                      title: 'Woops...',
                      text: response.message,
                      // footer: '<a href>Why do I have this issue?</a>'
                    }).then((result)=>{
                      // $('#modal_').modal('show');
                      $('#btn_Save').text('Save');
                      $('#btn_Save').attr('disabled',false);
                    });
                  }
                }
              });
          }
          else{
            Swal.fire({
              type: 'error',
              title: 'Woops...',
              text: 'Alamat Tidak Valid',
              // footer: '<a href>Why do I have this issue?</a>'
            }).then((result)=>{
              // $('#modal_').modal('show');
              $('#btn_Save').text('Save');
              $('#btn_Save').attr('disabled',false);
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
            url: "<?=base_url()?>C_CentroidAwal/read",
            data: {'id':id},
            dataType: "json",
            success: function (response) {
              $.each(response.data,function (k,v) {
                $('#Asset').val(v.Asset);
                $('#JmlPekerja').val(v.JmlPekerja);
                $('#Omset').val(v.Omset);

                $('#id').val(v.id);
                $('#formtype').val("edit");

                $('#modal_').modal('show');
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
            columns: [
                {
                    dataField: "id",
                    caption: "#",
                    allowEditing:false
                },
                {
                    dataField: "KodeData",
                    caption: "KodeData",
                    allowEditing:false
                },
                {
                    dataField: "Centroid",
                    caption: "Centroid",
                    allowEditing:false
                },
                {
                    dataField: "Asset",
                    caption: "Asset",
                    allowEditing:false
                },
                {
                    dataField: "JmlPekerja",
                    caption: "Jml Pekerja",
                    allowEditing:false
                },
                {
                    dataField: "Omset",
                    caption: "Omset",
                    allowEditing:false
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
                      type    :'post',
                      url     : '<?=base_url()?>C_CentroidAwal/CRUD',
                      data    : {'id':id,'formtype':'delete'},
                      dataType: 'json',
                      success : function (response) {
                        if(response.success == true){
                          Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      ).then((result)=>{
                            location.reload();
                          });
                        }
                        else{
                          Swal.fire({
                            type: 'error',
                            title: 'Woops...',
                            text: response.message,
                            // footer: '<a href>Why do I have this issue?</a>'
                          }).then((result)=>{
                            location.reload();
                          });
                        }
                      }
                    });
                  
                }
                else{
                  location.reload();
                }
              })
            },
            onRowRemoved: function(e) {
              // console.log(e);
            },
        onEditorPrepared: function (e) {
          // console.log(e);
        }
        });

        // add dx-toolbar-after
        // $('.dx-toolbar-after').append('Tambah Alat untuk di pinjam ');
    }
  });
</script>