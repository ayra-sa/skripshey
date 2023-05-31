<?php

header('Content-Type:application/json');
include '../../../core/main.class.php';
$NodeMakerClass = new NodeMakerClass();
$markers = $NodeMakerClass->loadMarker();
$marker = [];
while ($data = mysqli_fetch_assoc($markers)) {
    $currentData = [];
    array_push($currentData, $data['node']);
    array_push($currentData, $data['lat']);
    array_push($currentData, $data['lng']);
    array_push($currentData, $data['nama']);
    array_push($currentData, $data['source']);
    array_push($currentData, $data['destination']);
    array_push($marker, $currentData);
}
echo json_encode($marker);
