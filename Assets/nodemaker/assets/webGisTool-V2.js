
//map
var map;
var infowindow;
//vertex
var __vertex = [];
var __nomorVertex_arr = [];
var __nomor_vertex_incr = 0;
var __namaVertex = [];
var __asalVertex = [];
var __tujuanVertex = [];
var __koordinatVertex = [];
var max_currentVertex;
//graph
var __graph = [];
var __nomorGraph_incr = 0;
var __nomorGraph_arr = [];
var __arahGraph = [];
var poly;
//control
var activeButton = null;
var activeButton_text = null;
var __add_vertex = false;
var __add_graph = false;
var __delete_vertex = false;
var __delete_graph = false;
//vertex and graph controll
var __isFirstLine = 0;

$(document).ready(function () {
    if (detectmob() == true) {
        $('body').html('<h4>Minimum viewport is 800x600</h4>This page is currently not responsive yet');
    }
    $('#floating-panel').draggable({
        handle: ".panel-heading",
        cursor: "move",
        containment: "#map-canvas"
    });
    $('.panel-heading').css('cursor', 'move');

});

function initMap() {
    if (navigator.onLine) {
    } else {
        $.MessageBox("Google map API membutuhkan koneksi internet <br> :) cheeeers...");
    }
    var mapOptions = loadMapStyle('ajax/mapDay.json');
    map = new google.maps.Map(document.getElementById('map-canvas'),
            {
                zoom: 14,
                center: {lat: -7.5659265, lng: 110.8272557},
                disableDefaultUI: true,
                styles: mapOptions['styles']
            }
    );
    infowindow = new google.maps.InfoWindow();
    var locations = getVertexFromDatabase('ajax/vertex.php');
    if (locations.length === 0) {
        max_currentVertex = 0;
    }
    var marker, i;
    // fetch vertex dari database
    for (i = 0; i < locations.length; i++) {
        var icon_marker;
        if (locations[i][4] === "TRUE") {
            icon_marker = 'assets/marker/asal.png';
        } else if (locations[i][5] === "TRUE") {
            icon_marker = 'assets/marker/tujuan.png';
        } else {
            icon_marker = 'assets/marker/node.png';
        }
        max_currentVertex = Number(locations[i][0]) + 1;
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
            title: locations[i][0],
            icon: icon_marker,
            draggable: false
        });
        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                var contents = "<b>Vertex: </b>" + locations[i][0] + "<br>" +
                        "<b>Nama: </b>" + locations[i][3] + "<br>" +
                        "<b>Asal: </b>" + locations[i][4] + "<br>" +
                        "<b>Tujuan: </b>" + locations[i][5];
                infowindow.setContent(contents);
                infowindow.open(map, marker);
            };
        })(marker, i));
        __vertex.push(marker);
        __nomorVertex_arr.push(__nomor_vertex_incr);
        __namaVertex.push(locations[i][3]);
        __asalVertex.push(locations[i][4]);
        __tujuanVertex.push(locations[i][5]);
        __koordinatVertex.push(new google.maps.LatLng(locations[i][1], locations[i][2]));
        google.maps.event.addListener(marker, "click", function (evt)
        {

            for (var i = 0; i < __vertex.length; i++) {
                if (__vertex[i].title == this.title) {
                    markerClicked(evt, __vertex[i]);
                }
            }
        });
        google.maps.event.addListener(marker, 'dragend', function (event) {
            for (var i = 0; i < __nomor_vertex_incr; i++) {
                if (__nomorVertex_arr[i] == this.title) {
                    __koordinatVertex[i] = event.latLng;
                    __vertex[i].setPosition(new google.maps.LatLng(this.position.lat(), this.position.lng()));
                }
            }
        });
        __nomor_vertex_incr += 1;
    }
    //akhir proses pengambilan vertex dari database

    //start ambil graph dari database
    var graphDatabase = getVertexFromDatabase('ajax/graph.php');
    var mygraph = [];
    var graphPath = [];
    for (var num = 0; num < graphDatabase.length; num++) {
        var arah = graphDatabase[num]['arah'].split('|');
        var row = [];
        for (var i = 0; i < arah.length; i++) {
            var latlng = arah[i].split(',');
            var googlelatlng = new google.maps.LatLng(latlng[0], latlng[1]);
            row.push(googlelatlng);
        }
        mygraph.push(row);
        var awal = graphDatabase[num]['awal'];
        var akhir = graphDatabase[num]['akhir'];
        var arah_jalan = graphDatabase[num]['arah_jalan'];
        __arahGraph.push(awal + '-' + akhir + '-' + arah_jalan);
    }
    // fetch graph dari database
    for (var j = 0; j < mygraph.length; j++) {
        graphPath[j] = new google.maps.Polyline({
            path: mygraph[j],
            strokeColor: '#FF0000',
            geodesic: true,
            strokeOpacity: 0.7,
            strokeWeight: 2,
            editable: false
        });
        graphPath[j].setMap(map);
        __graph.push(graphPath[j]);
        __nomorGraph_arr.push(__nomorGraph_incr);
        __nomorGraph_incr += 1;
        google.maps.event.addListener(graphPath[j], 'click', function (ev) {
            removeLine(ev.latLng.lat(), ev.latLng.lng());
        });
    }
    var polyOptions = {
        geodesic: true,
        strokeColor: 'rgb(20, 120, 218)',
        strokeOpacity: 1.0,
        strokeWeight: 2,
        editable: true
    };
    window['poly' + __nomorGraph_incr] = new google.maps.Polyline(polyOptions);
    window['poly' + __nomorGraph_incr].setMap(map);
    google.maps.event.addListener(window['poly' + __nomorGraph_incr], 'click', function (ev) {
        removeLine(ev.latLng.lat(), ev.latLng.lng());
    });
    google.maps.event.addListener(map, 'click', function (event)
    {
        if (__add_vertex === true) {
            var nama_vertex;
            var destination;
            var source;
            $.MessageBox({
                input: true,
                message: "Masukkan Nama / Keterangan Vertex: "
            }).done(function (data) {
                if ($.trim(data)) {
                    nama_vertex = data;
                } else {
                    nama_vertex = '';
                }
            });
            $.MessageBox({
                buttonDone: "Ya (Enter)",
                buttonFail: "Tidak (Esc)",
                message: "Set sebagai lokasi tujuan?"
            }).done(function () {
                destination = 'TRUE';
            }).fail(function () {
                destination = 'FALSE';
            });
            $.MessageBox({
                buttonDone: "Ya (Enter)",
                buttonFail: "Tidak (Esc)",
                message: "Set sebagai lokasi asal?"
            }).done(function () {
                source = 'TRUE';
                draw_node();
            }).fail(function () {
                source = 'FALSE';
                draw_node();
            });
            function draw_node() {
                /* draw a new marker */
                var location = event.latLng;
                var icon_mrk;
                if (source == "TRUE") {
                    icon_mrk = 'assets/marker/asal.png';
                } else if (destination == "TRUE") {
                    icon_mrk = 'assets/marker/tujuan.png';
                } else {
                    icon_mrk = 'assets/marker/node.png';
                }
                var marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    icon: icon_mrk,
                    draggable: true,
                    title: '' + max_currentVertex
                });
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    for (var i = 0; i < __nomor_vertex_incr; i++) {
                        if (__nomorVertex_arr[i] == this.title) {
                            __koordinatVertex[i] = event.latLng;
                            __vertex[i].setPosition(new google.maps.LatLng(this.position.lat(), this.position.lng()));
                        }
                    }
                });
                __nomorVertex_arr.push(__nomor_vertex_incr);
                __vertex.push(marker);
                __koordinatVertex.push(location);
                __namaVertex.push(nama_vertex);
                __asalVertex.push(source);
                __tujuanVertex.push(destination);
                var txt = '<b>Vertex:</b> ' + max_currentVertex + '<br>' +
                        '<b>Nama: </b>' + nama_vertex + '<br>' +
                        '<b>Asal: </b>' + source + '<br>' +
                        '<b>Tujuan: </b>' + destination;
                attachMessage(marker, txt);
                var content_marker = "<div>" + max_currentVertex + "</div>";
                var infowindow_marker = new google.maps.InfoWindow();
                __nomor_vertex_incr += 1;
                max_currentVertex += 1;
                google.maps.event.addListener(marker, "click", function (evt)
                {
                    markerClicked(evt, marker);
                });
            }
        } else if (__add_graph === true) {
            if (__isFirstLine === 1) {
                var path = window['poly' + __nomorGraph_incr].getPath();
                path.push(event.latLng);
            } else {
                $.jnotify('<h5>OOPS!!!<br>Klik Vertex Dulu...</h5>', 'error');
            }
        }
    });
    function markerClicked(evt, marker) {
        if (__add_graph === true) {
            var path = window['poly' + __nomorGraph_incr].getPath();
            path.push(evt.latLng);
            if (__isFirstLine === 0)
                temp_node1 = marker.title;
            /* jika meng-klik ke marker/node akhir dalam pembuatan polyline */
            if (__isFirstLine === 1) {
                temp_node2 = marker.title;
                $.MessageBox({
                    buttonDone: "Ya (Enter)",
                    buttonFail: "Tidak (Esc)",
                    message: "Apakah jalur ini 2 arah?"
                }).done(function () {
                    temp_node_fix = temp_node1 + '-' + temp_node2 + '-' + 2;
                    draw_polyline();
                }).fail(function () {
                    temp_node_fix = temp_node1 + '-' + temp_node2 + '-' + 1;
                    draw_polyline();
                });
                function draw_polyline() {
                    __arahGraph.push(temp_node_fix);
                    __nomorGraph_incr += 1;
                    __isFirstLine = 0;
                    var polyOptions = {
                        geodesic: true,
                        strokeColor: 'rgb(20, 120, 218)',
                        strokeOpacity: 1.0,
                        strokeWeight: 2,
                        editable: true
                    };
                    window['poly' + __nomorGraph_incr] = new google.maps.Polyline(polyOptions);
                    window['poly' + __nomorGraph_incr].setMap(map);
                    google.maps.event.addListener(window['poly' + __nomorGraph_incr], 'click', function (ev) {
                        removeLine(ev.latLng.lat(), ev.latLng.lng());
                    });
                    $.jnotify('<h4>Vertex ' + temp_node1 + ' dan ' + temp_node2 + ' Terhubung</h4>', 'success', {timeout: 2});
                    return false;
                }
                __graph.push(window['poly' + __nomorGraph_incr]);
            }
            __isFirstLine = 1;
        } else if (__delete_vertex === true) {
            $.MessageBox({
                buttonDone: "Ya (Enter)",
                buttonFail: "Tidak (Esc)",
                message: "Delete Vertex?"
            }).done(function () {
                for (var i = 0; i < __vertex.length; i++) {
                    if (__vertex[i].title === marker.title) {
//                                                            console.log('Deleted: ' + marker.title);
                        __nomorVertex_arr.splice(i, 1);
                        __vertex.splice(i, 1);
                        __koordinatVertex.splice(i, 1);
                        __namaVertex.splice(i, 1);
                        __asalVertex.splice(i, 1);
                        __tujuanVertex.splice(i, 1);
                        marker.setMap(null);
                    }
                }
            }).fail(function () {

            });
        }
    }
    function removeLine(lat, lng) {
        if (__delete_graph === true) {
            for (var i = 0; i < __graph.length; i++) {
                var path = __graph[i].getPath();
                for (var j = 0; j < path['b'].length; j++) {
                    if (path['b'][j].lat() == lat && path['b'][j].lng() == lng) {
                        var grph = __graph, idx = i;
                        $.MessageBox({
                            buttonDone: "Ya (Enter)",
                            buttonFail: "Tidak (Esc)",
                            message: "Delete Graph?"
                        }).done(function () {
                            doDelete(idx, grph);
                        }).fail(function () {

                        });
                        function doDelete(index, graph) {
                            graph[index].setMap(null);
                            __graph.splice(index, 1);
                            __nomorGraph_arr.splice(index, 1);
                            __arahGraph.splice(index, 1);
                        }
                    }
                }
            }
        }
    }

    //akhir dari pengambilan graph dari database
}
//                                    End On Ready() function
function getVertexFromDatabase(url) {
    return JSON.parse($.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        global: false,
        async: false,
        success: function (data) {
            return data;
        }
    }).responseText);
}
function getGraphFromDatabase(url) {
    return JSON.parse($.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        global: false,
        async: false,
        success: function (data) {
            return data;
        }
    }).responseText);
}
function attachMessage(marker, message) {
    var infowindow = new google.maps.InfoWindow({
        content: message
    });
    marker.addListener('click', function () {
        infowindow.open(map, marker);
    });
}
function loadMapStyle(url) {
    return JSON.parse($.ajax({
        type: 'GET',
        url: url,
        dataType: 'json',
        global: false,
        async: false,
        success: function (data) {
            return data;
        }
    }).responseText);
}

