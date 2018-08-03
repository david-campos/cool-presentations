<?php
/**
 * @author David Campos Rodríguez <david.campos.r96@gmail.com>
 */

namespace data\gtmysqli;

use mysqli;
use data\InternalDatabaseException;
use data\PresentationNotFoundException;
use domain\Auxiliar;

class MysqliPresentationsGateway {
    /**
     * @var mysqli $mysqli mysqli connection received from the parent
     */
    private $mysqli;

    /**
     * MysqliPresentationsGateway constructor.
     * @param mysqli $mysqli mysqli connection created and ready
     */
    public function __construct(mysqli $mysqli) {
        $this->mysqli = $mysqli;
    }

    /**
     * Get's the presentations for the time and location given
     * @param string $time the time for which we want to search presentations (probably current time)
     * @param double $lat the latitude where we want to find them
     * @param double $lon the longitude where we want to find them
     * @param double $precissionMeters precission in meters
     * @return array
     */
    public function getPresentationsForTimeAndLocation($time, $lat, $lon, $precissionMeters) {
        $presentations =  $this->getPresentationsWhere(
            'start_timestamp <= ? '.
            'AND end_timestamp >= ?',
            'ss', [&$time, &$time]
        );

        $filtered = [];
        // We filter this in php, should implement it on MySQL tho ^^'
        foreach($presentations as $presentation) {
            $presLat = $presentation['location']['lat'];
            $presLon = $presentation['location']['lon'];
            $dist = Auxiliar::haversineGreatCircleDistance($lat, $lon, $presLat, $presLon);
            if($dist <= $precissionMeters) {
                $filtered[] = $presentation;
            }
        }
        return $presentations;
    }

    /**
     * Get's the presentation info for the requested presentation
     * @param string $presentationCode the code identifying the presentation
     * @return mixed
     */
    public function getPresentation($presentationCode) {
        $presentations = $this->getPresentationsWhere('id_code=? LIMIT 1', 's', [&$presentationCode]);
        if(count($presentations)<1) {
            throw new PresentationNotFoundException("Couldn't find presentation $presentationCode");
        }
        return $presentations[0];
    }

    /**
     * @param string $where the where string
     * @param string $paramTypes the param types for the binding
     * @param array $params an array with references to the variables with the values for the params
     * @return array
     */
    private function getPresentationsWhere($where, $paramTypes, $params) {
        $presentations = [];

        $stmt = $this->mysqli->prepare(
            'SELECT id_code,name,start_timestamp,end_timestamp,location_lat,location_lon,downloadable,user_id,
            IF(access_code IS NULL, 0, 1) AS access_code_required
            FROM presentations WHERE '.$where);
        if(!$stmt) {
            throw new InternalDatabaseException('Error in the question query preparation ' . $this->mysqli->error, $this->mysqli->errno);
        }
        try {
            call_user_func_array([$stmt, 'bind_param'],array_merge([$paramTypes],$params));
            if (!$stmt->execute()) {
                throw new InternalDatabaseException('Error in the question query ' . $stmt->error, $stmt->errno);
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
}