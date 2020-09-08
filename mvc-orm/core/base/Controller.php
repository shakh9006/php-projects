<?php

namespace core\base;

/**
 * Class Controller
 * @package core\base
 */
abstract class Controller {
    /**
     * @param $action
     * @param array $data
     */
    public function processAction($action, $data = []) {
        call_user_func_array([$this, $action], $data);
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
}