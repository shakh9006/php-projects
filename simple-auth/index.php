<?php
/**
 * Welcome!
 * This is simple auth project =).
 */
use core\Application;
/**
 * Define Paths
 */
define('AUTH_PATH', dirname(__FILE__));
/**
 * Load autoloader
 */
require_once AUTH_PATH . '/includes/autoload.php';

/**
 * Define url of web-site
 */
define( 'SITE_URL', site_url() );

/**
 * Run Project
 */
Application::run();