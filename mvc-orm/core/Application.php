<?php

namespace core;

use core\Exceptions\RouterException;

/**
 * Class Application
 * @package core
 */
class Application {
    public static function run() {
        $configurator = Configurator::config('routes');
        try {
            Router::route($configurator->routes);
        } catch (RouterException $re) {
            echo "404!";
        }
    }
}