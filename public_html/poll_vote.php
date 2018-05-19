<?php      
    require dirname(__FILE__) . '/../include/database_connection.php';

    update_votation($mysqli);
    $mysqli->close();

    function update_votation($mysqli) {
        if (!isset($_POST['id'])) {
            http_response_code(400);
            $mysqli->close();
            die('Error: id not received.');
        }
        $stmt = $mysqli->prepare('UPDATE survey_answers SET votes=votes+1 WHERE answer_num=?');
        $stmt->bind_param('i',$_POST['id']);
        if (!$stmt->execute()) {
            http_response_code(500);
            $stmt->close();
            $mysqli->close();
            die('Error in the update statement ' . $stmt->errno);
        }
        else {
            echo 'Row updated!';
        }
        $stmt->close();
    }
?>