<?php
    require dirname(__FILE__) . '/../include/database_connection.php';
    if(!isset($_GET['presentation_code'])) {
        http_response_status(400);
        die('Presentation code not received.');
    }
    
    if(!isset($_GET['access_code'])) {
        http_response_status(400);
        die('Access code not received.');
    }
    
    $code = $_GET['presentation_code'];
    $access_code = $_GET['access_code'];
    
    if(preg_match('/^[0-9a-fA-F]{64}$/', $code)!==1) {
        http_response_status(400);
        die('Invalid code.');
    }

    if (strcmp($access_code, "false") !== 0)
    {
        $stmt = $mysqli->prepare('SELECT access_code FROM presentations WHERE id_code=? LIMIT 1');        
        $stmt->bind_param('s', $code);

        if (!$stmt->execute()) {
            http_response_code(500);
            $stmt->close();
            $mysqli->close();
            die('Error cannot get access_code ' . $stmt->errno);
        } else {
            $stmt->bind_result($access_code_db);
            $stmt->fetch();
            if ($access_code == $access_code_db) {                
                http_response_status(403);
            }
        }
        $stmt->close();
        $mysqli->close();
    }
        
    $file = '../uploaded_pdfs/'.$code.'.pdf';

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }
?>