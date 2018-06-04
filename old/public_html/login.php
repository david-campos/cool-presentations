<?php
session_start();

require dirname(__FILE__) . '/../include/database_connection.php';

check_name_and_pass($mysqli);
loggin($mysqli);
$mysqli->close();

http_response_code(200);
die('Logged! Welcome, '.$_SESSION['user'].'.');

function check_name_and_pass($mysqli) {
    if(!isset($_POST['nick'], $_POST['pass'])) {
        http_response_code(400);
        $mysqli->close();
        die('Error: nick and pass not received.');
    }
    
    if(preg_match('/^[A-Za-z0-9_\-.]+$/', $_POST['nick']) !== 1) {
        http_response_code(400);
        $mysqli->close();
        die('Error: invalid nick');
    }
    
    if(preg_match('/^[0-9A-Fa-f]{128}$/', $_POST['pass']) !== 1) {
        http_response_code(400);
        $mysqli->close();
        die('Error: no hashed password received.');
    }
}

function loggin($mysqli) {
    $nick = $_POST['nick'];
    $pass = $_POST['pass'];
    
    $stmt = $mysqli->prepare('SELECT user_id, password, salt FROM users WHERE user_name=?');
    $stmt->bind_param('s', $nick);
    if(!$stmt->execute()) {
        http_response_code(500);
        $stmt->close();
        $mysqli->close();
        die('Error in the query '.$stmt->errno);
    }
    $stmt->bind_result($id,$realPass,$salt);
    if(!$stmt->fetch()) {
        http_response_code(400);
        $stmt->close();
        $mysqli->close();
        die('Unknown user or password');
    }
    $stmt->close();
    
    $pass = hash('sha512', $pass.$salt); // We mix it with the salt :)
    if($pass !== $realPass) {
        http_response_code(400);
        $mysqli->close();
        die('Unknown user or password');
    }
    
    // So we finnaly logged in
    $_SESSION['user_id'] = $id;
    $_SESSION['user'] = $nick;
    //$_SESSION['session_token']= $token; no session tokens yet
}