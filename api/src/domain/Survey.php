<?php
require_once dirname(__FILE__) . '/database_connection.php';

class SurveyNotFoundException extends Exception {}

/**
 * Gets the polls/surveys for the given presentation (identified by its code)
 * @param string $presentationCode the code to identify the presentation
 * @return array
 */
function get_polls_for_presentation($presentationCode) {
    global $mysqli;
    return get_polls_where('presentation_code=?', 'i', [&$presentationCode]);
}

/**
 * Get's the state of a given survey
 */
function getSurveyState($presentation, $page) {
    global $mysqli;
    $polls = get_polls_where('presentation_code=? AND page=?', 'si', [&$presentation, &$page], '1');
    if(count($polls)>0) {
        return array_values($polls)[0];
    } else {
        return null;
    }
}

/**
 * Asks the database about surveys with the requested where clausule and limit
 */
function get_polls_where($where, $paramTypes, $params, $limit='') {
    global $mysqli;
    $polls = [];
        
    $query = 'SELECT presentation_code,page,question,`positionX`,`positionY`,open,multiple_choice,width,height
            FROM surveys WHERE '.$where;
    if($limit !== '') {
        $query .= ' LIMIT '.$limit;
    }
    
    $stmt = $mysqli->prepare($query);
    
    if(!$stmt) {
        throw new Exception('Error in the question query preparation ' . $mysqli->error, $mysqli->errno);
    }
    try {
        $params = array_merge([$paramTypes],$params);
        call_user_func_array([$stmt, 'bind_param'], $params);
        if (!$stmt->execute()) {
            throw new Exception('Error in the question query ' . $stmt->errno);
        }
        $stmt->bind_result($presentationCode, $page, $question, $posX, $posY, $open, $multipleChoice, $width, $height);
        while($stmt->fetch()) {
            $polls[$page] = [
                'presentation' => $presentationCode,
                'page' => $page,
                'question' => $question,
                'pos' => ['x' => $posX, 'y' => $posY],
                'size' => ['x' => $width, 'y' => $height],
                'open' => $open,
                'multipleChoice' => $multipleChoice
            ];
            if(isset($_SESSION['voted'])) {
                if(array_key_exists($presentationCode, $_SESSION['voted'])) {
                    $polls[$page]['answered'] = in_array($page, $_SESSION['voted'][$presentationCode]);
                } else {
                    $polls[$page]['answered'] = false;
                }
            } else {
                $polls[$page]['answered'] = false;
            }
        }
    } finally {
        $stmt->close();
    }
    foreach($polls as $page => &$poll) {
        $poll['answers'] = getAnswersForSurvey($poll['presentation'], $page);
        unset($poll['presentation']);
    }
    return $polls;
}

/**
 * Gets the possible answers for the given survey
 */
function getAnswersForSurvey($presentation, $page) {
    global $mysqli;
    
    $stmt = $mysqli->prepare('SELECT answer_num,answer_text,votes FROM survey_answers WHERE presentation=? AND survey_page=?');
    if($stmt) {
        try {
            $stmt->bind_param('si',$presentation, $page);
            if(!$stmt->execute()) {
                throw new Exception('Error in the question query ' . $stmt->errno);
            }
            $stmt->bind_result($id_answer, $text, $votes);
            $answers = [];
            while($stmt->fetch()) {
                $answers[] = ['id'=>$id_answer, 'text'=>$text, 'votes'=>$votes];
            }
        } finally {
            $stmt->close();
        }
    } else {
        throw new Exception('Error in the question query preparation ' . $mysqli->error);
    }
    return $answers;
}