function resetDatabase() {
    $.MessageBox({
        buttonDone: "Ya",
        buttonFail: "Batal",
        message: "<h4>Kosongkan Database?</h4><br>Aksi ini akan menghapus semua <b><i>vertex</i></b> dan <b><i>graph</i></b> yang sudah ada"
    }).done(function () {
        $.ajax({
            url: "ajax/resetDatabase.php"
        }).done(function () {
            location.reload();
        });
    }).fail(function () {

    });
}

function copy_sql() {
    $('#sql_text').select();
    document.execCommand('copy');
    $.jnotify('<h5>SQL text copied</h5>', 'success');
}

function save_markerlinex(save_type) {
    var str1 = '';
    for (i = 0; i < __graph.length; i++)
    {
        val_latlng = __graph[i].getPath().getArray();
        length_latlng = __graph[i].getPath().length;
        var str2 = '';
        var polylineLength = 0;
        for (a = 0; a < length_latlng; a++)
        {
            lat1 = val_latlng[a].lat();
            lng2 = val_latlng[a].lng();
            /* Hitung jarak polyLine */
            if (a < (length_latlng - 1)) {
                next_lat1 = val_latlng[(a + 1)].lat();
                next_lng2 = val_latlng[(a + 1)].lng();
                var pointPath1 = new google.maps.LatLng(lat1, lng2);
                var pointPath2 = new google.maps.LatLng(next_lat1, next_lng2);
                polylineLength += google.maps.geometry.spherical.computeDistanceBetween(pointPath1, pointPath2);
            }
            bracket_latlng = lat1 + ',' + lng2;
            if (a === (length_latlng - 1)) {
                str2 += bracket_latlng;
            } else {
                str2 += bracket_latlng + '|';
            }
        }
        nodes_info = __arahGraph[i];
        var res = nodes_info.split("-");
        create_json = "INSERT INTO `graph` (`awal`, `akhir`, `arah`,`arah_jalan`, `jarak`) VALUES (" + res[0] + "," + res[1] + ",'" + str2 + "'," + res[2] + "," + polylineLength + ");";
        create_json_rev = "INSERT INTO `graph` (`awal`, `akhir`, `arah`,`arah_jalan`, `jarak`) VALUES (" + res[1] + "," + res[0] + ",'" + str2 + "'," + res[2] + "," + polylineLength + ");";
        if (res[2] == 1) {
            str1 += create_json + '\n';
        } else {
            str1 += create_json + '\n' + create_json_rev + '\n';
        }

    }
    var create_json_node = '';
    for (var j = 0; j < __nomor_vertex_incr; j++) {
        if (__vertex[j] != null) {
            var lat = __vertex[j].getPosition().lat();
            var lng = __vertex[j].getPosition().lng();
            //                                            var latlng = __vertex[j].getPosition().lat() + ',' + __vertex[j].getPosition().lng();
            create_json_node += "INSERT INTO `vertex` (`node`,`nama`,`koordinat`,`lat`,`lng`,`source`,`destination`,`thumb`) VALUES (" + __vertex[j].title + ",'" + __namaVertex[j] + "','" + lat + "," + lng + "','" + lat + "','" + lng + "','" + __asalVertex[j] + "','" + __tujuanVertex[j] + "','logo.png');\n";
        }
    }
    /** SAVE TYPE **/
    var copy_node = "INSERT INTO tempat (id_node) SELECT id FROM vertex WHERE destination='TRUE'";
    if (save_type === "show") {
        pemisah = '\n\n';
        truncate_this = 'truncate table `vertex`;\ntruncate table `graph`;';
        $('#sql_text').val(truncate_this + pemisah + str1 + pemisah + create_json_node);
    } else if (save_type === "export") {
        pemisah = '\n\n';
        truncate_this = 'truncate table `vertex`;\ntruncate table `graph`;';
        $('#sql').text(truncate_this + pemisah + str1 + pemisah + create_json_node);
        $("#form").submit();
    }
}
var activeButtonClass = 'btn-danger';
var inActiveButtonClass = 'btn-default';
function resetButton() {
    if (activeButton != null && activeButton_text != null) {
        activeButton.removeClass(activeButtonClass);
        activeButton.addClass(inActiveButtonClass);
        activeButton.html(activeButton_text);
    }
}

