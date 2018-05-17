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
                while($row = $result->fetch_assoc()) {
                    echo $row["answer_text"] . " - Votes - " . $row["votes"] . "<br>";
                }
                echo "<br>";
            }
        }        
        else {
            die('No hay resultados :(');
        }

        $conn->close();
    ?>
</main> 