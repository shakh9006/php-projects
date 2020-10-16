<?php

namespace core;

use core\Route;

/**
 * Class Router
 * @package core
 */
class Router {
    public static function route() {
        $routes = Route::get_routes();
        foreach ($routes as $uri => $route) {
            if ($route->match()) {

            }
        }
    }
}