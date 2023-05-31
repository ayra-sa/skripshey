<?php

header('Content-Type:application/json');
include '../../../core/main.class.php';
$NodeMakerClass = new NodeMakerClass();
$resetData = $NodeMakerClass->ResetDatabase();

echo json_encode($resetData);
