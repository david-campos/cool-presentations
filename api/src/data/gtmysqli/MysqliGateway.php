<?php
namespace data\gtmysqli;

use mysqli;

/**
 * MysqliGateway class. Abstract class which is the base for all the
 * mysqli gateways, it handles the connection to mysqli and supplies
 * for basic methods to work with it.
 * @author David Campos R. <david.campos.r96@gmail.com>
 */
abstract class MysqliGateway {
    /** @var string */
    const DATABASE_NAME = 'database1';
    /** @var mysqli */
    protected $mysqli;
    
    /**
     * Constructor of the class. Gets the mysqli link to operate with the database
     * whose name is defined in the constant DATABASE_NAME.
     * @throws MysqliConnectionException if unable to create the mysqli object
     * @throws MysqliSetCharsetException if unable to set the charset to utf8
     */
    public function __construct() {
        $mysqli = new mysqli(
            ini_get('mysqli.default_host'),
            ini_get('mysqli.default_user'),
            ini_get('mysqli.default_pw'),
            DATABASE_NAME
        );
        
        if ($mysqli->connect_error) {
            throw new MysqliConnectionException(
                $mysqli->connect_error, $mysqli->connect_errno);
        }
        
        if (!$mysqli->set_charset('utf8')) {
            throw new MysqliSetCharsetException(
                'Error loading charset utf8: '.$mysqli->error, $mysqli->errno);
        }
    }
}