<?php
include '../../core/main.class.php';
$users = new users();
$sessions = $users->sessionCheck();
//print_r($sessions);
if ($sessions['logged'] != true) {
    header('location: ../../');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="utf-8">
        <link rel="shortcut icon" type="image/png" href="assets/webgistoolv2.png">
        <title>SIG FLOYD WARSHALL</title>
        <link href="assets/bootstrap-3.3.7/css/bootstrap.min_1.css" rel="stylesheet" type="text/css"/>
        <link href="assets/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/dialogJquery/messagebox.css" rel="stylesheet" type="text/css"/>
        <link href="assets/jquery-jnotify-master/jquery.jnotify.css" rel="stylesheet" type="text/css"/>
        <link href="assets/webGisTool-V2.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="panel panel-primary" id="floating-panel">
            <div class="panel-heading clearfix">
                <h5 class="panel-title pull-left" style="padding-top: 1.5px;">SIG FLOYD WARSHALL</h5>
                <div class="btn-group pull-right" style="padding-left: 20px;margin-right: -5px">
                    <span class="fa fa-arrows-alt"></span>
                </div>
            </div>
            <div class="panel-body">
                <div class="float-group">
                    <!--<label class="text-muted">Main Function</label>-->
                    <button class="btn btn-default btn-block btn-sm" id="add_vertex" onclick="add_vertex()">Add Vertex</button>
                    <button class="btn btn-default btn-block btn-sm" id="add_graph" onclick="add_graph()">Add Graph</button>
                    <button class="btn btn-default btn-block btn-sm" id="delete_vertex" onclick="delete_vertex()">Delete Vertex</button>
                    <button class="btn btn-default btn-block btn-sm" id="delete_graph" onclick="delete_graph()">Delete Graph</button>
                    <hr style="margin-top: 8px;margin-bottom: 8px">
                    <a class="btn btn-primary btn-block btn-sm" data-toggle="modal" href="#md_nodes" onclick="save_markerlinex('show')"><i class="fa fa-cogs pull-left" style="padding-top:2px"></i> Generate SQL Script</a>
                    <button class="btn btn-primary btn-block btn-sm" onclick="save_markerlinex('export')"><i class="fa fa-download pull-left" style="padding-top:2px"></i> Export to SQL File</button>
                    <hr style="margin-top: 8px;margin-bottom: 8px">
                    <button class="btn btn-warning btn-block btn-sm" onclick="resetDatabase()"><i class="fa fa-recycle pull-left" style="padding-top:2px"></i> Reset Database</button>
                    <a href="../" class="btn btn-success btn-block btn-sm"><i class="fa fa-arrow-left pull-left" style="padding-top:2px"></i> Back to Admin Panel</a>
                    <hr style="margin-top: 8px;margin-bottom: 8px">
                    <label class="text-muted">MAP Type</label>
                    <div class="btn-group btn-group-justified">
                        <a href="javascript:void(0);" class="btn btn-default btn-sm btn-default" onclick="changeMapType('roadmap')">Roadmap</a>
                        <a href="javascript:void(0);" class="btn btn-default btn-sm btn-default" onclick="changeMapType('hybrid')">Satellite</a>
                    </div>
                    <label class="text-muted">MAP Style</label>
                    <div class="btn-group btn-group-justified">
                        <a href="javascript:void(0);" class="btn btn-default btn-sm btn-default" onclick="changeMapStyle(null)">Default (Day)</a>
                        <a href="javascript:void(0);" class="btn btn-default btn-sm btn-default" onclick="changeMapStyle('night')">Night</a>
                    </div>
                    <div class="btn-group btn-group-justified">
                        <a href="javascript:void(0);" class="btn btn-default btn-sm btn-default" onclick="changeMapStyle('bw')">Light Grey</a>
                        <a href="javascript:void(0);" class="btn btn-default btn-sm btn-default" onclick="changeMapStyle('bl')">Light Blue</a>
                    </div>
                    <!-- <hr style="margin-top: 8px;margin-bottom: 8px"> -->
                                        <!-- <div class="row">
                                            <div class="col-xs-12">
                                                <label class="text-muted">Informasi Marker</label>
                                            </div>
                                            <div class="col-xs-2">
                                                <img class="img img-responsive" style="max-width: 30px" src="assets/marker/asal.png">
                                            </div>
                                            <div class="col-xs-10">
                                                <p class="pull-left">Lokasi Asal</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <img class="img img-responsive" style="max-width: 30px" src="assets/marker/tujuan.png">
                                            </div>
                                            <div class="col-xs-10">
                                                <p class="pull-left">Lokasi Tujuan</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <img class="img img-responsive" style="max-width: 30px" src="assets/marker/node.png">
                                            </div>
                                            <div class="col-xs-10">
                                                <p class="pull-left">Persimpangan</p>
                                            </div>
                                        </div> -->
                </div>
            </div>
        </div>
        <input id="pac-input" class="controls" type="text" placeholder="Search Box">
        <div id="map-canvas" style="float:left;"></div>
        <div id="md_nodes" class="modal container fade" tabindex="-1" style="display: none;">
            <div class="modal-dialog modal-lg" style="width: 100%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">SQL text</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea rows="20" readonly="" class="form-control" id="sql_text"></textarea>
                                <button id="floating_copy_button" class="btn btn-sm btn-success" onclick="copy_sql()"><i class="fa fa-copy"></i> Copy</button>
                            </div>

                        </div>
                        <form style="display: none" action="generate_sql.php" method="POST" id="form">
                            <textarea style="display: none;" id="sql" name="sql"></textarea>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="assets/jQUery/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="assets/jQUery/jquery-ui.min.js" type="text/javascript"></script>
        <script src="assets/bootstrap-3.3.7/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/dialogJquery/messagebox.js" type="text/javascript"></script>
        <!--<script src="assets/dialogJquery/messagebox.min.js" type="text/javascript"></script>-->
        <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E&language=id&region=ID&callback=initMap&libraries=places" async defer></script> -->
        <!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E&libraries=places"></script> -->
        <!-- <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script> -->

        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCG7FscIk67I9yY_fiyLc7-_1Aoyerf96E&libraries=places&callback=initMap"
         async defer></script>
        <script src="assets/jquery-jnotify-master/jquery.jnotify.js" type="text/javascript"></script>
        <script src="assets/webGisTool-V3.js" type="text/javascript"></script>
    </body>
</html>