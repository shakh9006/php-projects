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
     * @param $data
     * @throws
     */
    public static function route($routes, $data = []) {
       foreach ($routes as $route) {
           if ($route->match()) {
               $action = $route->getAction();
               $controller = $route->getController();
               self::navigate($action, $controller, $data);
           }
       }
    }

    /**
     * @param $action
     * @param $controller
     * @param array $data
     * @throws RouterException
     */
    public static function navigate($action, $controller, $data = []) {
        if ($controller) {
            $ctrl = new $controller;
            if (method_exists($ctrl, $action)) {
                $ctrl->processAction($action, $data);
                return;
            }
        }
        throw new RouterException('Method not found!');
    }
}