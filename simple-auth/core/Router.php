<?php

namespace core;

use base\exception\RouterException;

/**
 * Class Router
 * @package core
 */
class Router {
    /**
     * @throws RouterException
     */
    public static function route() {
        $routes = Route::get_routes();
        foreach ($routes as $uri => $route) {
            if ($route->match()) {
                self::navigate($route);
            }
        }
    }

    /**
     * @param $route
     * @return bool
     * @throws RouterException
     */
    public static function navigate($route) {
        $action          = $route->get_action();
        $controller_name = $route->get_controller();
        $ctrl            = new $controller_name;

        if ( !empty($ctrl) && method_exists($ctrl, $action) ) {
            $ctrl->set_route($route);
            $ctrl->process_action($action);
            return true;
        }

        throw new RouterException('No method or controller');
    }
}