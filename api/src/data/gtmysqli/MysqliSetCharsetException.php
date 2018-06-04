<?php
namespace data\gtmysqli;

/**
 * This class will be thrown when failing on attempt to change the charset for the mysqli connection
 * @author David Campos R. <david.campos.r96@gmail.com>
 */
MysqliSetCharsetException extends \Exception {}