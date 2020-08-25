<?php

namespace core;

/**
 * Class Configurator
 * @package core
 */
class Configurator {
    private $data = [];

    /**
     * Configurator constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $path = CONFIG_DIR . $name . '.php';
        if ( file_exists($path) ) {
            $this->data = require_once $path;
        }
    }

    /**
     * @param $name
     * @return mixed|string
     */
    public function __get($name)
    {
        // TODO: Implement __get() method.
        if ( isset( $this->data[$name] ) ) {
            return $this->data[$name];
        }

        return '';
    }
}