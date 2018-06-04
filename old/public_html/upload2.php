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
//$_SESSION['filepath']=$id_code;


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




//--------------SURVEYS-----------------------//
$question = $_GET['question'];
$page = $_GET['page'];
$open=0;
if (isset($_GET['open'])) {
	$open=1;
}
$multiplechoice=0;
if (isset($_GET['multiplechoice'])) {
	$multiplechoice=1;
}
$xcor = $_GET['xcor'];
$ycor = $_GET['ycor'];
$width=50.00;
$height=50.00;


function insert_survey($mysqli,$page,$question,$xcor,$ycor,$open,$multiplechoice,$id_code,$width,$height){
	$stmt = $mysqli->prepare('INSERT INTO surveys VALUES (?,?,?,?,?,?,?,?,?)');
	$stmt->bind_param('isddiisdd',$page,$question,$xcor,$ycor,$open,$multiplechoice,$id_code,$width,$height);
	if(!$stmt->execute()) {
		http_response_code(500);
        $stmt->close();
        $mysqli->close();
        throw new RuntimeException('Error in the query '.$stmt->errno);
    }
    $stmt->close();
}




//-------------FI SURVEYS-------------------//

$answer1 = $_GET['answer1'];
$answer2 = $_GET['answer2'];
$answer3 = $_GET['answer3'];
$answer4 = $_GET['answer4'];
$answer5 = $_GET['answer5'];


function answer($mysqli,$num,$answer,$id_code,$page){
	$votes=0;
	echo "hola1";
	$stmt = $mysqli->prepare('INSERT INTO survey_answers VALUES (?,?,?,?,?)');
	echo "hola2";
	$stmt->bind_param('isisi',$num,$answer,$votes,$id_code,$page);
	echo "hola3";
	if(!$stmt->execute()) {
		http_response_code(500);
        $stmt->close();
        $mysqli->close();
        throw new RuntimeException('Error in the query '.$stmt->errno);
    }
	$stmt->close();   
}

//---------------FI ANSWERS-----------------//

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


prueba($mysqli,$id_code,$name,$start,$fin,$lat,$lng,$access_code,$downloable,$user_id);

insert_survey($mysqli,$page,$question,$xcor,$ycor,$open,$multiplechoice,$id_code,$width,$height);
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
$mysqli->close();
//echo $id_code.$name.$start.$fin.$lat.$lng.$access_code.$downloable.$user_id;
//echo $page.$question.$xcor.$ycor.$open.$multiplechoice.$id_code;