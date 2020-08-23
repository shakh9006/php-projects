<?php

namespace core;

abstract class Model {
    private $store = [];

    public function __set($name, $value)
    {
        // TODO: Implement __set() method.
        $this->store[$name] = $value;
    }

    public function __get($name)
    {
        // TODO: Implement __get() method.
        if ( isset( $this->store[$name] ) ) {
            return $this->store[$name];
        }

        return '';
    }


}