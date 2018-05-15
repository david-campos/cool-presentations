<?php

/*
  This is a ***DEMO*** , the backend / PHP provided is very basic. You can use it as a starting point maybe, but ***do not use this on production***. It doesn't preform any server-side validation, checks, authentication, etc.

  For more read the README.md file on this folder.

  Based on the examples provided on:
  - http://php.net/manual/en/features.file-upload.php
*/

header('Content-type:application/json;charset=utf-8');


require dirname(__FILE__) . '/../../include/database_connection.php';

if ($mysqli->connect_error) {
    http_response_code(500);
    die('Connection error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}


$fecha1 = new DateTime();
$fecha1 = $fecha1->getTimestamp();
$id_code=$_FILES['file']['name'];
$latitud=0000;
$longitud=0000;
$acces_code = $_FILES['file']['name'];
$userid=25;


try {
    if (
        !isset($_FILES['file']['error']) ||
        is_array($_FILES['file']['error'])
    ) {
        throw new RuntimeException('Invalid parameters.');
    }
	
    switch ($_FILES['file']['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException('Exceeded filesize limit.');
        default:
            throw new RuntimeException('Unknown errors.');
    }
	
    $filepath = sprintf('files/%s_%s', uniqid(), $_FILES['file']['name']);

    if (!move_uploaded_file(
        $_FILES['file']['tmp_name'],
        $filepath
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    // All good, send the response
	$fecha2 = new DateTime();
	$fecha2 = $fecha2->getTimestamp();

	//insert_upload($id_code,$fecha1,$fecha2,$latitud,$longitud,$acces_code,$userid,$mysqli);
    echo json_encode([
        'status' => 'ok',
        'path' => $filepath
    ]);

} catch (RuntimeException $e) {
	// Something went wrong, send the err message as JSON
	http_response_code(400);

	echo json_encode([
		'status' => 'error',
		'message' => $e->getMessage()
	]);
}


function insert_upload($id_code,$timeini,$timefin,$latitud,$longitud,$acces_code,$userid,$mysqli){
	$stmt = $mysqli->prepare('INSERT INTO borrar VALUES (?, ?, ?, ?, ?, ?, ?)');
	$latitud=2.45;
	$longitud=3.0;
	$userid=25;
    $stmt->bind_param('sssddsi', $id_code,$timeini,$timefin,$latitud,$longitud,$acces_code,$userid);
    if(!$stmt->execute()) {
        http_response_code(500);
        $stmt->close();
        $mysqli->close();
        die('Error in the query '.$stmt->errno);
    }
    $stmt->close();
	$mysqli->close();
	
}
