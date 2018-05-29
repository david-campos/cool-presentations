<?php
/**
 * This script returns updated information about the given survey.
 */
require dirname(__FILE__) . '/../include/presentations.php';

define('MARGIN', 100); // Margin in meters over the accuracy

try {
    if(!isset($_GET['latitude'], $_GET['longitude'], $_GET['accuracy'])) {
        throw new Exception('No latitude, longitude or accuracy sent.', 400);
    }
    $lat = $_GET['latitude'];
    $lon = $_GET['longitude'];
    $acc = $_GET['accuracy'];
    if(preg_match('/^-?[0-9]*.[0-9]*$/', $lat)!==1 ||
        preg_match('/^-?[0-9]*.[0-9]*$/', $lon)!==1 ||
        preg_match('/^[0-9]+$/', $acc)!==1) {
         throw new Exception('Latitude, longitude or accuracy in a wrong format.', 400);   
    }
    $lat = doubleval($lat);
    $lon = doubleval($lon);
    $acc = intval($acc);
    $time = date("Y-m-d H:i:s"); // current time
    
    $presentations = getPresentationsForTimeAndLocation($time, $lat, $lon, $acc+MARGIN);
    $json = json_encode(['presentations'=>$presentations], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if($json === false) {
        throw new Exception(json_last_error_msg(), 500);
    }
    die($json);
} catch (Exception $e) {
    http_response_code($e->getCode());
    die(json_encode(['error'=>$e->getMessage()]));
}