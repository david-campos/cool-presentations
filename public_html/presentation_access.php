<?php
    require dirname(__FILE__) . '/../include/database_connection.php';
    
    if(!isset($_GET['presentation_code'])) {
        http_response_code(400);
        die('Presentation code not received.');
    }
    
    $code = $_GET['presentation_code'];
    
    if(preg_match('/^[0-9a-fA-F]{64}$/', $code)!==1) {
        http_response_code(400);
        die('Invalid code.');
    }
    
    $stmt = $mysqli->prepare('SELECT access_code FROM presentations WHERE id_code=? LIMIT 1');        
    $stmt->bind_param('s', $code);

    if (!$stmt->execute()) {
        http_response_code(500);
        $stmt->close();
        $mysqli->close();
        die('Error cannot get access_code ' . $stmt->errno);
    } else {
        $stmt->bind_result($access_code_db);
        if(!$stmt->fetch()) {
            http_response_code(404);
            $stmt->close();
            $mysqli->close();
            die('Error: presentation couldn\'t be found.');
        }
        $stmt->close();
        $mysqli->close();
        
        if($access_code_db !== null) {
            if(!isset($_GET['access_code'])) {
                http_response_code(400);
                die('Access code not received.');
            }
            
            $access_code = $_GET['access_code'];
            if(preg_match('/^[0-9a-fA-F]{128}$/', $access_code)!==1) {
                http_response_code(400);
                die('Invalid code. '. strlen($access_code));
            }
            
            if ($access_code !== $access_code_db) {                
                http_response_code(403);
                die("Incorrect access code");
            }
        }
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
    } else {
        http_response_code(500);
        die('Internal server error. File not found.');
    }
?>