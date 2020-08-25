<?php

/**
 * Display errors on
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Define directories and separator of directories
 */
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__, 2));
define('APP_DIR', ROOT . DS . 'app' . DS);
define('CORE_DIR', ROOT . DS . 'core' . DS);
define('VIEW_DIR', APP_DIR . DS . 'views' . DS);
define('CONFIG_DIR', ROOT . DS . 'config' . DS);

/**
 * Autoload classes
 */
spl_autoload_register(function ( $class_name ){
     $path = ROOT . DS . str_replace('\\', DS, $class_name)  . '.php';
     if ( file_exists( $path ) )
         require_once $path;
});

/**
 * Render Application
 */
\core\Application::run();