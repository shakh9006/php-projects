<?php

namespace core;

/**
 * Class Route
 * @package core
 */
class Route {
    private $data;
    private $component_uri = [];
    const ACTION_NAME     = 'indexAction';
    const CONTROLLER_NAME = 'MainController';

    const PARAM_REGEXP = '/\{\??([a-z][a-z0-9]*)\}/i';
    const OPT_PARAM_REGEXP = '/\{\?([a-z][a-z0-9]*)\}/i';

    /**
     * Route constructor.
     * @param $uri
     * @param $data
     */
    public function __construct($uri, $data = [])
    {
        $this->data = $data;
        $this->component_uri = explode('/', trim($uri, '/'));
    }

    /**
     * @param $name
     * @param $value
     * @return boolean
     */
    public function isParam($name, $value) {
        if ( ! preg_match(self::PARAM_REGEXP, $name, $arr ) )
            return false;
        $param_name = $arr[1];
        $this->data[$param_name] = $value;
        return true;
    }

    /**
     * @param $name
     * @return bool
     */
    public function isTmpParam($name) {
        return preg_match( self::OPT_PARAM_REGEXP, $name ) ;
    }

     /**
     * @return string|null
     */
    public function getController() {
        $controller_name = isset($this->data['controller']) ? $this->data['controller'] : self::CONTROLLER_NAME;
        $path = '\app\controllers\\'. $controller_name;
        if ( class_exists($path) )
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
        $uri_component = explode( '/', trim(($pos === false ? $uri : substr($uri, 0, $pos)),  '/'));

        if (count($uri_component) > count($this->component_uri))
            return false;

        foreach ($this->component_uri as $index => $current) {
            if ( isset($uri_component[$index]) && $uri_component[$index] === $current )
                continue;

            if ( empty($uri_component[$index]) && $this->isTmpParam($current) )
                return true;

            if ( empty($uri_component[$index]) )
                return false;

            if ( ! $this->isParam($current, $uri_component[$index]) )
                return  false;
        }

        return true;
    }

    /**
     * @param $name
     * @param null $default
     * @return mixed|null
     */
    public function getParam($name, $default = null) {
        if (isset($this->data[$name]))
            return $this->data[$name];

        return $default;
    }
}