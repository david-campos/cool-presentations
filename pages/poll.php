<?php
    session_start();
    require dirname(__FILE__) . '/../include/database_connection.php';
    if ($mysqli->connect_error) {
        http_response_code(500);
        die('Connection error (' . $mysqli->connect_errno . ') '
                . $mysqli->connect_error);
    }
    get_poll($mysqli);
    $mysqli->close();

    function get_poll($mysqli) {
        $stmt = $mysqli->prepare('SELECT question FROM surveys WHERE page=?');
        $page = 3;
        $stmt->bind_param('s',$page);
        if (!$stmt->execute()) {
            http_response_code(500);
            $stmt->close();
            $mysqli->close();
            die('Error in the question query ' . $stmt->errno);
        }
        echo "<main role=\"main\" class=\"container-fluid\" id='window'>";
        echo "<h2>¡La encuesta!</h2>";
        $stmt->bind_result($question);
        $stmt->fetch();        
        echo "Pregunta: " . $question . "<br>";
        $stmt->close();

        $stmt = $mysqli->prepare('SELECT answer_num,answer_text FROM survey_answers WHERE survey_page=?');
        $stmt->bind_param('s',$page);
        if (!$stmt->execute()) {
            http_response_code(500);
            $stmt->close();
            $mysqli->close();
            die('Error in the answer query ' . $stmt->errno);
        }

        echo "<form action=\"respuestas\">";
        $answer = null;
        $id_answer = null;
        $stmt->bind_result($id_answer,$answer);
        while($stmt->fetch()) {
            echo "<input type=\"radio\" name=\"answer\" id=\"" . $id_answer .
                    "\" value=\"" . $answer . "\">" . $answer . "<br>";
        }
        echo "</form>";
        echo "<br>";
        echo "<button type=\"button\" id=\"vote\">Votar!</button>";
        echo "</main>";
        http_response_code(200);
        echo 'Todo ok';
        $stmt->close();
    }
?>