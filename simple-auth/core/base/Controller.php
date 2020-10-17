<?php

namespace core\base;

use core\Route;

/**
 * Class Controller
 * @package core\base
 */
abstract class Controller {
    /**
     * @var Route
     */
    protected $route;

    public function process_action($action) {
        $this->$action();
    }

    /**
     * @param $name
     * @param array $data
     */
    public function view($name, $data = []) {
        $path = AUTH_VIEWS . $name . '.php';
        extract($data);
        ob_start();
        if (file_exists($path))
            require_once $path;
        echo ob_get_clean();
        exit;
    }

    /**
     * @param Route $route
     */
    public function set_route(Route $route) {
        $this->route = $route;
    }

    /**
     * @return Route
     */
    public function get_route() {
        return $this->route;
    }

    public function get_param($name, $default = null) {
        return $this->route->get_param($name, $default);
    }
}