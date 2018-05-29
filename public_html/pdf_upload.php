<?php

/*
  This is a ***DEMO*** , the backend / PHP provided is very basic. You can use it as a starting point maybe, but ***do not use this on production***. It doesn't preform any server-side validation, checks, authentication, etc.

  For more read the README.md file on this folder.

  Based on the examples provided on:
  - http://php.net/manual/en/features.file-upload.php
*/

header('Content-type:application/json;charset=utf-8');

require dirname(__FILE__) . '/../include/database_connection.php';

if(!session_id()) session_start();

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
	$id_code = hash('sha256', uniqid(rand()));
	$aux = $id_code.'.pdf';
    $filepath = sprintf('../uploaded_pdfs/%s', $aux);

	
	
    if (!move_uploaded_file(
        $_FILES['file']['tmp_name'],
        $filepath
    )) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

    // All good, send the response
	

    echo json_encode([
        'status' => 'ok',
        'path' => $filepath
    ]);
	
	//----------RECOJO JSON----------------//
	
	
	$name=$_POST['present_name'];
	$downloable=$_POST['downloable'];
	$fecha1 = $_POST['diaini'];
	$hora1=$_POST['horaini'];
	$fecha2 = $_POST['diafin'];
	$hora2=$_POST['horafin'];
	$lat=$_POST['lat'];
	$lng=$_POST['lng'];
	$access_code = $_POST['code_access'];
	$access_code = hash('sha512', $access_code); 
	$access_code=strtolower($access_code);
	$user_id=$_SESSION['user_id'];
	$start = $fecha1." ".$hora1.":00";
	$fin= $fecha2." ".$hora2.":00";
	$question = $_POST['question'];
	$page = $_POST['page'];
	$open=1;
	$multiplechoice=$_POST['multiplechoice'];
	$xcor = $_POST['xcor'];
	$ycor = $_POST['ycor'];
	$width = $_POST['width'];
	$height = $_POST['height'];
	$answer1 = $_POST['answer1'];
	$answer2 = $_POST['answer2'];
	$answer3 = $_POST['answer3'];
	$answer4 = $_POST['answer4'];
	$answer5 = $_POST['answer5'];
	
	
	$question2 = $_POST['question2'];
	$page2 = $_POST['page2'];
	$open2=1;
	$multiplechoice2=$_POST['multiplechoice2'];
	$xcor2 = $_POST['xcor2'];
	$ycor2 = $_POST['ycor2'];
	$width2 = $_POST['width2'];
	$height2 = $_POST['height2'];
	$answer6 = $_POST['answer6'];
	$answer7 = $_POST['answer7'];
	$answer8 = $_POST['answer8'];
	$answer9 = $_POST['answer9'];
	$answer10 = $_POST['answer10'];
	
	$question3 = $_POST['question3'];
	$page3 = $_POST['page3'];
	$open3=1;
	$multiplechoice3=$_POST['multiplechoice3'];
	$xcor3 = $_POST['xcor3'];
	$ycor3 = $_POST['ycor3'];
	$width3 = $_POST['width3'];
	$height3 = $_POST['height3'];
	$answer11 = $_POST['answer11'];
	$answer12 = $_POST['answer12'];
	$answer13 = $_POST['answer13'];
	$answer14 = $_POST['answer14'];
	$answer15 = $_POST['answer15'];
	
	//-------- FIN REOCJO JSON-------------//

} catch (RuntimeException $e) {
	// Something went wrong, send the err message as JSON
	http_response_code(400);

	echo json_encode([
		'status' => 'error',
		'message' => $e->getMessage()
	]);
	
}




function insert_survey($mysqli,$page,$question,$xcor,$ycor,$open,$multiplechoice,$id_code,$width,$height){
	$stmt = $mysqli->prepare('INSERT INTO surveys VALUES (?,?,?,?,?,?,?,?,?)');
	$stmt->bind_param('isddddiis',$page,$question,$xcor,$ycor,$width,$height,$open,$multiplechoice,$id_code);
	if(!$stmt->execute()) {
		http_response_code(500);
        $stmt->close();
        $mysqli->close();
        throw new RuntimeException('Error in the query '.$stmt->errno);
    }
    $stmt->close();
}

function answer($mysqli,$num,$answer,$id_code,$page){
	$votes=0;
	$stmt = $mysqli->prepare('INSERT INTO survey_answers VALUES (?,?,?,?,?)');
	$stmt->bind_param('isisi',$num,$answer,$votes,$id_code,$page);
	if(!$stmt->execute()) {
		http_response_code(500);
        $stmt->close();
        $mysqli->close();
        throw new RuntimeException('Error in the query '.$stmt->errno);
    }
	$stmt->close();   
}

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
	
}


//----- EJECUTO LOS INSERTS POR ORDEN ----//

prueba($mysqli,$id_code,$name,$start,$fin,$lat,$lng,$access_code,$downloable,$user_id);

insert_survey($mysqli,$page,$question,$xcor,$ycor,$open,$multiplechoice,$id_code,$width,$height);
insert_survey($mysqli,$page2,$question2,$xcor2,$ycor2,$open2,$multiplechoice2,$id_code,$width2,$height2);

insert_survey($mysqli,$page3,$question3,$xcor3,$ycor3,$open3,$multiplechoice3,$id_code,$width3,$height3);
//-------------ANSWERS----------------------//


if ($answer1!=''){
	$num=1;
	answer($mysqli,$num,$answer1,$id_code,$page);
}
if ($answer2!=''){
	$num=2;
	answer($mysqli,$num,$answer2,$id_code,$page);
}
if ($answer3!=''){
	$num=3;
	answer($mysqli,$num,$answer3,$id_code,$page);
}
if ($answer4!=''){
	$num=4;
	answer($mysqli,$num,$answer4,$id_code,$page);
}
if ($answer5!=''){
	$num=5;
	answer($mysqli,$num,$answer5,$id_code,$page);
}


if ($answer6!=''){
	$num=1;
	answer($mysqli,$num,$answer6,$id_code,$page2);
}
if ($answer7!=''){
	$num=2;
	answer($mysqli,$num,$answer7,$id_code,$page2);
}
if ($answer8!=''){
	$num=3;
	answer($mysqli,$num,$answer8,$id_code,$page2);
}
if ($answer9!=''){
	$num=4;
	answer($mysqli,$num,$answer9,$id_code,$page2);
}
if ($answer10!=''){
	$num=5;
	answer($mysqli,$num,$answer10,$id_code,$page2);
}


if ($answer11!=''){
	$num=1;
	answer($mysqli,$num,$answer11,$id_code,$page3);
}
if ($answer12!=''){
	$num=2;
	answer($mysqli,$num,$answer12,$id_code,$page3);
}
if ($answer13!=''){
	$num=3;
	answer($mysqli,$num,$answer13,$id_code,$page3);
}
if ($answer14!=''){
	$num=4;
	answer($mysqli,$num,$answer14,$id_code,$page3);
}
if ($answer15!=''){
	$num=5;
	answer($mysqli,$num,$answer15,$id_code,$page3);
}



$mysqli->close();
//------FIN EJECUTAR INSERTS -----------//




?>