<?php
// Database connection data
require dirname(__FILE__) . '/database_data.php';

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);