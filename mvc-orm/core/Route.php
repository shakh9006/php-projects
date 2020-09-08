<?php

namespace core;

/**
 * Class Route
 * @package core
 */
class Route {
    private $data  = [];
    private $uri   = null;
    const ACTION_NAME     = 'indexAction';
    const CONTROLLER_NAME = 'MainController';

    /**
     * Route constructor.
     * @param $uri
     * @param $data
     */
    public function __construct($uri, $data)
    {
        $this->uri = $uri;
        $this->data = $data;
    }

    /**
     * @return string|null
     */
    public function getController() {
        $controller_name = isset($this->data['controller']) ? $this->data['controller'] : self::CONTROLLER_NAME;
        $path = '\app\controllers\\'. $controller_name;
        if (class_exists($path))
            return $path;
        return null;
    }

    /**
     * @return mixed|string
     */
    public function getAction() {
        return isset($this->data['action']) ? $this->data['action'] : self::ACTION_NAME;
    }

    /**
     * @return bool
     */
    public function match() {
        $uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($uri, '?');
        return ($pos === false ? $uri : substr($uri, 0, $pos)) === $this->uri;
    }
}