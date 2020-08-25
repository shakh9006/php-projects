<?php

namespace core\router;

use core\exceptions\RouterException;

/**
 * Class Router
 * @package core\router
 */
class Router {
    public static $routes = [];

    /**
     * Router route.
     * @param array $routes
     * @throws
     * @return boolean
     */
    public static function route( array $routes) {
        self::$routes = $routes;
        foreach ( self::$routes as $route ) {
            if ( $route->match() ) {
                $controller = $route->getControllerName();
                $action = $route->getActionName();
                self::navigate($controller, $action);
                return true;
            }
        }
        throw new RouterException;
    }

    /**
     * @param $controller
     * @param $action
     * @throws
     */
    public static function navigate ($controller, $action) {
        if ( ! ( class_exists( $controller ) && method_exists($controller, $action) ) )
            throw new RouterException;

        $ctrl = new $controller;
        $ctrl->execAction($action);
    }
}