function setMarkerAnimation(param) {
    if (param === true) {
        for (var i = 0; i < __vertex.length; i++) {
            (function (i) {
                setTimeout(function () {
                    __vertex[i].setAnimation(google.maps.Animation.BOUNCE);
                }, i * 50);
            }(i));
        }
    } else {
        for (var i = 0; i < __vertex.length; i++) {
            __vertex[i].setAnimation(null);
        }
    }
}

function add_vertex() {
    resetButton();
    activeButton = $('#add_vertex');
    activeButton_text = $('#add_vertex').text();
    __add_graph = false;
    __delete_vertex = false;
    __delete_graph = false;
    __isFirstLine = 0;
    setGraphEditable(false);
    setMarkerAnimation(false);
    if (__add_vertex === false) {
        __add_vertex = true;
        map.setOptions({draggableCursor: ''});
        activeButton.addClass(activeButtonClass);
        activeButton.removeClass(inActiveButtonClass);
        activeButton.html('<i class="fa fa-check pull-left" style="padding-top:2px"></i>Add Vertex');
        map.setOptions({draggableCursor: 'url(assets/cursor/vertex.cur), default'});
    } else {
        __add_vertex = false;
        activeButton.addClass(inActiveButtonClass);
        activeButton.removeClass(activeButtonClass);
        activeButton.html('Add Vertex');
        map.setOptions({draggableCursor: ''});
    }
}

