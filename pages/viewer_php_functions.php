<?php
require_once dirname(__FILE__) . '/../include/database_connection.php';

class NoPresentationCodeException extends Exception {}
class PresentationNotFoundException extends Exception {}
class PresentationPasswordError extends Exception {}

/**
 * Get's the presentation info for the requested presentation (by GET params)
 */
function get_presentation_info() {
    global $mysqli;
    
    if(!isset($_GET['id']) || preg_match('/^[0-9a-fA-F]{64}$/', $_GET['id'])!==1) {
        throw new NoPresentationCodeException('No identification code of the presentation or invalid one given.');
    }
    
    $presentationCode = $_GET['id'];
    $stmt = $mysqli->prepare(
        'SELECT name,start_timestamp,end_timestamp,location_lat,location_lon,downloadable,user_id,
            IF(access_code IS NULL, 0, 1) AS access_code_required
            FROM presentations WHERE id_code=? LIMIT 1');
    if(!$stmt) {
        throw new Exception('Error in the question query preparation ' . $mysqli->error, $mysqli->errno);
    }
    try {
        $stmt->bind_param('s',$presentationCode);
        if (!$stmt->execute()) {
            throw new Exception('Error in the question query ' . $stmt->error, $stmt->errno);
        }
        $stmt->bind_result($name,$start,$end,$lat,$lon,$download,$userId,$req_code);
        if($stmt->fetch()) {
            $presentation = [
                'id_code' => $presentationCode,
                'name' => $name,
                'start_timestamp' => $start,
                'end_timestamp' => $end,
                'access_code' => $req_code?true:false,
                'location' => ['lat'=>$lat, 'lon'=>$lon],
                'downloadable' => $download,
                'author' => $userId
            ];
        } else {
            throw new PresentationNotFoundException("Couldn't find presentation $presentationCode");
        }
    } finally {
        $stmt->close();
    }
    return $presentation;
}

/**
 * Gets the polls/surveys for the given presentation (identified by its code)
 * @param string $presentationCode the code to identify the presentation
 * @return array
 */
function get_polls_for_presentation($presentationCode) {
    global $mysqli;
    $stmt = $mysqli->prepare(
        'SELECT page,question,`positionX`,`positionY`,open,multiple_choice
            FROM surveys WHERE presentation_code=?');
    if(!$stmt) {
        throw new Exception('Error in the question query preparation ' . $mysqli->error, $mysqli->errno);
    }
    try {
        $stmt->bind_param('s',$presentationCode);
        if (!$stmt->execute()) {
            throw new Exception('Error in the question query ' . $stmt->errno);
        }
        $polls = [];
        $stmt->bind_result($page, $question, $posX, $posY, $open, $multipleChoice);
        while($stmt->fetch()) {
            $polls[$page] = [
                'page' => $page,
                'question' => $question,
                'pos' => ['x' => $posX, 'y' => $posY],
                'open' => $open,
                'multipleChoice' => $multipleChoice
            ];
        }
    } finally {
        $stmt->close();
    }
    foreach($polls as $page => &$poll) {
        $poll['answers'] = getAnswersForSurvey($presentationCode, $page);
    }
    return $polls;
}

/**
 * Gets the possible answers for the given survey
 */
function getAnswersForSurvey($presentation, $page) {
    global $mysqli;
    
    $stmt = $mysqli->prepare('SELECT answer_num,answer_text FROM survey_answers WHERE presentation=? AND survey_page=?');
    if($stmt) {
        try {
            $stmt->bind_param('si',$presentation, $page);
            if(!$stmt->execute()) {
                throw new Exception('Error in the question query ' . $stmt->errno);
            }
            $stmt->bind_result($id_answer, $text);
            $answers = [];
            while($stmt->fetch()) {
                $answers[] = ['id'=>$id_answer, 'text'=>$text];
            }
        } finally {
            $stmt->close();
        }
    } else {
        throw new Exception('Error in the question query preparation ' . $mysqli->error);
    }
    return $answers;
}