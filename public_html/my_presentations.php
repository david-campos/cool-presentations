<?php

/*
  This is a ***DEMO*** , the backend / PHP provided is very basic. You can use it as a starting point maybe, but ***do not use this on production***. It doesn't preform any server-side validation, checks, authentication, etc.

  For more read the README.md file on this folder.

  Based on the examples provided on:
  - http://php.net/manual/en/features.file-upload.php
*/



require dirname(__FILE__) . '/../include/database_connection.php';

if(!session_id()) session_start();

function delete_presentation($mysqli,$id_code){
	
	$stmt = $mysqli->prepare('DELETE FROM survey_answers WHERE presentation=?');
	$stmt->bind_param('s', $id_code);
	if(!$stmt->execute()) {
		http_response_code(500);
        $stmt->close();
        $mysqli->close();
        throw new RuntimeException('Error in the query '.$stmt->errno);
	}	

    $stmt->close();
	
	$stmt = $mysqli->prepare('DELETE FROM surveys WHERE presentation_code=?');
	$stmt->bind_param('s', $id_code);
	if(!$stmt->execute()) {
		http_response_code(500);
        $stmt->close();
        $mysqli->close();
        throw new RuntimeException('Error in the query '.$stmt->errno);
	}
    $stmt->close();

    $stmt = $mysqli->prepare('DELETE FROM presentations WHERE id_code=?');
	$stmt->bind_param('s', $id_code);
	if(!$stmt->execute()) {
		http_response_code(500);
        $stmt->close();
        $mysqli->close();
        throw new RuntimeException('Error in the query '.$stmt->errno);
    }
	$stmt->close();
	$mysqli->close();
     
}


$id_code=$_POST['data'];

 
delete_presentation($mysqli,$id_code);

?>