function delete_vertex() {
    resetButton();
    activeButton = $('#delete_vertex');
    activeButton_text = $('#delete_vertex').text();
    __add_vertex = false;
    __add_graph = false;
    __delete_graph = false;
    __isFirstLine = 0;
    setGraphEditable(false);
    if (__delete_vertex === false) {
        __delete_vertex = true;
        activeButton.addClass(activeButtonClass);
        activeButton.removeClass(inActiveButtonClass);
        activeButton.html('<i class="fa fa-check pull-left" style="padding-top:2px"></i>Delete Vertex');
        map.setOptions({draggableCursor: ''});
        setMarkerAnimation(true);
    } else {
        __delete_vertex = false;
        activeButton.addClass(inActiveButtonClass);
        activeButton.removeClass(activeButtonClass);
        activeButton.html('Delete Vertex');
        map.setOptions({draggableCursor: ''});
        setMarkerAnimation(false);
    }
}

function setGraphEditable(parameter) {
    for (var i = 0; i < __graph.length; i++) {
        __graph[i].setOptions({
            editable: parameter
        });
    }
}

function delete_graph() {
    resetButton();
    activeButton = $('#delete_graph');
    activeButton_text = $('#delete_graph').text();
    __add_vertex = false;
    __add_graph = false;
    __delete_vertex = false;
    __isFirstLine = 0;
    setMarkerAnimation(false);
    if (__delete_graph == false) {
        __delete_graph = true;
        activeButton.addClass(activeButtonClass);
        activeButton.removeClass(inActiveButtonClass);
        activeButton.html('<i class="fa fa-check pull-left" style="padding-top:2px"></i>Delete Graph');
        map.setOptions({draggableCursor: ''});
        setGraphEditable(true);
    } else {
        __delete_graph = false;
        activeButton.addClass(inActiveButtonClass);
        activeButton.removeClass(activeButtonClass);
        activeButton.html('Delete Graph');
        map.setOptions({draggableCursor: ''});
        setGraphEditable(false);
    }
}

