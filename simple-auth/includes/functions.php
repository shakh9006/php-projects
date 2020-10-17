<?php

/**
 * Display Errors
 */

if ( !function_exists('debugger') ) {
    function debugger() {
        if ( defined('DEBUG') && DEBUG === true )  {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }

    debugger();
}

if ( !function_exists('auth_assets') ) {
    /**
     * @param $file_path
     * @return string
     */
    function auth_assets($file_path) {
        return SITE_URL . 'assets/' . $file_path;
    }
}

if ( !function_exists('site_url') )  {
    /**
     * Get site url
     * @return string
     */
    function site_url() {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        return $protocol . $_SERVER['HTTP_HOST'].'/';
    }
}