<?php
/**
 * @author David Campos Rodríguez <david.campos.r96@gmail.com>
 */

namespace data\gtmysqli;

use mysqli;

class MysqliGatewayFactory extends data\GatewayFactory {
    /** @var string */
    const DATABASE_NAME = 'database1';
    /** @var mysqli */
    private $mysqli;

    /**
     * MysqliGatewayFactory constructor.
     */
    public function __construct() {
        $this->mysqli = new mysqli(
            ini_get('mysqli.default_host'),
            ini_get('mysqli.default_user'),
            ini_get('mysqli.default_pw'),
            static::DATABASE_NAME
        );

        if ($this->mysqli->connect_error) {
            throw new MysqliConnectionException('Database connection error (' . $this->mysqli->connect_errno . ') '
                . $this->mysqli->connect_error);
        }
        $this->mysqli->autocommit(false);
        if (!$this->mysqli->set_charset("utf8")) {
            throw new MysqliSetCharsetException('Error loading charset utf8: '.$this->mysqli->error);
        }
    }

    /**
     * Starts a new database transaction (if possible)
     * @param bool $readWrite
     */
    public function startTransaction($readWrite=false) {
        if($this->mysqli->server_version >= 50605) {
            $this->mysqli->begin_transaction($readWrite ? MYSQLI_TRANS_START_READ_WRITE : MYSQLI_TRANS_START_READ_ONLY);
        } else {
            // From Ral's answer on 'http://www.php.net/manual/en/mysqli.begin-transaction.php':
            // MariaDB prefixes its server version numbers with "5.5.5-" for example
            // "5.5.5-10.3.7-MariaDB-1:10.3.7+maria~stretch". This is because oracle mysql would interpet the
            // "10" as version 1. Mysql clients aware of MariaDB have been updated to detect and strip this prefix.
            //
            // However the check for mysqli.begin-transaction sees the 5.5.5 prefix and so fails.
            //
            // The workaround is to specify a custom version string without the prefix for MariaDB on the command
            // line using the --version option. Then mysqli.begin-transaction functions as expected.

            $warningMsg = 'WARNING: The MySQL server version in use doesn\'t support \'READ WRITE\''.
                'and \'READ ONLY\'. Minimum 5.6.5 is required. Yor server version is '.$this->mysqli->server_info.'.';
            if(strpos($this->mysqli->server_info, 'MariaDB') !== false) {
                $warningMsg .=
                    ' Since you are using MariaDB, notice the following: MariaDB prefixes its server version '.
                    'numbers with "5.5.5-", for example "5.5.5-10.3.7-MariaDB". Mysql '.
                    'clients aware of MariaDB have been updated to detect and strip this prefix. However the '.
                    'check for mysqli.begin-transaction sees the 5.5.5 prefix and so fails. The workaround is '.
                    'to specify a custom version string without the prefix for MariaDB on the command line using '.
                    'the --version option.';
            }
            error_log($warningMsg);
            $this->mysqli->begin_transaction();
        }
    }

    /**
     * Commits the database transaction
     */
    public function commit() {
        $this->mysqli->commit();
    }

    /**
     * Rollback the database transaction
     */
    public function rollback() {
        $this->mysqli->rollback();
    }
}