<?php

/**
 * Display errors on
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Define all directory roots and directory separator
 */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__, 2));
define('ROOT_APP', ROOT . DS . 'app' . DS);
define('ROOT_CORE', ROOT . DS . 'core' . DS);
define('ROOT_PUBLIC', dirname(__FILE__));
define('ROOT_VIEW', ROOT_APP . 'views' . DS);

/**
 * Autoload classes
 */
require_once ROOT . DS . 'vendor' . DS . 'autoload.php';
spl_autoload_register(function ($class_name) {
    $path = ROOT . DS . str_replace('\\', DS, $class_name) . '.php';
    if ( file_exists( $path ) ) {
        require_once $path;
    }
});

\core\Application::run();