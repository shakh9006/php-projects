<?php

namespace core;

class Application {
    private static $controller = 'HomeController';
    private static $action = 'indexAction';

    /**
     * init function
     */
    public static function run() {
        $url = self::parseUrl();

        if ( ! empty( $url[0] ) ) {
            self::$controller = ucfirst($url[0]) . 'Controller';
            array_shift($url);
        }

        $controller = '\app\controllers\\' . self::$controller;
        if ( ! class_exists( $controller ) ) {
            echo "404!";
            exit;
        }
        self::$controller = new $controller;

        if ( ! empty( $url[0] ) ) {
            self::$action = strtolower( $url[0] ) . 'Action';
            array_shift( $url );
        }

        if ( method_exists( self::$controller, self::$action ) )
            self::$controller->execAction( self::$action, $url );
    }

    /**
     * Parse uri and call needle action of Controller
     */
    private static function parseUrl() {
       return explode( '/', filter_var( trim( $_SERVER['REQUEST_URI'], '/') ) );
    }
}