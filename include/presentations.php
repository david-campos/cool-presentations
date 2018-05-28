<?php
require_once dirname(__FILE__) . '/database_connection.php';

class PresentationNotFoundException extends Exception {}
class PresentationPasswordError extends Exception {}

/**
 * Get's the presentation info for the requested presentation (by GET params)
 */
function get_presentation_info($presentationCode) {
    global $mysqli;
    
    $stmt = $mysqli->prepare(
        'SELECT name,start_timestamp,end_timestamp,location_lat,location_lon,downloadable,user_id,
            IF(access_code IS NULL, 0, 1) AS access_code_required
            FROM presentations WHERE id_code=? LIMIT 1');
    if(!$stmt) {
        throw new Exception('Error in the question query preparation ' . $mysqli->error, $mysqli->errno);
    }
    try {
        $stmt->bind_param('s',$presentationCode);
        if (!$stmt->execute()) {
            throw new Exception('Error in the question query ' . $stmt->error, $stmt->errno);
        }
        $stmt->bind_result($name,$start,$end,$lat,$lon,$download,$userId,$req_code);
        if($stmt->fetch()) {
            $presentation = [
                'id_code' => $presentationCode,
                'name' => $name,
                'start_timestamp' => $start,
                'end_timestamp' => $end,
                'access_code' => $req_code?true:false,
                'location' => ['lat'=>$lat, 'lon'=>$lon],
                'downloadable' => $download?true:false,
                'author' => $userId
            ];
        } else {
            throw new PresentationNotFoundException("Couldn't find presentation $presentationCode");
        }
    } finally {
        $stmt->close();
    }
    return $presentation;
}