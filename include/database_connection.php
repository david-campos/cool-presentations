<?php
// Database connection data
require dirname(__FILE__) . '/database_data.php';

define("CURRENT_DATABASE_VERSION", 2);
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

if ($mysqli->connect_error) {
    http_response_code(500);
    die('Database connection error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
}

if (!$mysqli->set_charset("utf8")) {
    printf("Error loading charset utf8: %s\n", $mysqli->error);
    exit();
}

if ( ($result = $mysqli->query('SELECT version FROM table_version;')) &&
        ($row = $result->fetch_row())) {
    $result->close();
    if($row[0] != CURRENT_DATABASE_VERSION) {
        $mysqli->close();
        http_response_code(500);
        die('ERROR: Incorrect database version, update the tables of the database.');
    }
} else {
    $mysqli->close();
    http_response_code(500);
    die('ERROR: Couldn\'t check database version');
}