<?php      
    require dirname(__FILE__) . '/../include/database_connection.php';

    is_downloadable($mysqli);
    $mysqli->close();

    function is_downloadable($mysqli) {
        $stmt = $mysqli->prepare('SELECT downloadable FROM presentations WHERE id_code=?');
        $id = 'CA978112CA1BBDCAFAC231B39A23DC4DA786EFF8147C4E72B9807785AFEE48BB';
        $stmt->bind_param('s', $id);
        if (!$stmt->execute()) {
            http_response_code(500);
            $stmt->close();
            $mysqli->close();
            die('Error in the select statement ' . $stmt->errno);
        } else {            
            $stmt->bind_result($downloadable);
            $stmt->fetch();
            if ($downloadable)
            {
                $url = "presentation_access.php?presentation_code=" . $id;
                ?>                
                    <main role="main" class="container-fluid">
                        <button type="button" class="btn btn-primary" onclick="location.href = '<?php echo $url ?>'";>Download</button>
                    </main>
                <?php
            }
        }
        $stmt->close();
    }
?>
