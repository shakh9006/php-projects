<?php

namespace core\router;

class Route {
    private $data = [];
    private $uri;

    /**
     * Route constructor.
     * @param $uri
     * @param array $data
     */
    public function __construct( $uri, array $data = [] )
    {
        $this->uri = $uri;
        $this->data = $data;
    }

    public function getControllerName() {
        $namespace = '\app\controllers\\';
        return isset( $this->data['controller'] )
            ?  $namespace . ucfirst($this->data['controller'])
            :  $namespace . 'MainController';
    }

    public function getActionName() {
        return isset( $this->data['action'] ) ? strtolower($this->data['action']) . 'Action' : 'indexAction';
    }

    /**
     * @return bool
     */
    public function match() {
        $uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($uri, '?');
        return trim( ($pos === false ? $uri : substr($uri, 0, $pos) ), '/' )  === $this->uri;
    }
}