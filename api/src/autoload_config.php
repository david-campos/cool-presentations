<?php
/**
 * This file configurates the autoloading of the php classes
 * so we can work correctly with the classes without
 * having to include lots of files everywhere.
 * @author David Campos R. <david.campos.r96@gmail.com>
 */

// Defines for directories
define('CLASS_DIR',  realpath(dirname(__FILE__)));
define('TEST_DIR',  realpath(dirname(__FILE__).'/../srcTest/'));

// Changes to the include path of autoload
set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);
// For unitary tests
set_include_path(get_include_path().PATH_SEPARATOR.TEST_DIR);

// Extension
spl_autoload_extensions('.php');

// Register autoload
spl_autoload_register();