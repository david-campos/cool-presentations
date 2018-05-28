<?php      
    require dirname(__FILE__) . '/../include/database_connection.php';

    update_votation($mysqli);
    $mysqli->close();

    function update_votation($mysqli) {
        if (!isset($_POST['survey_page'], $_POST['presentation_code'], $_POST['answer_id'])) {
            http_response_code(400);
            $mysqli->close();
            var_dump($_POST);
            die('Error: required data not received (survey_page, presentation_code, answer_id).');
        }
        $stmt = $mysqli->prepare('UPDATE survey_answers SET votes=votes+1 WHERE presentation=? AND survey_page=? AND answer_num=?');
        $stmt->bind_param('sii', $_POST['presentation_code'], $_POST['survey_page'], $_POST['answer_id']);
        if (!$stmt->execute()) {
            http_response_code(500);
            $stmt->close();
            $mysqli->close();
            die('Error in the update statement ' . $stmt->errno);
        } else {
            echo 'VOTE SENT';
        }
        $stmt->close();
    }
?>