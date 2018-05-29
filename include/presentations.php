<?php
require_once dirname(__FILE__) . '/database_connection.php';

class PresentationNotFoundException extends Exception {}
class PresentationPasswordError extends Exception {}

/**
 * Get's the presentations for the time and location given
 */
function getPresentationsForTimeAndLocation($time, $lat, $lon, $precissionMeters) {
    global $mysqli;
    
    $presentations =  get_presentations_where(
        'start_timestamp <= ? '.
        'AND end_timestamp >= ?',
        'ss', [&$time, &$time]
    );
    
    $filtered = [];
    // We filter this in php, should implement it on MySQL tho ^^'
    foreach($presentations as $presentation) {
        $presLat = $presentation['location']['lat'];
        $presLon = $presentation['location']['lon'];
        $dist = haversineGreatCircleDistance($lat, $lon, $presLat, $presLon);
        if($dist <= $precissionMeters) {
            $filtered[] = $presentation;
        }
    }
    return $presentations;
}

/**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * @param float $latitudeFrom Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo Latitude of target point in [deg decimal]
 * @param float $longitudeTo Longitude of target point in [deg decimal]
 * @param float $earthRadius Mean earth radius in [m]
 * @return float Distance between points in [m] (same as earthRadius)
 */
function haversineGreatCircleDistance(
  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);

  $latDelta = $latTo - $latFrom;
  $lonDelta = $lonTo - $lonFrom;

  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
    cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
  return $angle * $earthRadius;
}

/**
 * Get's the presentation info for the requested presentation (by GET params)
 */
function get_presentation_info($presentationCode) {
    global $mysqli;
    
    $presentations = get_presentations_where('id_code=? LIMIT 1', 's', [&$presentationCode]);
    if(count($presentations)<1) {
        throw new PresentationNotFoundException("Couldn't find presentation $presentationCode");
    }
    return $presentations[0];
}

function get_presentations_where($where, $paramTypes, $params) {
    global $mysqli;
    
    $presentations = [];
    
    $stmt = $mysqli->prepare(
        'SELECT id_code,name,start_timestamp,end_timestamp,location_lat,location_lon,downloadable,user_id,
            IF(access_code IS NULL, 0, 1) AS access_code_required
            FROM presentations WHERE '.$where);
    if(!$stmt) {
        throw new Exception('Error in the question query preparation ' . $mysqli->error, $mysqli->errno);
    }
    try {
        call_user_func_array([$stmt, 'bind_param'],array_merge([$paramTypes],$params));
        if (!$stmt->execute()) {
            throw new Exception('Error in the question query ' . $stmt->error, $stmt->errno);
        }
        $stmt->bind_result($presentationCode,$name,$start,$end,$lat,$lon,$download,$userId,$req_code);
        while($stmt->fetch()) {
            $presentations[] = [
                'id_code' => $presentationCode,
                'name' => $name,
                'start_timestamp' => $start,
                'end_timestamp' => $end,
                'access_code' => $req_code?true:false,
                'location' => ['lat'=>$lat, 'lon'=>$lon],
                'downloadable' => $download?true:false,
                'author' => $userId
            ];
        }
    } finally {
        $stmt->close();
    }
    return $presentations;
}