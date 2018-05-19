<?php
    require dirname(__FILE__) . '/../include/database_connection.php';

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
    ?>
        <main role="main" class="container-fluid" id='window'>
        <h2>¡La encuesta!</h2>
    <?php
        $stmt->bind_result($question);
        $stmt->fetch();        
        echo "Pregunta: " . $question . "<br>";
        $stmt->close();

        $stmt = $mysqli->prepare('SELECT answer_num,answer_text FROM survey_answers WHERE survey_page=?');
        $stmt->bind_param('i',$page);
        if (!$stmt->execute()) {
            http_response_code(500);
            $stmt->close();
            $mysqli->close();
            die('Error in the answer query ' . $stmt->errno);
        }
    ?>
        <form id="vote-form">
    <?php
        $answer = null;
        $id_answer = null;
        $stmt->bind_result($id_answer,$answer);
        while($stmt->fetch()) 
        {
            echo "<input type=\"radio\" name=\"answer\" value=\"" . $id_answer . "\">" . $answer;
            echo "<br>";
        }
    ?>
        </form>
        <br>
        <button type="button" id="vote-button">Votar</button>
        </main>
    <?php
        http_response_code(200);
        $stmt->close();
    }
    ?>