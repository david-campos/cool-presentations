<main role="main" class="container-fluid" id='window'>
    <?php
        // Database connection data
        require dirname(__FILE__) . '/../include/database_data.php';

        define("CURRENT_DATABASE_VERSION", 2);
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

        if ($conn->connect_error) {
            die('Database connection error');
        }
        echo "<h2>¡La encuesta!</h2>";
        $sql = "SELECT * FROM surveys WHERE page=1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "Pregunta: " . $row["question"] . "<br>";
            
            $sql = "SELECT * FROM survey_answers";
            $result = $conn->query($sql);
  
            if ($result->num_rows > 0) {
                echo "<form action=\"respuestas\">";
                while($row = $result->fetch_assoc()) {
                    echo "<input type=\"radio\" name=\"answer\" value=\"" . $row["answer_text"] . "\">" . $row["answer_text"] . "<br>";
                }
                echo "</form>";
                echo "<br>";
                echo "<button type=\"button\" id=\"vote\">Votar!</button>";
            }
        }        
        else {
            die('No hay resultados :(');
        }

        $conn->close();
    ?>
</main>