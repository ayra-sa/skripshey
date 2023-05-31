<?php

header('content-type:application/json');
include '../../../core/main.class.php';
$NodeMakerClass = new NodeMakerClass();
$graphs = $NodeMakerClass->loadGraph();
$graph = [];
while ($data = mysqli_fetch_assoc($graphs)) {
    array_push($graph, $data);
}
echo json_encode($graph);
