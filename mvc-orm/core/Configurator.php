<?php

namespace core;

/**
 * Class Configurator
 * @package core
 */
class Configurator {

    private static $config = [];

    /**
     * @param $name
     * @return Configurator
     */
    public static function config($name) {
        $path = CONFIG_PATH . $name . '.php';
        if (file_exists($path))
        self::$config = require_once $path;

        return new self();
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        // TODO: Implement __get() method.
        if (isset(self::$config[$name]))
            return self::$config[$name];

        return null;
    } 
}