function add_graph() {
    resetButton();
    activeButton = $('#add_graph');
    activeButton_text = $('#add_graph').text();
    __add_vertex = false;
    __delete_vertex = false;
    __delete_graph = false;
    __isFirstLine = 0;
    setMarkerAnimation(false);
    setGraphEditable(false);
    if (__add_graph === false) {
        __add_graph = true;
        map.setOptions({draggableCursor: ''});
        activeButton.addClass(activeButtonClass);
        activeButton.removeClass(inActiveButtonClass);
        activeButton.html('<i class="fa fa-check pull-left" style="padding-top:2px"></i>Add Graph');
        map.setOptions({draggableCursor: 'pointer'});
    } else {
        __add_graph = false;
        activeButton.addClass(inActiveButtonClass);
        activeButton.removeClass(activeButtonClass);
        activeButton.html('Add Graph');
        map.setOptions({draggableCursor: ''});
    }
}

function changeMapStyle(param) {
    var style;
    switch (param) {
        case 'bw':
            style = loadMapStyle('ajax/mapBW.json');
            break;
        case 'night':
            style = loadMapStyle('ajax/mapNight.json');
            break;
        case 'bl':
            style = loadMapStyle('ajax/mapBlueLight.json');
            break;
        default:
            style = loadMapStyle('ajax/mapDay.json');
    }
    map.setOptions(style);
    map.setMapTypeId('roadmap');
}
function changeMapType(param) {
    map.setMapTypeId(param);
    map.setOptions(loadMapStyle('ajax/mapDay.json'));
}
function detectmob() {
    if (window.innerWidth < 800 && window.innerHeight < 600) {
        return true;
    } else {
        return false;
    }
}

function debug() {
//                                        console.log("Debug Report");
//                                        console.log('Vertex: ' + __vertex.length);
//                                        console.log('Nomor Vertex arr: ' + __nomorVertex_arr.length);
//                                        console.log('Nomor Vertex inc: ' + __nomor_vertex_incr);
//                                        console.log('nama vertex: ' + __namaVertex.length);
//                                        console.log('Asal vertex: ' + __asalVertex.length);
//                                        console.log('Tujuan vertex: ' + __tujuanVertex.length);
//                                        console.log('Koordinat vertex: ' + __koordinatVertex.length);
//                                        console.log('Graph: ' + __graph.length);

    console.log(__nomorVertex_arr.length);
    console.log(__nomor_vertex_incr);
    console.log(__nomorVertex_arr[7]);
}