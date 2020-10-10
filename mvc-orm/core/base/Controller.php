<?php

namespace core\base;

use core\Route;

/**
 * Class Controller
 * @package core\base
 */
abstract class Controller {

    const REDIRECT = 'redirect:';
    const HEADER_LOCATION = 'Location';
    const HEADER_CONTENT_TYPE = 'Content-Type';
    private $route;

    /**
     * @param $action
     * @param $route
     * @return mixed
     */
    public function processAction($action) {
        $data = $this->$action();
        if ( $this->hasInstruction($data) )
            return "";
        return $data;
    }

    /**
     * @param $name
     * @param array $data
     */
    public function view($name, $data = []) {
        $path = VIEWS_PATH . $name . '.php';
        extract($data);
        ob_start();
        if (file_exists($path))
          require_once $path;
        echo ob_get_clean();
        exit;
    }

    /**
     * @return Route
     */
    public function getRoute() {
        return $this->route;
    }

    /**
     * @param Route $route
     */
    public function setRoute(Route $route) {
        $this->route = $route;
    }

    /**
     * @param $name
     * @param $default
     * @return mixed
     */
    public function getParam($name, $default = null) {
        return $this->route->getParam($name, $default);
    }

    /**
     * @param $data
     * @return bool
     */
    public function hasInstruction($data) {
        if ( ! is_string( $data ) )
            return false;

        if ( self::REDIRECT === substr($data, 0, strlen(self::REDIRECT)) ) {
            $redirect_url = substr($data, strlen(self::REDIRECT));
            $redirect_url = $redirect_url === 'back' ? $_SERVER['HTTP_REFERER'] : $redirect_url;
            $this->header(self::HEADER_LOCATION, $redirect_url);
        }

        return true;
    }

    /**
     * @param $name
     * @param $value
     */
    public function header($name, $value) {
        header("$name: $value");
        exit;
    }

    public function header404() {
        $this->header(self::HEADER_LOCATION, '/404');
    }

}