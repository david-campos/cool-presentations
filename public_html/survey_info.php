<?php
/**
 * This script returns updated information about the given survey.
 */
require dirname(__FILE__) . '/../include/surveys.php';

session_start();

if(!isset($_GET['pres_id']) || preg_match('/^[0-9a-fA-F]{64}$/', $_GET['pres_id'])!==1) {
    http_response_code(400);
    die("{'error': 'No identification code of the presentation or invalid one given.'}");
}
$presentationCode = $_GET['pres_id'];

if(!isset($_GET['page']) || preg_match('/^[0-9]+$/', $_GET['page'])!==1) {
    http_response_code(400);
    die("{'error': 'No page or invalid one given.'}");
}
$page = intval($_GET['page']);

$surveyState = getSurveyState($presentationCode, $page);
if($surveyState === null) {
    http_response_code(404);
    die("{'error': 'survey not found'}");
} else {
    $json = json_encode($surveyState, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    if($json === false) {
        http_response_code(500);
        $json = json_encode(array("jsonError", json_last_error_msg()));
    }
    die($json);
}