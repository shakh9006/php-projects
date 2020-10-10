<?php

namespace core;
use core\Exceptions\RouterException;

/**
 * Class Router
 * @package core
 */
class Router {
    /**
     * @param $routes
     * @throws
     */
    public static function route($routes) {
       foreach ($routes as $route) {
           if ( $route->match() ) {
               $action = $route->getAction();
               $controller = $route->getController();
               self::navigate($action, $controller, $route);
           }
       }
    }

    /**
     * @param $action
     * @param $controller
     * @param array $route
     * @return boolean|mixed
     * @throws RouterException
     */
    public static function navigate($action, $controller, $route) {
        if ($controller) {
            $ctrl = new $controller;
            if ( !empty($ctrl) && method_exists($ctrl, $action) ) {
                $ctrl->setRoute($route);
                $ctrl->processAction($action);
                return true;
            }
        }
        throw new RouterException('Method not found!');
    }
}