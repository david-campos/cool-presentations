<main role="main" class="container-fluid" id='window'>
    <?php
        // Database connection data
        require dirname(__FILE__) . '/../include/database_data.php';

        define("CURRENT_DATABASE_VERSION", 2);
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

        if ($conn->connect_error) {
            die('Database connection error');
        }
        $id  = $_POST['id'];
        $sql = "UPDATE survey_answers SET votes=votes+1";
        if ($conn->query($sql) == TRUE) {
            echo 'Update succesful'
        }
        else {
            echo 'No update :('
        }
        $conn->close();
    ?>
</main>