<?php
/**
 * @author David Campos Rodríguez <david.campos.r96@gmail.com>
 */

namespace data;
use data\gtmysqli\MysqliGatewayFactory;

/**
 * Class GatewayFactory from the abstract factory pattern which allow the application to abstract from the
 * underlying database specifics
 * @package gateways
 */
abstract class GatewayFactory {
    /** @var GatewayFactory */
    private static $instance = null;

    /**
     * Gets the single instance of the gateway factory
     * @return GatewayFactory
     */
    public static function getInstance(): GatewayFactory {
        if(static::$instance === null) {
            static::$instance = new MysqliGatewayFactory();
        }
        return static::$instance;
    }

    /**
     * Starts a new database transaction (if possible)
     * @param bool $readWrite param to indicate whether it is a READ-WRITE transaction or not
     * @return
     */
    public abstract function startTransaction($readWrite=false);
    /**
     * Commits the database transaction
     */
    public abstract function commit();
    /**
     * Rollback the database transaction
     */
    public abstract function rollback();

    /**
     * GatewayFactory constructor. Private by "singleton-like" pattern
     */
    private function __construct() {}
}