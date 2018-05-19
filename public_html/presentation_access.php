<?php
    if(!isset($_GET['presentation_code'])) {
        http_response_status(400);
        die('Presentation code not received.');
    }
    
    $code = $_GET['presentation_code'];
    
    if(preg_match('/^[0-9a-fA-F]{64}$/', $code)!==1) {
        http_response_status(400);
        die('Invalid code.');
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