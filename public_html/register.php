<?php
require dirname(__FILE__) . '/../include/database_connection.php';

if ($mysqli->connect_error) {
    http_response_code(500);
    die('Connection error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

check_name_and_pass($mysqli);
save_into_database($mysqli);
http_response_code(200);
echo 'Registered!';
$mysqli->close();

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

function save_into_database($mysqli) {
    $nick = $_POST['nick'];
    $pass = $_POST['pass'];
    $randomPseudoBytes = bin2hex(openssl_random_pseudo_bytes(32,  $strong));
    if( !$strong ) {
        http_response_code(500);
        $mysqli->close();
        die('openssl_random_pseudo_bytes not strong enough.');
    }
    $salt = hash('sha512', uniqid(rand(), true).$randomPseudoBytes);
    $pass = hash('sha512', $pass.$salt); // We mix it with the salt :)
    $stmt = $mysqli->prepare('INSERT INTO users(user_name, password, salt) VALUES(?,?,?)');
    $stmt->bind_param('sss', $nick, $pass, $salt);
    if(!$stmt->execute()) {
        http_response_code(500);
        // Unique constraint
        if($stmt->errno === 1062) {
            $text = "User '$nick' already in use";
        } else {
            $text = 'Error in the query '.$stmt->errno;
        }
        $stmt->close();
        $mysqli->close();
        die($text);
    }
    $stmt->close();
}