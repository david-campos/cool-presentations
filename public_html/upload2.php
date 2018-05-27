<?php

/*
  This is a ***DEMO*** , the backend / PHP provided is very basic. You can use it as a starting point maybe, but ***do not use this on production***. It doesn't preform any server-side validation, checks, authentication, etc.

  For more read the README.md file on this folder.

  Based on the examples provided on:
  - http://php.net/manual/en/features.file-upload.php
*/
if(!session_id()) session_start();


header('Content-type:application/json;charset=utf-8');

require dirname(__FILE__) . '/../include/database_connection.php';




$id_code = hash('sha256', uniqid(rand()));



$name=$_GET['present_name'];
$downloable=0;
if (isset($_GET['downloable'])) {
	$downloable=1;
}

$fecha1 = $_GET['diaini'];
$hora1=$_GET['horaini'];

$fecha2 = $_GET['diafin'];
$hora2=$_GET['horafin'];

$lat=$_GET['lat'];
$lng=$_GET['lng'];

$access_code = $_GET['code_access'];
$access_code = hash('sha512', $access_code); 
$access_code=strtolower($access_code);


$user_id=$_SESSION['user_id'];

$start = $fecha1." ".$hora1.":00";
$fin= $fecha2." ".$hora2.":00";

$_SESSION['filepath']=$id_code;



prueba($mysqli,$id_code,$name,$start,$fin,$lat,$lng,$access_code,$downloable,$user_id);


function prueba($mysqli,$id_code,$name,$start,$fin,$lat,$lon,$access_code,$downloable,$user_id){
	$stmt = $mysqli->prepare('INSERT INTO presentations VALUES (?,?,?,?,?,?,?,?,?)');
	$stmt->bind_param('ssssddsii', $id_code,$name,$start,$fin,$lat,$lon,$access_code,$downloable,$user_id);
	if(!$stmt->execute()) {
		http_response_code(500);
        $stmt->close();
        $mysqli->close();
        throw new RuntimeException('Error in the query '.$stmt->errno);
    }
    $stmt->close();
	$mysqli->close();
}

