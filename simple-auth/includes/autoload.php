<?php
/**
 * Register namespaces
 */
spl_autoload_register(function ($class) {
    $path = AUTH_PATH . '/' . str_replace('\\', '/', $class) . '.php';
    if ( file_exists($path) )
        require_once $path;
});
/**
 * Load helper functions
 */
require_once AUTH_PATH . '/includes/config.php';
require_once AUTH_PATH . '/includes/functions.php';
require_once AUTH_PATH . '/config/routes.php';