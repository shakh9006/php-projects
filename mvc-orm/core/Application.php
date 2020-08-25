<?php

namespace core;

use core\exceptions\RouterException;
use core\router\Router;

/**
 * Class Application
 * @package core
 */
class Application {

    /**
     * @throws exceptions\RouterException
     */
    public static function run() {
        $config = new Configurator('routes');
        try {
            Router::route($config->routes);
        } catch (RouterException $e) {
            echo "404!";
        }
    }
}