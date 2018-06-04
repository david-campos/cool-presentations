<?php      
    require dirname(__FILE__) . '/../include/database_connection.php';

    session_start();
    
    update_votation($mysqli);
    $mysqli->close();

    function update_votation($mysqli) {
        if (!isset($_POST['survey_page'], $_POST['presentation_code'], $_POST['answer_id'])) {
            http_response_code(400);
            $mysqli->close();
            die('Error: required data not received (survey_page, presentation_code, answer_id).');
        }
        
        $presentationCode = $_POST['presentation_code'];
        $survey = $_POST['survey_page'];
        $answer = $_POST['answer_id'];
        
        $stmt = $mysqli->prepare('UPDATE survey_answers SET votes=votes+1 WHERE presentation=? AND survey_page=? AND answer_num=?');
        $stmt->bind_param('sii', $presentationCode, $survey, $answer);
        if (!$stmt->execute()) {
            http_response_code(500);
            $stmt->close();
            $mysqli->close();
            die('Error in the update statement ' . $stmt->errno);
        } else {
            echo 'Row updated!';
            if(isset($_SESSION['voted'])) {
                if(!array_key_exists($presentationCode, $_SESSION['voted'])) {
                    $_SESSION['voted'][$presentationCode] = [$survey]; // new array
                } else {
                    $_SESSION['voted'][$presentationCode][] = $survey; // add survey
                }
            } else {
                $_SESSION['voted'] = [$presentationCode=>[$survey]]; // first vote
            }
        }
        $stmt->close();
    }
?>