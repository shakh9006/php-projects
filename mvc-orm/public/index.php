<?php

/**
 * Display errors on
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/**
 * Define Paths and Directory Separator
 */

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__, 2));

define('APP_PATH', ROOT . DS . 'app' . DS);
define('VIEWS_PATH', APP_PATH . 'views' . DS);
define('CONFIG_PATH', ROOT . DS . 'config' . DS);

spl_autoload_register( function ($className) {
    $path = ROOT . DS . str_replace('\\', '/', $className) . '.php';
    if (file_exists($path))
        require_once $path;
});

\core\Application::run();