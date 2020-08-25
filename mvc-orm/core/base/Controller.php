<?php

namespace core\base;

use core\base\View;

/**
 * Class Controller
 * @package core\base
 */
class Controller {

    /**
     * @param $action
     * @param array $data
     */
    public function execAction($action, $data = []) {
        call_user_func_array([$this, $action], $data);
    }

    /**
     * @param $name
     * @param array $data
     */
    public function view($name, $data = []) {
        echo View::render($name, $data);
    }
}