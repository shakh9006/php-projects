<?php

namespace core;

use core\exception\RouteException;
/**
 * Class Route
 * @package core
 */
class Route {

    const CONTROLLER_NAMESPACE = '\application\controllers\\';
    const PARAM_REGEXP = '/\{\??([a-z][a-z0-9]*)\}/i';
    const OPT_PARAM_REGEXP = '/\{\?([a-z][a-z0-9]*)\}/i';
    /**
     * @var array
     */
    private static $routes = [];

    /**
     * @var
     */
    private $uri;

    public $data = [];

    /**
     * @var array
     */
    private $route_data = [];

    /**
     * Route constructor.
     * @param $uri
     * @param $data
     */
    public function __construct($uri, $data) {
        $this->route_data = $data;
        $this->uri        = explode('/', trim($uri, '/'));;
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
     * Route class add_route method.
     * @param $uri
     * @param $arguments
     * @throws
     */
    public static function add_route($uri, $arguments) {
        $uri = trim($uri);
        if ( is_array($arguments) ) {
            $args = $arguments;
            $action     = $args['action'];
            $controller = $args['controller'];
        } elseif ( is_string($arguments) && strpos( $arguments , '@') !== false) {
            list($controller, $action) = explode('@', $arguments);
        } else {
            throw new RouteException('Incorrect params of Router');
        }

        self::$routes[$uri] = new self($uri, [ 'controller' => $controller, 'action' => $action]);
    }

    /**
     * Get routes GET method
     * @return array
     */
    public static function get_routes() {
        return self::$routes;
    }

    /**
     * @param $data
     * get controller and action name
     * @return array
     */
    public function implode_keys($data) {
        if (isset($data['action']) && isset($data['controller'])) {
            return [$data['controller'], $data['action']];
        }
        return ['MainController', '404'];
    }

    /**
     * @return bool
     */
    public function match() {
        $uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($uri, '?');
        $uri_component = explode( '/', trim(($pos === false ? $uri : substr($uri, 0, $pos)),  '/'));

        if (count($uri_component) > count($this->uri))
            return false;

        foreach ($this->uri as $index => $current) {
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
     * Get name of controller
     * @return string
     */
    public function get_controller() {
        if ( isset($this->route_data['controller']) ) {
            $controller = self::CONTROLLER_NAMESPACE . $this->route_data['controller'];
            if ( class_exists( $controller ) )
                return $controller;
        }

        return '';
    }

    /**
     * Get name of action
     * @return string
     */
    public function get_action() {
        if ( isset($this->route_data['action']) ) {
            return $this->route_data['action'];
        }

        return '';
    }

    /**
     * @param $name
     * @param $default
     * @return mixed|null
     */
    public function get_param($name, $default) {
        if (isset($this->data[$name]))
            return $this->data[$name];

        return $default;
    }
}